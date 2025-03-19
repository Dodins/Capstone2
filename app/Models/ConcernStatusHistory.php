<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConcernStatusHistory extends Model
{
    protected $guarded = [];

    public function concern()
    {
        return $this->belongsTo(Concern::class);
    }
}
