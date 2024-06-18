<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'email',
        'area',
        'category',
        'logo',
        'company',
        'satisfaction_level',
    ];
}
