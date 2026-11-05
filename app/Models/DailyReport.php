<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    use HasFactory;

    protected $table = 'daily_reports';

    protected $fillable = [
        'report_date',
        'category',
        'income',
        'profit_percent',
        'profit',
        'note',
        'created_by',
    ];

    protected $casts = [
        'report_date' => 'date',
        'income' => 'float',
        'profit_percent' => 'float',
        'profit' => 'float',
    ];
}
