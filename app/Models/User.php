<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'designation',
        'mobile',
        'birthday',
        'role',
        'leader_level',
        'referral_code',
        'referred_by',
        'email_prayer',
        'email_newsletter',
        'public_profile',
        'show_email',
        'provider',
        'provider_id',
        'theme_preference',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthday' => 'date',
        'theme_preference' => 'string',
    ];

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_user');
    }

    public function groupsLed()
    {
        return $this->belongsToMany(Group::class, 'group_leader', 'user_id', 'group_id');
    }

    public function getTotalMembersInLedGroups()
    {
        return $this->groupsLed->sum('current_members');
    }

    public function getPromotedLeadersCount()
    {
        // Count how many of this user's leaders have become coordinators
        $leaderIds = $this->groupsLed->flatMap(function ($group) {
            return $group->leaders->pluck('id');
        })->unique();

        // Count how many of these leaders have role 'leader' or 'coordinator'
        return \App\Models\User::whereIn('id', $leaderIds)
            ->whereIn('role', ['leader', 'coordinator'])
            ->count();
    }

    public function getImageUrl()
    {
        if ($this->image) {
            return asset('profile_pic/thumb/' . $this->image);
        }

        // Return a placeholder if no image is set
        return "https://via.placeholder.com/150";
    }

    public function getMembersWhoBecameCoordinatorsCount()
    {
        $leaderIds = $this->groupsLed->flatMap(function ($group) {
            return $group->leaders->pluck('id');
        })->unique();

        return \App\Models\User::whereIn('id', $leaderIds)
            ->where('role', 'coordinator')
            ->count();
    }

    public function getLeaderLevel()
    {
        $groupsLedCount = $this->groupsLed->count();
        $totalMembers = $this->getTotalMembersInLedGroups();
        $promotedLeadersCount = $this->getPromotedLeadersCount();
        $promotedCoordinatorsCount = $this->getMembersWhoBecameCoordinatorsCount();

        if ($groupsLedCount >= 10 && $totalMembers >= 100 && $promotedLeadersCount >= 7 && $promotedCoordinatorsCount >= 3) {
            return 3;
        } elseif ($groupsLedCount >= 5 && $totalMembers >= 50 && $promotedLeadersCount >= 3 && $promotedCoordinatorsCount >= 1) {
            return 2;
        } elseif ($groupsLedCount >= 3 && $totalMembers >= 20 && $promotedLeadersCount >= 1 && $promotedCoordinatorsCount >= 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function updateLeaderLevel()
    {
        $this->leader_level = $this->getLeaderLevel();
        $this->save();
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by');
    }
}
