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
     * @var array
     */
    protected $patientKeyName = [
        'name'          => '姓名',
        'sex'           => '性别',
        'age'           => '年龄',
        'phone'         => '电话',
        'doctor_id'     => '医生',
        'user_id'       => '客服',
        'hospital_id'   => '医院',
        'department_id' => '科室',
        'disease_id'    => '疾病',
        'depart_id'     => '部门',
        'media_id'      => '媒体',
        'area'          => '区域',
        'order_time'    => '预约时间',
        'status'        => '状态',
    ];
    /**
     * @var array
     */
    protected $patientFieldRead = ['name', 'sex', 'age', 'phone', 'status'];
    /**
     * @var array
     */
    protected $patientFieldransform = ['doctor_id', 'user_id', 'hospital_id', 'department_id', 'disease_id', 'depart_id', 'media_id',];
    /**
     * @var array
     */
    protected $patientSex = ['女', '男'];
    /**
     * @var array
     */
    protected $patientStatus = ['未到', '已到', '等待'];
    /**
     * @var array
     */
    protected $patientFieldModel = [
        'doctor_id'     => 'Doctor',
        'user_id'       => 'User',
        'hospital_id'   => 'Hospital',
        'department_id' => 'Department',
        'disease_id'    => 'Disease',
        'depart_id'     => 'Depart',
        'media_id'      => 'Media',
    ];

    /**
     * @return array
     */
    public function getPatientSex($sex)
    {
        return $this->patientSex[$sex];
    }


    /**
     * @return array
     */
    public function getPatientStatus($status)
    {
        return $this->patientStatus[$status];
    }



    /**
     * @param $data
     * @param $paitent
     * @return string
     */
    public function createLog($data, $patient)
    {
        $logs = [];
        foreach ($patient->toArray() as $key => $v) {
            if (isset($data[$key]) && $data[$key] != $v) {
                if (in_array($key, $this->patientFieldRead)) {
                    if ($key == 'sex') {
                        $log = [$this->patientKeyName[$key], $this->patientSex[$v], $this->patientSex[$data[$key]]];
                    } elseif ($key == 'status') {
                        $log = [$this->patientKeyName[$key], $this->patientStatus[$v], $this->patientStatus[$data[$key]]];
                    } else {
                        $log = [$this->patientKeyName[$key], $v, $data[$key]];
                    }
                    $logs[] = '将 [' . $log[0] . '] 由 [' . $log[1] . '] 改为 [' . $log[2] . ']';
                } else if (in_array($key, $this->patientFieldransform)) {
                    $log = [
                        $this->patientKeyName[$key],
                        $this->getNameById($this->patientFieldModel[$key], $v),
                        $this->getNameById($this->patientFieldModel[$key], $data[$key]),
                    ];
                    $logs[] = '将 [' . $log[0] . '] 由 [' . $log[1] . '] 改为 [' . $log[2] . ']';
                }
            }
        }
        $rs = implode(',', $logs);
        return $rs;
    }

    /**
     * @param $model
     * @param $id
     * @return mixed
     */
    public function getNameById($model, $id)
    {
        $models = 'App\\' . $model;
        return $models::where('id', $id)->value('name');
    }


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
        return $this->hasOne(PatientContent::class);

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
        return $this->belongsTo(Media::class)->select('id', 'name');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function depart()
    {
        return $this->belongsTo(Depart::class)->select('id', 'name');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class)->select('id', 'name');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function department()
    {
        return $this->belongsTo(Department::class)->select('id', 'name');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class)->select('id', 'name');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function disease()
    {
        return $this->belongsTo(Disease::class)->select('id', 'name');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name');
    }

}
