<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    /** @use HasFactory<\Database\Factories\ReportFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'type', 'start_date', 'end_date',
        'total_income', 'total_expense', 'balance'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
