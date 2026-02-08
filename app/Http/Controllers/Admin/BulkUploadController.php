<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BulkUpload;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\BulkUploadCompleted;

class BulkUploadController extends Controller
{
    public function index()
    {
        $uploads = BulkUpload::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.bulk-uploads.index', compact('uploads'));
    }

    public function create()
    {
        // List of models available for bulk upload
        $models = [
            'User' => 'User',
            // Add other models here as needed
        ];
        return view('admin.bulk-uploads.create', compact('models'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'model_type' => 'required|string',
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('bulk_uploads', $fileName);

        $bulkUpload = BulkUpload::create([
            'file_name' => $fileName,
            'model_type' => $request->model_type,
            'status' => 'pending',
            'uploaded_by' => Auth::id(),
        ]);

        // Process CSV file
        $errors = $this->processCsv($filePath, $request->model_type);

        if (count($errors) > 0) {
            $bulkUpload->update([
                'status' => 'failed',
                'error_log' => $errors,
            ]);
            return redirect()->route('admin.bulk-uploads.show', $bulkUpload->id)
                ->with('error', 'Upload failed with errors.');
        } else {
            $bulkUpload->update(['status' => 'completed']);

            // Notify admins
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new BulkUploadCompleted($bulkUpload));
            }

            return redirect()->route('admin.bulk-uploads.show', $bulkUpload->id)
                ->with('success', 'Upload completed successfully.');
        }
    }

    private function processCsv($filePath, $modelType)
    {
        $errors = [];
        $fullPath = storage_path('app/' . $filePath);

        if (!file_exists($fullPath)) {
            $errors[] = 'File not found.';
            return $errors;
        }

        $handle = fopen($fullPath, 'r');
        if ($handle === false) {
            $errors[] = 'Unable to open file.';
            return $errors;
        }

        $header = null;
        $rowNumber = 1;

        DB::beginTransaction();

        try {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header) {
                    $header = $row;
                    $rowNumber++;
                    continue;
                }

                $data = array_combine($header, $row);

                // Validate and insert based on model type
                if ($modelType === 'User') {
                    $validator = Validator::make($data, [
                        'name' => 'required|string|max:255',
                        'email' => 'required|email|unique:users,email',
                        'password' => 'required|string|min:6',
                    ]);

                    if ($validator->fails()) {
                        $errors[] = "Row $rowNumber: " . implode(', ', $validator->errors()->all());
                    } else {
                        // Hash password before insert
                        $data['password'] = bcrypt($data['password']);
                        User::create($data);
                    }
                } else {
                    $errors[] = "Unsupported model type: $modelType";
                    break;
                }

                $rowNumber++;
            }

            if (count($errors) > 0) {
                DB::rollBack();
            } else {
                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $errors[] = 'Exception: ' . $e->getMessage();
        }

        fclose($handle);

        return $errors;
    }

    public function show($id)
    {
        $upload = BulkUpload::findOrFail($id);
        return view('admin.bulk-uploads.show', compact('upload'));
    }
}
