<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $tabel = 'transactions';

    protected $fillable = [
        'user_id',
        'category_id',
        'budget_id',
        'saving_goals',
        'amount',
        'type',
        'title',
        'transaction_date',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function budget()
    {
        return $this->belongsTo(Budgets::class);
    }

    public function saving_goal()
    {
        return $this->belongsTo(SavingGoals::class);
    }
}
