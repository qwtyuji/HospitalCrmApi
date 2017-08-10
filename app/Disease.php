<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Disease
 * @package App
 */
class Disease extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'pid', 'decription', 'status', 'author', 'department_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * @param $pid
     * @return mixed|string
     */
    public function getPidName($pid)
    {
        if ($pid == '0') {
            return '一级疾病';
        } else {
            $data =$this->getDiseaseNameList();
            return $data[$pid];
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getDiseaseNameList()
    {
        $data = $this->pluck('name', 'id');
        return $data;
    }

}
