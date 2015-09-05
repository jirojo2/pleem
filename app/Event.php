<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * Get the LC that owns the event.
     */
    public function lc()
    {
        return $this->belongsTo(LC::class);
    }

    /**
     * Get the event members.
     */
    public function members()
    {
        return $this->belongsToMany(Member::class, 'event_members')->withPivot('role');
    }

    // Helpers... move to controller?

    /**
     * Get the event applicants.
     */
    public function applicants()
    {
        return $this->members()->wherePivot('role', '=', Member::ROLE_APPLICANT)->get();
    }

    /**
     * Get the event participants.
     */
    public function participants()
    {
        return $this->members()->wherePivot('role', '=', Member::ROLE_PARTICIPANT)->get();
    }

    /**
     * Get the event judges.
     */
    public function judges()
    {
        return $this->members()->wherePivot('role', '=', Member::ROLE_JUDGE)->get();
    }

    /**
     * Get the event organizers.
     */
    public function organizers()
    {
        return $this->members()->wherePivot('role', '=', Member::ROLE_ORGANIZER)->get();
    }

    /**
     * Get the event admins.
     */
    public function admins()
    {
        return $this->members()->wherePivot('role', '=', Member::ROLE_ADMIN)->get();
    }
}
