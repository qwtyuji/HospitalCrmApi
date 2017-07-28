<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PatientRemark
 * @package App
 */
class PatientRemark extends Model
{
    /**
     * @var string
     */
    protected $table = 'patient_remark';
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
