<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $table = 'scores';

    protected $fillable = ['name', 'score'];

    /**
     * Get the judge that issued this score.
     */
    public function judge()
    {
        return $this->belongsTo(Member::class, 'judge_id');
    }

    /**
     * Get the group this score is issued for.
     */
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
    /**
     * Get the group's event this score is issued for.
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
