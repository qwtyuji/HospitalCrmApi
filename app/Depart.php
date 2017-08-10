<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Depart extends Model
{
    protected $fillable = ['name', 'pid', 'status', 'author', 'description'];

    public function getParentName($pid)
    {
        if ($pid == '0') {
            return '顶级部门';
        } else {
            $data = $this->getDepartNameList();
            return isset($data[$pid]) ? $data[$pid] : '未知';
        }
    }

    public function getDepartNameList()
    {
        $data = $this->pluck('name', 'id');
        return $data;
    }


}
