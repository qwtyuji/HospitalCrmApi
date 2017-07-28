<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Department
 * @package App
 */
class Department extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'description', 'status', 'author'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function disease()
    {
        return $this->hasMany(Disease::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function doctor()
    {
        return $this->hasMany(Doctor::class);
    }
}
