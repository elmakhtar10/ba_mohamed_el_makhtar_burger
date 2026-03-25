<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Burger extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'image_path',
        'description',
        'stock',
        'is_archived',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_archived' => 'boolean',
    ];
}
