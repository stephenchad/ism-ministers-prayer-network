<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{ 
    //
    public function index() {

        $users = User::with('referrals')->orderBy('created_at', 'DESC')->paginate(10);

        return view('admin.users.list', [

            'users' => $users

        ]);
    }

    public function create() {
        return view('admin.users.create');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:user,admin',
            'designation' => 'nullable|max:50',
            'mobile' => 'nullable|max:20',
        ]);

        if ($validator->passes()) {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'designation' => $request->designation,
                'mobile' => $request->mobile,
            ]);

            return redirect()->route('admin.users')->with('success', 'User created successfully!');
        }

        return redirect()->back()->withErrors($validator)->withInput();
    }

    public function edit($id){

        $user = User::findOrFail($id);
        return view('admin.users.edit', [

            'user' => $user
            
        ]);

    }

    public function update($id, Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users,email,'.$id.',id',
            'role' => 'required|in:user,admin',
            'designation' => 'nullable|max:50',
            'mobile' => 'nullable|max:20',
        ]);

        if ($validator->passes()) {

            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->designation = $request->designation;
            $user->mobile = $request->mobile;
            $user->save();

            session()->flash('success', 'User information has been updated successfully.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);

        } else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);

        }

    }

    public function destroy(Request $request) {

        $id = $request->id;

        $user = User::find($id);

        if ($user == null) {

            session()->flash('error', 'User not found');

            return response()->json([
                'status' => false,
            ]);

        }

        $user->delete();

        session()->flash('success', 'User deleted successfully');

        return response()->json([

            'status' => true,

        ]);

    }

    public function toggleAdmin(Request $request) {
        $id = $request->id;
        $role = $request->role;

        $user = User::find($id);

        if ($user == null) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ]);
        }

        $user->role = $role;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'User role updated successfully'
        ]);
    }

    public function referrals() {
        $users = User::with('referrals')->whereHas('referrals')->orWhere('referred_by', '!=', null)->orderBy('created_at', 'DESC')->paginate(10);

        return view('admin.referrals.index', [
            'users' => $users
        ]);
    }

    public function editReferral($id) {
        $user = User::with('referrals', 'referrer')->findOrFail($id);

        return view('admin.referrals.edit', [
            'user' => $user
        ]);
    }

    public function updateReferral($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'referral_code' => 'required|string|unique:users,referral_code,'.$id.',id',
            'referred_by' => 'nullable|exists:users,id',
        ]);

        if ($validator->passes()) {
            $user = User::find($id);
            $user->referral_code = $request->referral_code;
            $user->referred_by = $request->referred_by;
            $user->save();

            return redirect()->route('admin.referrals')->with('success', 'Referral information updated successfully!');
        }

        return redirect()->back()->withErrors($validator)->withInput();
    }

    public function resetReferralCode(Request $request) {
        $id = $request->id;

        $user = User::find($id);

        if ($user == null) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ]);
        }

        $user->referral_code = 'REF' . strtoupper(md5(uniqid()));
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Referral code reset successfully',
            'new_code' => $user->referral_code
        ]);
    }
}
