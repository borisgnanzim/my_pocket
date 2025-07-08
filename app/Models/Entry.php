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

    protected static function boot()
    {
        parent::boot();

        static::created(function ($entry) {
            $entry->updateUserBalance();
        });
    }


    private function updateUserBalance()
    {
        $user = $this->user;
        if ($user) {
            if ($this->type === 'income') {
                $user->current_balance += $this->amount;
            } else {
                $user->current_balance -= $this->amount;
            }
            $user->save();
        }
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
