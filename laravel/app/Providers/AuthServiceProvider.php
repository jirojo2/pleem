<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        parent::registerPolicies($gate);

        $gate->before(function ($user, $ability) {
            if ($user->admin) {
                return true;
            }
        });

        // ContentTools
        $gate->define('save-page', function($user) {
            return $user->admin;
        });

        // Config
        $gate->define('view-config', function($user) {
            return $user->admin;
        });
        $gate->define('set-config', function($user) {
            return $user->admin;
        });

        // Event group related abilities
        $gate->define('create-group', function($user) {
            return true;
        });
        $gate->define('edit-group', function($user, $group) {
            return $group->members->contains($user);
        });
        $gate->define('destroy-group', function($user, $group) {
            return $group->members->contains($user);
        });

        // Member related abilities
        $gate->define('attach-member', function($user, $group) {
            return $group->members->contains($user);
        });
        $gate->define('edit-member', function($user) {
            return true;
        });
        $gate->define('destroy-member', function($user) {
            return true;
        });
        $gate->define('view-cv', function($user, $member) {
            if ($user->admin)
                return true;
            if ($user->judge)
                return true;
            return $member->group->id == $user->group->id;
        });
        $gate->define('upload-cv', function($user, $member) {
            if ($user->admin)
                return true;
            return $member->group->id == $user->group->id;
        });

        // Group Score related abilities
        $gate->define('group-private-scores', function($user, $group) {
            // check if user's member is a jury for that event
            return true;
        });
    }
}
