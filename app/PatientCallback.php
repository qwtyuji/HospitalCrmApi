<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PatientCallback
 * @package App
 */
class PatientCallback extends Model
{
    /**
     * @var string
     */
    protected $table = 'patient_callback';
    /**
     * @var array
     */
    protected $fillable = ['patient_id', 'user_id', 'content'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class)->select('id','name');
    }
}
