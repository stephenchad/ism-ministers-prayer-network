<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\Group::class => \App\Policies\GroupPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('manageMembers', function ($user, $group) {
            // Allow group owner to manage members
            if ($group->user_id === $user->id) {
                return true;
            }
            // Optionally, allow group leaders to manage members
            if ($group->leaders->contains($user->id)) {
                return true;
            }
            // Optionally, allow admins to manage members
            if ($user->role === 'admin') {
                return true;
            }
            return false;
        });
    }
}
