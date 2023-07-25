<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'size',
        'estimate', 'price', 'description', 'images',
        'created_by',
        // 'type',
    ];

}
