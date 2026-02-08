<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupRule;
use App\Models\GroupEvent;
use App\Models\GroupPhoto;
use App\Models\GroupResource;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreGroupRuleRequest;
use App\Http\Requests\UpdateGroupRuleRequest;
use App\Http\Requests\StoreGroupEventRequest;
use App\Http\Requests\UpdateGroupEventRequest;
use App\Http\Requests\DestroyGroupEventRequest;
use App\Http\Requests\DestroyGroupRuleRequest;
use App\Http\Requests\StoreGroupResourceRequest;
use App\Http\Requests\UpdateGroupResourceRequest;
use App\Http\Requests\DestroyGroupResourceRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class GroupSettingsController extends Controller
{
    public function storeRule(StoreGroupRuleRequest $request)
    {
        GroupRule::create($request->validated());

        return back()->with('success', 'Rule added successfully.');
    }

    public function updateRule(UpdateGroupRuleRequest $request, GroupRule $rule)
    {
        $rule->update($request->validated());

        return back()->with('success', 'Rule updated successfully.');
    }

    public function destroyRule(DestroyGroupRuleRequest $request, GroupRule $rule)
    {
        $rule->delete();

        return back()->with('success', 'Rule deleted successfully.');
    }

    public function storeEvent(StoreGroupEventRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = auth()->id();
        GroupEvent::create($validatedData);

        return back()->with('success', 'Event added successfully.');
    }

    public function updateEvent(UpdateGroupEventRequest $request, GroupEvent $event)
    {
        $event->update($request->validated());

        return back()->with('success', 'Event updated successfully.');
    }

    public function destroyEvent(DestroyGroupEventRequest $request, GroupEvent $event)
    {
        $event->delete();

        return back()->with('success', 'Event deleted successfully.');
    }

    public function storePhoto(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'group_id' => 'required|exists:groups,id',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('group_photos', 'public');

            GroupPhoto::create([
                'group_id' => $request->group_id,
                'path' => $path,
                'caption' => $request->caption,
            ]);

            return response()->json(['status' => true, 'message' => 'Photo uploaded successfully.']);
        }

        return response()->json(['status' => false, 'message' => 'No photo uploaded.']);
    }

    public function destroyPhoto($id)
    {
        $photo = GroupPhoto::findOrFail($id);
        $group = $photo->group;

        // Use a policy to check if the user can delete the photo
        Gate::authorize('managePhotos', $group);

        // Delete the file from storage
        Storage::disk('public')->delete($photo->path);

        // Delete the record from the database
        $photo->delete();

        return back()->with('success', 'Photo deleted successfully.');
    }

    public function storeResource(StoreGroupResourceRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = auth()->id();
        GroupResource::create($validatedData);

        return back()->with('success', 'Resource added successfully.');
    }

    public function updateResource(UpdateGroupResourceRequest $request, GroupResource $resource)
    {
        $resource->update($request->validated());

        return back()->with('success', 'Resource updated successfully.');
    }

    public function destroyResource(DestroyGroupResourceRequest $request, GroupResource $resource)
    {
        $resource->delete();

        return back()->with('success', 'Resource deleted successfully.');
    }
}
