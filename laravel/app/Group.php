<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    protected $fillable = ['name'];

    /**
     * Get the event that owns the group.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the members that compose this group.
     */
    public function members()
    {
        return $this->belongsToMany(Member::Class, 'event_members')->withPivot('role');
    }

    /**
     * Get the scores issued for this group.
     */
    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}
