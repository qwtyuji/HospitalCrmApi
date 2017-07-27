<?php

namespace App;

use Spatie\Permission\Models\Role as Sprole;

class Role extends Sprole
{
    protected $fillable = ['name', 'guard_name'];

    public function __construct(array $attributes = [])
    {
        $attributes['guard_name'] = 'api';
        parent::__construct($attributes);
    }

}
