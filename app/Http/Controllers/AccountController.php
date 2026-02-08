<?php

namespace App\Http\Controllers; // This was likely incorrect before, ensure it is this value.

use App\Models\Category;
use App\Models\GroupType;
use App\Models\Group;
use App\Models\Country;
use App\Models\City;
use App\Notifications\UserCreatedNewGroup;
use App\Notifications\RemovedFromGroup;
use App\Notifications\PromotedToGroupLeader;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    private function isLeaderInAnyGroup($userId)
    {
        return DB::table('group_user')->where('user_id', $userId)->where('is_leader', true)->exists();
    }

    // This method will show user registration page
    public function registration()
    {
        return view('front.account.registration');

    }

    // This method will save a user in the database
    public function processRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|same:confirm_password',
            'confirm_password' => 'required',
            'designation' => 'required',
            'mobile' => 'required',
            'birthday' => 'nullable|date|before:today',

        ]);
        if ($validator->passes()) {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->designation = $request->designation;
            $user->mobile = $request->mobile;
            $user->birthday = $request->birthday;

            // Handle referral
            if ($request->has('referral_code') && !empty($request->referral_code)) {
                $referrer = User::where('referral_code', $request->referral_code)->first();
                if ($referrer) {
                    $user->referred_by = $referrer->id;
                }
            }

            $user->save();

            // Generate unique referral code after saving
            $user->referral_code = 'REF' . strtoupper(substr(md5($user->id . $user->email), 0, 8));
            $user->save();

            // Set leader_level based on referral
            if (isset($referrer) && $this->isLeaderInAnyGroup($referrer->id)) {
                $user->leader_level = 1; // Set to level 1 if referrer is a leader
            } else {
                $user->leader_level = 0; // Default level
            }
            $user->save();

            // Notify the referrer about the new referral
            if (isset($referrer)) {
                $referrer->notify(new \App\Notifications\NewReferralNotification($user));
            }

            session()->flash('success', 'Your account has been created successfully.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    // This method will show login page
    public function login()
    {
        return view('front.account.login');
    }


    public function authenticate(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'email' => 'required',

            'password' => 'required',

        ]);


        if ($validator->passes()) {

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->has('remember'))) {

                return redirect()->route('account.profile');

            } else {
                return redirect()->route('account.login')->with('error', 'Either Email / Password is incorrect');
            }

        } else {
            return redirect()->route('account.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

    }

    // Social login methods
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            // Check if user already exists with this provider_id
            $user = User::where('provider_id', $socialUser->getId())->first();

            if (!$user) {
                // Check if user exists with same email
                $user = User::where('email', $socialUser->getEmail())->first();

                if ($user) {
                    // Link the social account to existing user
                    $user->provider = $provider;
                    $user->provider_id = $socialUser->getId();
                    $user->save();
                } else {
                    // Create new user
                    $user = User::create([
                        'name' => $socialUser->getName(),
                        'email' => $socialUser->getEmail(),
                        'provider' => $provider,
                        'provider_id' => $socialUser->getId(),
                        'password' => Hash::make(Str::random(32)), // Random password for social users
                    ]);

                    // Generate referral code
                    $user->referral_code = 'REF' . strtoupper(substr(md5($user->id . $user->email), 0, 8));
                    $user->leader_level = 0; // Default level for social users
                    $user->save();
                }
            }

            Auth::login($user);

            // Notify admins about social login
            $admins = User::where('role', 'admin')->get();
            Notification::send($admins, new \App\Notifications\SocialMediaActivityNotification($user, $provider, 'login'));

            return redirect()->route('account.profile');
        } catch (\Exception $e) {
            return redirect()->route('account.login')->with('error', 'Unable to login with ' . ucfirst($provider));
        }
    }


    public function profile()
    {
        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        $notifications = $user->notifications()->paginate(10);

        return view('front.account.profile', [
            'user' => $user,
            'notifications' => $notifications

        ]);
    }

    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:20',
            'email' => 'required|email|unique:users,email,' . $id . ',id',
            'designation' => 'nullable|min:5|max:50',
            'mobile' => 'required|min:5|max:50',
            'birthday' => 'nullable|date|before:today',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->passes()) {

            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->designation = $request->designation;
            $user->mobile = $request->mobile;
            $user->birthday = $request->birthday;
            $user->save();

            // Handle profile picture upload
            if ($request->hasFile('image')) {
                $image = $request->image;
                $ext = $image->getClientOriginalExtension();
                $imageName = $id . '-' . time() . '.' . $ext;
                $image->move(public_path('/profile_pic/'), $imageName);

                // Create a small thumbnail
                $sourcePath = public_path('/profile_pic/' . $imageName);
                $manager = new ImageManager(Driver::class);
                $image = $manager->read($sourcePath);
                $image->cover(150, 150);
                $image->toPng()->save(public_path('/profile_pic/thumb/' . $imageName));

                // Delete Old Profile Pic
                File::delete(public_path('/profile_pic/thumb/' . Auth::user()->image));
                File::delete(public_path('/profile_pic/' . Auth::user()->image));

                $user->image = $imageName;
                $user->save();
            }

            session()->flash('success', 'Your profile has been updated successfully.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);

        }

    }

    public function updateProfilePic(Request $request)
    {

        $id = Auth::user()->id;

        $validator = Validator::make($request->all(), [

            'image' => 'required|image'

        ]);

        if ($validator->passes()) {

            // Ensure directories exist
            if (!File::exists(public_path('profile_pic'))) {
                File::makeDirectory(public_path('profile_pic'), 0755, true);
            }
            if (!File::exists(public_path('profile_pic/thumb'))) {
                File::makeDirectory(public_path('profile_pic/thumb'), 0755, true);
            }

            $image = $request->image;

            $ext = $image->getClientOriginalExtension();

            $imageName = $id . '-' . time() . '.' . $ext;

            $image->move(public_path('/profile_pic/'), $imageName);


            // Create a small thumbnail
            $sourcePath = public_path('/profile_pic/' . $imageName);
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($sourcePath);


            // Crop the best fitting 5 : 3 (600 x 360) ratio and resize  to 600 X 360 pixel
            $image->cover(150, 150);
            $image->toPng()->save(public_path('/profile_pic/thumb/' . $imageName));

            // Delete Old Profile Pic

            File::delete(public_path('/profile_pic/thumb/' . Auth::user()->image));
            File::delete(public_path('/profile_pic/' . Auth::user()->image));



            $user = User::findOrFail($id);
            $user->image = $imageName;
            $user->save();

            session()->flash('success', 'Profile picture updated successfully.');

            return response()->json([
                'status' => true,
                'imageUrl' => asset('profile_pic/thumb/' . $imageName),
                'errors' => []
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }

    public function createGroup()
    {

        $categories = Category::orderBy('name', 'ASC')->where(['status' => 1])->get();

        $groupTypes = GroupType::orderBy('name', 'ASC')->where(['status' => 1])->get();

        $countries = Country::orderBy('name', 'ASC')->get();

        return view('front.account.group.create', [

            'categories' => $categories,
            'groupTypes' => $groupTypes,
            'countries' => $countries

        ]);
    }

    public function saveGroup(Request $request)
    {

        $rules = [
            'title' => 'required|min:5|max:200',
            'category' => 'required',
            'group_type' => 'required',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required',
            'description' => 'required',
            'max_members' => 'required',
            'current_members' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            try {
                $group = new Group();
                $group->title = $request->title;
                $group->category_id = $request->category;
                $group->group_type_id = $request->group_type;
                $group->country_id = $request->country_id;
                $group->city_id = $request->city_id;
                $group->address = $request->address;
                $group->description = $request->description;
                $group->max_members = $request->max_members;
                $group->current_members = $request->current_members;
                $group->user_id = Auth::user()->id;
                $group->save();
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'errors' => ['database' => 'Database error: ' . $e->getMessage()]
                ]);
            }

            if ($request->hasFile('image')) {
                try {
                    $path = $request->file('image')->store('group_images', 'public');
                    if ($path) {
                        $group->image = $path;
                        $group->save();
                    } else {
                        // Delete the group if image upload failed
                        $group->delete();
                        return response()->json([
                            'status' => false,
                            'errors' => ['image' => 'Failed to upload the group image. Please try again.']
                        ]);
                    }
                } catch (\Exception $e) {
                    // Delete the group if image upload failed
                    $group->delete();
                    return response()->json([
                        'status' => false,
                        'errors' => ['image' => 'An error occurred during image upload. Please try again.']
                    ]);
                }
            }

            // Attach the creator as a member
            // Also make the creator a leader by default
            $group->members()->attach(Auth::user()->id, ['is_leader' => true]);

            // Notify all admins about the new group
            $admins = User::where('role', 'admin')->get();
            Notification::send($admins, new UserCreatedNewGroup($group, Auth::user()));


            session()->flash('success', 'Your group has been created successfully.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function myGroups()
    {
        $user = Auth::user();
        // Eager load groups the user is a member of
        $groups = $user->groups()->with('category')->latest()->paginate(10);
        return view('front.account.group.my-groups', compact('groups'));
    }

    public function showGroup($id)
    {
        $group = Group::with(['category', 'user', 'discussions.user', 'discussions.replies.user', 'members', 'leaders', 'rules', 'events', 'photos', 'resources'])->findOrFail($id);

        // Sort members: owner first, then leaders, then other members alphabetically.
        $sortedMembers = $group->members->sortBy(function ($member) use ($group) {
            if ($group->user_id == $member->id)
                return 0; // Owner
            if ($group->leaders->contains($member->id))
                return 1; // Leader
            return 2; // Member
        })->values();

        return view('front.account.group.show', [
            'group' => $group,
            'sortedMembers' => $sortedMembers
        ]);
    }

    public function groupChat($id)
    {
        $group = Group::with('category', 'user')->findOrFail($id);
        return view('front.account.group.chat', [
            'group' => $group
        ]);
    }

    public function settings($id)
    {
        $group = Group::with(['rules', 'events', 'photos', 'resources'])->findOrFail($id);
        return view('front.account.group.settings', [
            'group' => $group
        ]);
    }

    public function updatePassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password'
        ]);

        if ($validator->passes()) {
            $user = User::findOrFail(Auth::user()->id);

            if (!Hash::check($request->old_password, $user->password)) {
                session()->flash('error', 'Your old password is not correct, please try again.');
                return response()->json(['status' => true]);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            session()->flash('success', 'Password updated successfully.');
            return response()->json(['status' => true]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'email_prayer' => 'nullable|boolean',
            'email_newsletter' => 'nullable|boolean',
            'public_profile' => 'nullable|boolean',
            'show_email' => 'nullable|boolean',
        ]);

        if ($validator->passes()) {
            $user->email_prayer = $request->has('email_prayer') ? 1 : 0;
            $user->email_newsletter = $request->has('email_newsletter') ? 1 : 0;
            $user->public_profile = $request->has('public_profile') ? 1 : 0;
            $user->show_email = $request->has('show_email') ? 1 : 0;
            $user->save();

            session()->flash('success', 'Settings updated successfully.');
            return response()->json(['status' => true]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function joinGroup(Request $request)
    {
        $group = Group::find($request->group_id);

        if (!$group) {
            return redirect()->back()->with('error', 'Group not found.');
        }

        $user = Auth::user();

        // Check if user is already a member
        if ($group->members()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'You are already a member of this group.');
        }

        // Check if group is full
        if ($group->members()->count() >= $group->max_members) {
            return redirect()->back()->with('error', 'This group is full and cannot accept new members.');
        }

        // Add user to the group
        $group->members()->attach($user->id);

        // Increment current_members count
        $group->increment('current_members');

        return redirect()->back()->with('success', 'You have successfully joined the group!');
    }

    public function leaveGroup(Request $request)
    {
        $group = Group::find($request->group_id);

        if (!$group) {
            return redirect()->back()->with('error', 'Group not found.');
        }

        $user = Auth::user();

        // Check if user is a member
        if (!$group->members()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'You are not a member of this group.');
        }

        // Check if the user is the coordinator of the group
        if ($group->user_id == $user->id) {
            return redirect()->back()->with('error', 'As the group coordinator, you cannot leave this group. Transfer coordinator first.');
        }

        // Remove user from the group
        $group->members()->detach($user->id);

        // Also remove from leaders if they were one
        $group->leaders()->detach($user->id);

        // Decrement current_members count
        $group->decrement('current_members');

        return redirect()->route('account.myGroups')->with('success', 'You have successfully left the group.');
    }

    public function transferCoordinator(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'group_id' => 'required|exists:groups,id',
            'new_owner_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Invalid request. Please try again.');
        }

        $group = Group::find($request->group_id);
        $user = Auth::user();
        $newOwner = User::find($request->new_owner_id);

        // 1. Check if the current user is the coordinator
        if ($group->user_id !== $user->id) {
            return redirect()->back()->with('error', 'Only the group coordinator can transfer coordinator.');
        }

        // 2. Check if the new owner is a member of the group
        if (!$group->members->contains($newOwner->id)) {
            return redirect()->back()->with('error', 'The selected user is not a member of this group.');
        }

        // 3. Check that the new coordinator is not the current coordinator
        if ($newOwner->id === $user->id) {
            return redirect()->back()->with('error', 'You are already the coordinator of this group.');
        }

        // 4. Perform the transfer
        $group->user_id = $newOwner->id;
        $group->save();

        // 5. Update leader roles
        // Add the new owner to the leaders list
        $group->leaders()->syncWithoutDetaching([$newOwner->id]);
        // Remove the old owner from the leaders list if they are not meant to be a leader anymore
        $group->leaders()->detach($user->id);

        // Update leader_level for new owner to 1 if not already set
        if ($newOwner->leader_level < 1) {
            $newOwner->leader_level = 1;
            $newOwner->save();
        }

        return redirect()->route('account.group.show', $group->id)->with('success', "Coordinator has been successfully transferred to {$newOwner->name}.");
    }

    public function editGroup($id)
    {
        $group = Group::findOrFail($id);

        Gate::authorize('update', $group);

        $categories = Category::where('status', 1)->orderBy('name')->get();
        $groupTypes = GroupType::where('status', 1)->orderBy('name')->get();
        $countries = Country::orderBy('name', 'ASC')->get();

        return view('front.account.group.edit-new', compact('group', 'categories', 'groupTypes', 'countries'));
    }

    public function updateGroup(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        Gate::authorize('update', $group);

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5|max:200',
            'description' => 'required|max:1000',
            'category_id' => 'required|exists:categories,id',
            'group_type_id' => 'required|exists:group_types,id',
            'max_members' => 'required|integer|min:' . $group->current_members,
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'nullable|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.group.edit-new', $group->id)
                ->withErrors($validator)
                ->withInput();
        }

        $validatedData = $validator->validated();

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($group->image) {
                Storage::disk('public')->delete($group->image);
            }
            $validatedData['image'] = $request->file('image')->store('group_images', 'public');
        }

        // Update the group with validated data
        $group->update($validatedData);

        return redirect()->route('account.group.show', $group->id)->with('success', 'Group details updated successfully.');
    }

    public function manageMembers(Request $request, $id)
    {
        $group = Group::with('leaders')->findOrFail($id);

        Gate::authorize('manageMembers', $group);

        $search = $request->input('search');

        $membersQuery = $group->members();

        if ($search) {
            $membersQuery = $membersQuery->where('name', 'like', '%' . $search . '%');
        }

        $members = $membersQuery->paginate(10);

        // Sort members: owner first, then leaders, then other members alphabetically.
        $sortedMembers = $members->getCollection()->sortBy(function ($member) use ($group) {
            if ($group->user_id == $member->id)
                return 0; // Owner
            if ($group->leaders->contains($member->id))
                return 1; // Leader
            return 2; // Member
        })->values();

        // Replace the collection with sorted members
        $members->setCollection($sortedMembers);

        return view('front.account.group.manage-members', [
            'group' => $group,
            'sortedMembers' => $members,
            'search' => $search,
        ]);
    }

    public function promoteLeader(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $group = Group::findOrFail($request->group_id);
        $user = User::findOrFail($request->user_id);

        // Only the coordinator can promote leaders
        if (Auth::id() !== $group->user_id) {
            return redirect()->back()->with('error', 'You are not authorized to perform this action.');
        }

        if (!$group->members->contains($user->id)) {
            return redirect()->back()->with('error', 'This user is not a member of the group.');
        }

        $group->leaders()->syncWithoutDetaching([$user->id]);

        // Send notification to the promoted user
        $user->notify(new PromotedToGroupLeader($group));

        // Update leader_level to 1 if not already set
        if ($user->leader_level < 1) {
            $user->leader_level = 1;
            $user->save();
        }

        return redirect()->back()->with('success', $user->name . ' has been promoted to a group leader.');
    }

    public function demoteLeader(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $group = Group::findOrFail($request->group_id);
        $user = User::findOrFail($request->user_id);

        // Only the coordinator can demote leaders
        if (Auth::id() !== $group->user_id) {
            return redirect()->back()->with('error', 'You are not authorized to perform this action.');
        }

        $group->leaders()->detach($user->id);

        return redirect()->back()->with('success', $user->name . ' is no longer a group leader.');
    }

    public function removeMember(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $group = Group::findOrFail($request->group_id);
        $userToRemove = User::findOrFail($request->user_id);

        Gate::authorize('manageMembers', $group);

        // Prevent coordinator from being removed
        if ($userToRemove->id === $group->user_id) {
            return redirect()->back()->with('error', 'The group coordinator cannot be removed.');
        }

        $isOwner = Auth::id() === $group->user_id;
        $isLeader = $group->leaders->contains(Auth::id());

        // Leaders can't remove other leaders or the owner. Only the owner can remove leaders.
        if ($isLeader && !$isOwner && $group->leaders->contains($userToRemove->id)) {
            return redirect()->back()->with('error', 'Leaders cannot remove other leaders.');
        }

        $group->members()->detach($userToRemove->id);
        $group->leaders()->detach($userToRemove->id); // Also remove from leaders if they were one
        $group->decrement('current_members');

        // Notify the user they have been removed
        $userToRemove->notify(new RemovedFromGroup($group));

        return redirect()->back()->with('success', $userToRemove->name . ' has been removed from the group.');
    }

    // Password Reset Methods
    public function showForgotPasswordForm()
    {
        return view('front.account.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = trim($request->input('email'));

        // Check if user exists with the email
        $userExists = \App\Models\User::where('email', $email)->exists();

        if (!$userExists) {
            return back()->withErrors(['email' => "We can't find a user with that email address."]);
        }

        $status = Password::sendResetLink(
            ['email' => $email]
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPasswordForm($token)
    {
        return view('front.account.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $email = trim($request->input('email'));

        $status = Password::reset(
            ['email' => $email, 'password' => $request->input('password'), 'password_confirmation' => $request->input('password_confirmation'), 'token' => $request->input('token')],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('account.login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function notifySocialShare(Request $request)
    {
        $request->validate([
            'provider' => 'required|string',
            'url' => 'required|url',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not authenticated']);
        }

        // Notify admins about the share
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new \App\Notifications\SocialMediaActivityNotification($user, $request->provider, 'share'));

        return response()->json(['status' => 'success']);
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