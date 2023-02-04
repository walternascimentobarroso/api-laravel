<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'name',
        'done',
        'due_date'
    ];

    public $casts = [
        'done' => 'boolean',
        'due_date' => 'date'
    ];
}
