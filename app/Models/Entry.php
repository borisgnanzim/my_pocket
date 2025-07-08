<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    /** @use HasFactory<\Database\Factories\EntryFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id', 'type', 'amount', 'description', 'date',
        'origin', 'category', 'currency'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
