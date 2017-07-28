<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PatientLog
 * @package App
 */
class PatientLog extends Model
{
    /**
     * @var string
     */
    protected $table = 'patient_log';
    /**
     * @var array
     */
    protected $fillable = ['patient_id', 'user_id', 'content'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
