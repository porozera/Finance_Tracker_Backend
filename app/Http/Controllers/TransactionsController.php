<?php

namespace App\Http\Controllers;

use App\Models\Budgets;
use App\Models\SavingGoals;
use App\Models\Transaction;
use App\Models\Transactions;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaction = Transaction::with('category')->get();
        return response()->json($transaction);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id', 
                'budget_id' => 'required|exists:budgets,id', 
                'saving_goals' => 'nullable|exists:saving_goals,id', 
                'category_id' => 'required|exists:categories,id',
                'amount' => 'required|numeric|min:0', 
                'type' => 'required|in:income,expense', 
                'title' => 'nullable|string|max:255', 
                'transaction_date' => 'required|date', 
            ]);
        
            $transaction = Transaction::create([
                'user_id' => $validated['user_id'],
                'budget_id' => $validated['budget_id'],
                'saving_goals' => $validated['saving_goals'] ?? null,
                'category_id' => $validated['category_id'],
                'amount' => $validated['amount'],
                'type' => $validated['type'],
                'title' => $validated['title'] ?? null,
                'transaction_date' => $validated['transaction_date'],
            ]);
        
            if ($validated['type'] === 'expense') {
                $budget = Budgets::find($validated['budget_id']);
                if ($budget) {
                    $budget->update([
                        'current_amount' => $budget->current_amount - $validated['amount']
                    ]);
                }
            }
        
            if ($validated['saving_goals'] && $validated['type'] === 'income') {
                $savingGoals = SavingGoals::find($validated['saving_goals']);
                if ($savingGoals) {
                    $savingGoals->update([
                        'current_amount' => $savingGoals->current_amount + $validated['amount']
                    ]);
                }
            }
            return response()->json($transaction, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        return response()->json($transaction);
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // yang
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id', 
                'budget_id' => 'required|exists:budgets,id', 
                'saving_goals' => 'nullable|exists:saving_goals,id', 
                'category_id' => 'required|exists:categories,id',
                'amount' => 'required|numeric|min:0', 
                'type' => 'required|in:income,expense', 
                'title' => 'nullable|string|max:255', 
                'transaction_date' => 'required|date', 
            ]);
    
            $transaction = Transaction::findOrFail($id);
    
            $amountDifference = $validated['amount'] - $transaction->amount;
            $typeChanged = $validated['type'] !== $transaction->type;
    
            $budget = Budgets::find($transaction->budget_id);
            if ($budget) {
                if ($transaction->type === 'expense') {
                    $budget->current_amount += $transaction->amount; 
                }
    
                if ($validated['type'] === 'expense') {
                    $budget->current_amount -= $validated['amount']; 
                } 
    
                $budget->save();
            }

            if ($transaction->saving_goals) {
                $savingGoals = SavingGoals::find($transaction->saving_goals);
                if ($savingGoals) {
                    if ($transaction->type === 'income') {
                        $savingGoals->current_amount -= $transaction->amount; 
                    }
    
                    if ($validated['type'] === 'income' && $validated['saving_goals'] == $transaction->saving_goals) {
                        $savingGoals->current_amount += $validated['amount']; 
                    }
    
                    $savingGoals->save();
                }
            }
    
            if ($validated['saving_goals'] && $validated['saving_goals'] !== $transaction->saving_goals) {
                $newSavingGoals = SavingGoals::find($validated['saving_goals']);
                if ($newSavingGoals) {
                    if ($validated['type'] === 'income') {
                        $newSavingGoals->current_amount += $validated['amount'];
                    }
                    $newSavingGoals->save();
                }
            }
    
            $transaction->update($validated);
    
            return response()->json($transaction, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Ambil data transaksi berdasarkan ID
            $transaction = Transaction::findOrFail($id);
    
            // Kembalikan nilai ke tabel Budgets
            $budget = Budgets::find($transaction->budget_id);
            if ($budget) {
                if ($transaction->type === 'expense') {
                    $budget->current_amount += $transaction->amount; // Kembalikan pengurangan pada saat transaksi
                } 
                $budget->save();
            }
    
            // Kembalikan nilai ke tabel SavingGoals jika terkait
            if ($transaction->saving_goals) {
                $savingGoals = SavingGoals::find($transaction->saving_goals);
                if ($savingGoals && $transaction->type === 'income') {
                    $savingGoals->current_amount -= $transaction->amount; // Kembalikan penambahan pada saat transaksi
                    $savingGoals->save();
                }
            }
    
            // Hapus transaksi
            $transaction->delete();
    
            // Kembalikan respons JSON
            return response()->json(['message' => 'Transaction deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}
