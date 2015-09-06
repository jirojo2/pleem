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

        // Event related abilities
        $gate->define('create-event', function($user) {
            return true;
        });
        $gate->define('edit-event', function($user, $event) {
            return $user->roleForEvent($event) === App\Member::ROLE_ADMIN;
        });
        $gate->define('destroy-event', function($user, $event) {
            return $user->roleForEvent($event) === App\Member::ROLE_ADMIN;
        });

        // Event group related abilities
        $gate->define('create-group', function($user, $event) {
            return $user->roleForEvent($event) === App\Member::ROLE_ADMIN;
        });
        $gate->define('edit-group', function($user, $group) {
            return $user->roleForEvent($group->event) === App\Member::ROLE_ADMIN;
        });
        $gate->define('destroy-group', function($user, $group) {
            return $user->roleForEvent($group->event) === App\Member::ROLE_ADMIN;
        });

        // LC related abilities
        $gate->define('create-lc', function($user, $lc) {
            return true;
        });
        $gate->define('edit-lc', function($user, $lc) {
            return true;
        });
        $gate->define('destroy-lc', function($user, $lc) {
            return true;
        });

        // Member related abilities
        $gate->define('create-member', function($user, $member) {
            return true;
        });
        $gate->define('edit-member', function($user, $member) {
            return true;
        });
        $gate->define('destroy-member', function($user, $member) {
            return true;
        });
    }
}
