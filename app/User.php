<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'avatar', 'status'];

    /**
     * @var string
     */
    protected $guard_name='api';
    /**
     * @param string $guard_name
     */
    public function setGuardName(string $guard_name)
    {
        $this->guard_name = $guard_name;
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * User constructor.
     * @param $guard_name
     */


    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function depart()
    {
        return $this->belongsTo(Depart::class);
    }

}
