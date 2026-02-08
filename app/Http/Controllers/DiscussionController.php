<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\DiscussionReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends Controller
{
    public function store(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'group_id' => 'required|exists:groups,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        $discussion = Discussion::create([
            'user_id' => Auth::id(),
            'group_id' => $request->group_id,
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return response()->json(['status' => true, 'message' => 'Discussion started successfully.', 'discussion' => $discussion]);
    }

    public function storeReply(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'discussion_id' => 'required|exists:discussions,id',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        $reply = DiscussionReply::create([
            'user_id' => Auth::id(),
            'discussion_id' => $request->discussion_id,
            'content' => $request->content,
        ]);

        $user = Auth::user();
        $userAvatarHtml = '';

        if ($user->image) {
            $userAvatarHtml = '<img src="' . asset('profile_pic/thumb/' . $user->image) . '" class="rounded-circle" style="width: 35px; height: 35px; object-fit: cover;" alt="' . $user->name . '">';
        } else {
            $userAvatarHtml = '<div style="width: 35px; height: 35px; background: #6c757d; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.8rem;">
                                ' . strtoupper(substr($user->name, 0, 1)) . '
                              </div>';
        }

        return response()->json([
            'status' => true,
            'message' => 'Reply posted successfully.',
            'reply' => $reply,
            'user_name' => $user->name,
            'user_avatar' => $userAvatarHtml
        ]);
    }
}
