<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Discussion;
use App\Models\GroupRule;
use App\Models\GroupPhoto;
use App\Models\GroupResource;
use App\Notifications\NewGroupCreated;
use App\Models\Event;
use App\Models\Group;
use App\Models\GroupType;
use App\Models\User;
use App\Models\Country;
use App\Models\City;
use App\Notifications\PromotedToGroupLeader;
use App\Notifications\AdminAddedNewEvent;
use App\Notifications\RemovedFromGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::with(['user', 'country', 'city'])->paginate(10);
        return view('admin.groups.list', compact('groups'));
    }

    public function transferOwnership(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'new_owner_id' => 'required|exists:users,id',
        ]);

        $group = Group::findOrFail($request->group_id);
        $newOwner = User::findOrFail($request->new_owner_id);
        $oldOwner = $group->user;

        if (!$group->members->contains($newOwner->id)) {
            return redirect()->back()->with('error', 'The selected user is not a member of this group.');
        }

        if ($newOwner->id === $group->user_id) {
            return redirect()->back()->with('error', 'This user is already the coordinator.');
        }

        $group->user_id = $newOwner->id;
        $group->save();

        $group->leaders()->syncWithoutDetaching([$newOwner->id]);
        $group->leaders()->detach($oldOwner->id);

        return redirect()->back()->with('success', "Ownership has been successfully transferred to {$newOwner->name}.");
    }

    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $groupTypes = GroupType::orderBy('name', 'ASC')->where('status', 1)->get();
        $users = User::orderBy('name', 'ASC')->get();
        $countries = Country::orderBy('name', 'ASC')->get();
        return view('admin.groups.create', compact('categories', 'groupTypes', 'users', 'countries'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5|max:200',
            'category_name' => 'required|string|max:255',
            'group_type_name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'nullable|max:255',
            'description' => 'required',
            'max_members' => 'required|integer|min:1',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.groups.create')
                ->withErrors($validator)
                ->withInput();
        }

        $group = new Group();
        $group->title = $request->title;
        // Find or create category
        $category = Category::firstOrCreate(['name' => $request->category_name]);

        // Find or create group type
        $groupType = GroupType::firstOrCreate(['name' => $request->group_type_name]);

        $group->category_id = $category->id;
        $group->group_type_id = $groupType->id;
        $group->country_id = $request->country_id;
        $group->city_id = $request->city_id;
        $group->address = $request->address;
        $group->description = $request->description;
        $group->max_members = $request->max_members;
        $group->current_members = 1; // The owner is the first member
        $group->user_id = $request->user_id;
        $group->save();

        // Attach the owner to the members list
        $group->members()->attach($request->user_id);

        // Notify all users except the admin creating the group
        $usersToNotify = User::where('id', '!=', auth()->id())->get();
        Notification::send($usersToNotify, new NewGroupCreated($group));

        return redirect()->route('admin.groups')->with('success', 'Group has been created successfully.');
    }

    public function edit($id)
    {
        $group = Group::findOrFail($id);
        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $groupTypes = GroupType::orderBy('name', 'ASC')->where('status', 1)->get();
        $users = User::orderBy('name', 'ASC')->get();
        $countries = Country::orderBy('name', 'ASC')->get();
        return view('admin.groups.edit', compact('group', 'categories', 'groupTypes', 'users', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5|max:200',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'nullable|max:255',
            'description' => 'required',
        ]);

        if ($validator->passes()) {
            $group->update($request->only(['title', 'country_id', 'city_id', 'address', 'description']));

            session()->flash('success', 'Group updated successfully.');

            return response()->json([
                'status' => true,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy(Group $group)
    {
        $group->delete();
        // The response should be consistent. Redirecting might be better if the AJAX call expects it.
        return response()->json(['status' => true, 'message' => 'Group deleted successfully.']);
    }

    public function show($id)
    {
        $group = Group::with(['category', 'user', 'discussions.user', 'discussions.replies.user', 'members', 'leaders', 'rules', 'events', 'photos', 'resources'])->findOrFail($id);

        $sortedMembers = $group->members->sortBy(function ($member) use ($group) {
            if ($group->user_id == $member->id)
                return 0; // Owner
            if ($group->leaders->contains($member->id))
                return 1; // Leader
            return 2; // Member
        })->values();

        return view('admin.groups.show', compact('group', 'sortedMembers'));
    }

    public function promoteLeader(Request $request)
    {
        $group = Group::findOrFail($request->group_id);
        $user = User::findOrFail($request->user_id);

        if (!$group->members->contains($user->id)) {
            return redirect()->back()->with('error', 'This user is not a member of the group.');
        }

        $group->leaders()->syncWithoutDetaching([$user->id]);
        $user->notify(new PromotedToGroupLeader($group));

        return redirect()->back()->with('success', $user->name . ' has been promoted to a group leader.');
    }

    public function demoteLeader(Request $request)
    {
        $group = Group::findOrFail($request->group_id);
        $user = User::findOrFail($request->user_id);

        $group->leaders()->detach($user->id);

        return redirect()->back()->with('success', $user->name . ' is no longer a group leader.');
    }

    public function removeMember(Request $request)
    {
        $group = Group::findOrFail($request->group_id);
        $userToRemove = User::findOrFail($request->user_id);

        if ($userToRemove->id === $group->user_id) {
            return redirect()->back()->with('error', 'The group coordinator cannot be removed. Transfer coordinator first.');
        }

        $group->members()->detach($userToRemove->id);
        $group->leaders()->detach($userToRemove->id);
        $group->decrement('current_members');

        $userToRemove->notify(new RemovedFromGroup($group));

        return redirect()->back()->with('success', $userToRemove->name . ' has been removed from the group.');
    }

    public function transferCoordinator(Request $request)
    {
        $group = Group::findOrFail($request->group_id);
        $newOwner = User::findOrFail($request->new_owner_id);
        $oldOwner = $group->user;

        if (!$group->members->contains($newOwner->id)) {
            return redirect()->back()->with('error', 'The selected user is not a member of this group.');
        }

        if ($newOwner->id === $group->user_id) {
            return redirect()->back()->with('error', 'This user is already the coordinator.');
        }

        $group->user_id = $newOwner->id;
        $group->save();

        $group->leaders()->syncWithoutDetaching([$newOwner->id]);
        $group->leaders()->detach($oldOwner->id);

        return redirect()->back()->with('success', "Coordinator has been successfully transferred to {$newOwner->name}.");
    }

    public function destroyDiscussion(Request $request)
    {
        $request->validate([
            'discussion_id' => 'required|exists:discussions,id',
        ]);

        $discussion = Discussion::findOrFail($request->discussion_id);
        $discussion->replies()->delete(); // Delete all associated replies
        $discussion->delete();

        return redirect()->back()->with('success', 'Discussion has been deleted successfully.');
    }

    public function destroyEvent(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
        ]);

        $event = Event::findOrFail($request->event_id);

        // Delete image if it exists
        if ($event->image && Storage::disk('public')->exists($event->image)) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->back()->with('success', 'Event has been deleted successfully.');
    }

    public function storeEvent(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $group = Group::findOrFail($request->group_id);

        $event = $group->events()->create([
            'title' => $request->title,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'location' => $request->location,
            'user_id' => auth()->id(), // The admin is the creator
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('group_events', 'public');
            $event->image = $path;
            $event->save();
        }
        // Notify all group members about the new event
        $members = $group->members;
        if ($members->isNotEmpty()) {
            Notification::send($members, new AdminAddedNewEvent($group, $event));
        }

        return redirect()->back()->with('success', 'Event created successfully.');
    }

    public function updateEvent(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $event = Event::findOrFail($request->event_id);

        $data = $request->only(['title', 'description', 'event_date', 'location']);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($event->image && Storage::disk('public')->exists($event->image)) {
                Storage::disk('public')->delete($event->image);
            }
            $data['image'] = $request->file('image')->store('group_events', 'public');
        }
        $event->update($data);

        return redirect()->back()->with('success', 'Event updated successfully.');
    }

    public function storePhoto(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);

        $path = $request->file('photo')->store('group_photos', 'public');

        GroupPhoto::create([
            'group_id' => $request->group_id,
            'user_id' => auth()->id(),
            'path' => $path,
            'caption' => $request->caption,
        ]);

        return redirect()->back()->with('success', 'Photo uploaded successfully.');
    }

    public function destroyPhoto(Request $request)
    {
        $request->validate([
            'photo_id' => 'required|exists:group_photos,id',
        ]);

        $photo = GroupPhoto::findOrFail($request->photo_id);

        // Delete the file from storage
        Storage::disk('public')->delete($photo->path);

        $photo->delete();

        return redirect()->back()->with('success', 'Photo has been deleted successfully.');
    }

    public function storeResource(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'title' => 'required|string|max:255',
            'link' => 'required|url',
            'description' => 'nullable|string',
        ]);

        GroupResource::create($request->all());

        return redirect()->back()->with('success', 'Resource added successfully.');
    }

    public function destroyResource(Request $request)
    {
        $request->validate([
            'resource_id' => 'required|exists:group_resources,id',
        ]);

        $resource = GroupResource::findOrFail($request->resource_id);
        $resource->delete();

        return redirect()->back()->with('success', 'Resource has been deleted successfully.');
    }

    public function storeRule(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'rule' => 'required|string|max:1000',
        ]);

        GroupRule::create($request->all());

        return redirect()->back()->with('success', 'Rule added successfully.');
    }

    public function updateRule(Request $request)
    {
        $request->validate([
            'rule_id' => 'required|exists:group_rules,id',
            'rule' => 'required|string|max:1000',
        ]);

        $rule = GroupRule::findOrFail($request->rule_id);
        $rule->update(['rule' => $request->rule]);

        return redirect()->back()->with('success', 'Rule updated successfully.');
    }

    public function destroyRule(Request $request)
    {
        $request->validate([
            'rule_id' => 'required|exists:group_rules,id',
        ]);

        $rule = GroupRule::findOrFail($request->rule_id);
        $rule->delete();

        return redirect()->back()->with('success', 'Rule has been deleted successfully.');
    }

    public function promoteToCoordinator(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        $groupsLedCount = $user->groupsLed()->count();
        $totalMembers = $user->getTotalMembersInLedGroups();
        $promotedLeadersCount = $user->getPromotedLeadersCount();

        // Determine the highest level the user qualifies for
        $level = 0;
        $title = '';
        if ($groupsLedCount >= 20 && $totalMembers >= 200 && $promotedLeadersCount >= 7) {
            $level = 3;
            $title = 'Master Coordinator';
        } elseif ($groupsLedCount >= 10 && $totalMembers >= 100 && $promotedLeadersCount >= 3) {
            $level = 2;
            $title = 'Senior Coordinator';
        } elseif ($groupsLedCount >= 5 && $totalMembers >= 50 && $promotedLeadersCount >= 0) {
            $level = 1;
            $title = 'Junior Coordinator';
        }

        if ($level == 0) {
            return redirect()->back()->with('error', "User does not meet the minimum promotion criteria. Requires at least 5 groups and 50 members.");
        }

        // Check if user is already a coordinator
        $existingCoordinator = \App\Models\Coordinator::where('email', $user->email)->first();
        if ($existingCoordinator) {
            // Update the existing coordinator to the new level if higher
            if ($existingCoordinator->title != $title) {
                $existingCoordinator->update(['title' => $title, 'description' => "Updated to {$title} from Group Leader"]);
                // Send notification to the user
                $user->notify(new \App\Notifications\PromotedToCoordinator($user, $title));
                return redirect()->back()->with('success', "{$user->name} has been promoted to {$title}.");
            }
            return redirect()->back()->with('info', 'User is already a coordinator at this level.');
        }

        // Create new coordinator record
        \App\Models\Coordinator::create([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->mobile,
            'is_active' => true,
            'title' => $title,
            'description' => 'Promoted from Group Leader',
            'availability' => 'Available',
            'image' => null,
            'sort_order' => 0,
        ]);

        // Send notification to the promoted user
        $user->notify(new \App\Notifications\PromotedToCoordinator($user, $title));

        // Collect all members, leaders, and coordinators from the groups the user leads
        $groupsLed = $user->groupsLed;
        $notifyUsers = collect();

        foreach ($groupsLed as $group) {
            // Add members
            $notifyUsers = $notifyUsers->merge($group->members);
            // Add leaders
            $notifyUsers = $notifyUsers->merge($group->leaders);
        }

        // Remove duplicates and the promoted user themselves
        $notifyUsers = $notifyUsers->unique('id')->reject(function ($notifyUser) use ($user) {
            return $notifyUser->id === $user->id;
        });

        // Send notification to all relevant users
        \Illuminate\Support\Facades\Notification::send($notifyUsers, new \App\Notifications\GroupLeaderPromotedToCoordinator($user, $title));

        return redirect()->back()->with('success', "{$user->name} has been promoted to {$title}.");
    }

    public function getCities(Request $request)
    {
        $countryId = $request->country_id;
        $country = Country::find($countryId);
        if ($country) {
            $cities = $country->cities()->orderBy('name', 'ASC')->get();
            return response()->json($cities);
        }
        return response()->json([]);
    }
}
