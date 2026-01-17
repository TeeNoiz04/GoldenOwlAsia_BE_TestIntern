<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectStatistic extends Model
{
    use HasFactory;
    protected $fillable = [
        'subject',
        'excellent',
        'good',
        'average',
        'poor',
    ];
}
