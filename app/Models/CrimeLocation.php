<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CrimeLocation extends Model
{
    use HasFactory;

    protected $fillable = ['lat', 'lng', 'name', 'description', 'image'];
}
