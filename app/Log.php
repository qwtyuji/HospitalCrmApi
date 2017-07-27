<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable=['user_id','name','type','url','data','ip'];
}
