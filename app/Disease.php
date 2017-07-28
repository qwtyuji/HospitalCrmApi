<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    protected $fillable =['name','pid','decription','status','author'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }



}
