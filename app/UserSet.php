<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSet extends Model
{
    protected $fillable=['patient_column','user_id','hospital_id','hospital_ids'];
}
