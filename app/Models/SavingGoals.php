<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingGoals extends Model
{
    use HasFactory;
    protected $table = 'saving_goals';
    protected $fillable = [
        'user_id',
        'goal_name',
        'target_amount',
        'current_amount',
        'deadline',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
