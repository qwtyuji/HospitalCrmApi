<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Hospital
 * @package App
 */
class Hospital extends Model
{
    /**
     * @var array
     */
    protected $fillable=['name','description','status','author'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function department()
    {
        return $this->hasMany(Department::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function disease()
    {
        return $this->hasManyThrough(Disease::class,Department::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user()
    {
        return $this->hasMany(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function doctor()
    {
        return $this->hasManyThrough(Doctor::class,Department::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function media()
    {
        return $this->hasMany(Media::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function patient()
    {
        return $this->hasMany(Patient::class);
    }

}
