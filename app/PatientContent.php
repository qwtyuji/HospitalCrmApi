<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PatientContent
 * @package App
 */
class PatientContent extends Model
{
    /**
     * @var string
     */
    protected $table = 'patient_content';
    /**
     * @var array
     */
    protected $fillable = ['patient_id', 'user_id', 'chat_record', 'content'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class)->select('id','name');
    }
}
