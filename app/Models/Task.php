<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    public static function getStatusOptions(): array
    {
        return ['pending', 'in_progress', 'done'];
    }
}
