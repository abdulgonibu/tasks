<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $fillable = [
        'title', 'slug', 'description', 'image', 'status'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
