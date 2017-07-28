<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Patient
 * @package App
 */
class Patient extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'sex', 'age', 'phone', 'doctor_id', 'user_id', 'hospital_id', 'department_id', 'disease_id', 'depart_id', 'media_id', 'area', 'order_time', 'status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function patientCallback()
    {
        return $this->hasMany(PatientCallback::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function patientContent()
    {
        return $this->hasMany(PatientContent::class);

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function patientLog()
    {
        return $this->hasMany(PatientLog::class);

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function patientRemark()
    {
        return $this->hasMany(PatientRemark::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function depart()
    {
        return $this->belongsTo(Depart::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function disease()
    {
        return $this->belongsTo(Disease::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
