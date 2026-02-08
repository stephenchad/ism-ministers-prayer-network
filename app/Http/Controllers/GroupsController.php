<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupsController extends Controller
{
    // This method will show Groups page
    public function index(Request $request)
    {
        $groups = Group::where('status', 1)
            ->with('category', 'user')
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        // Force HTML response even if JSON is requested
        return response()
            ->view('front.groups', ['groups' => $groups])
            ->header('Content-Type', 'text/html');
    }
}
