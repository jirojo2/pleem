<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
	// Roles
	const ROLE_APPLICANT   = 'applicant';
	const ROLE_PARTICIPANT = 'participant';
	const ROLE_JUDGE       = 'judge';
	const ROLE_ORGANIZER   = 'organizer';
	const ROLE_ADMIN       = 'admin';

    /**
     * Get the groups where this member participates.
     */
    public function groups()
    {
        return $this->belongsToMany('App\Group', 'event_members');
    }

    /**
     * Get the events where this member participates.
     */
    public function events()
    {
        return $this->belongsToMany('App\Event', 'event_members')->withPivot('role');
    }
}
