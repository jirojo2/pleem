<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Member extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    protected $table = 'members';

    protected $fillable = ['first_name', 'last_name', 'birthdate', 'sex', 'email', 'password', 'country', 'years_study', 'study_level', 'faculty', 'department'];
    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'admin' => 'boolean',
        'judge' => 'boolean',
    ];

    /**
     * Get the groups where this member participates.
     */
    public function group()
    {
        return $this->belongsTo('App\Group');
    }
}
