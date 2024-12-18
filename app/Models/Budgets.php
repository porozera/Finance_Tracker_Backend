<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budgets extends Model
{
    use HasFactory;
    protected $table = 'budgets';
    protected $fillable = [
        'user_id',
        'first_amount',
        'current_amount',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Category
    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
