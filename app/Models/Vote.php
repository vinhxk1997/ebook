<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    public $timestamps = false;

    // protected $primaryKey = [
    //     'user_id',
    //     'votable_id',
    // ];

    protected $fillable = [
        'user_id',
        'votable_id',
        'votable_type',
    ];
    
    public function votable()
    {
        return $this->morphTo();
    }
}
