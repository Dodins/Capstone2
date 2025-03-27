<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sos extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'message',
        'is_seen',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'is_seen' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
