<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportSection extends Model
{
    use HasFactory;

    protected $table = 'report_sections';

    protected $fillable = [
        'name',
        'profit_percent',
        'created_by',
    ];

    protected $casts = [
        'profit_percent' => 'float',
    ];
}
