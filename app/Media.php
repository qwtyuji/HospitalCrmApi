<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Media
 * @package App
 */
class Media extends Model
{
    /**
     * @var array
     */
    protected $fillable =['name','hospital_id','status','author','description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}
