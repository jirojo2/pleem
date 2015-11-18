<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    protected $fillable = ['name'];

    /**
     * Get the members that compose this group.
     */
    public function members()
    {
        return $this->hasMany(Member::Class);
    }

    /**
     * Get the scores issued for this group.
     */
    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    /**
     * Get the idea submited by this group.
     */
    public function idea()
    {
        return $this->hasOne(Idea::class);
    }
}
