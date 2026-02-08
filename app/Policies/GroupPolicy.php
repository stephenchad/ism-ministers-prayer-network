<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the group.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Group $group)
    {
        return $user->id === $group->user_id || $group->leaders->contains($user);
    }

    /**
     * Determine whether the user can delete the group.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Group  $group
     * @return bool
     */
    public function delete(User $user, Group $group): bool
    {
        return $user->id === $group->user_id;
    }

    /**
     * Determine whether the user can manage members.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function manageMembers(User $user, Group $group)
    {
        return $user->id === $group->user_id || $group->leaders->contains($user);
    }

    /**
     * Determine whether the user can manage photos (upload/delete).
     */
    public function managePhotos(User $user, Group $group): bool
    {
        return $user->id === $group->user_id || $group->leaders->contains($user);
    }

    /**
     * Determine whether the user can manage group settings (rules, events, etc.).
     */
    public function manageSettings(User $user, Group $group): bool
    {
        return $user->id === $group->user_id || $group->leaders->contains($user);
    }
}
