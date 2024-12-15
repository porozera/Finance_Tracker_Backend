<?php

namespace App\Http\Controllers;

use App\Models\Budgets;
use Illuminate\Http\Request;

class BudgetsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $budgets = Budgets::query();

        if ($request->has('user_id')) {
            $budgets->where('user_id', $request->user_id);
        }

        return response()->json($budgets->with('category', 'user')->get());
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
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $budget = Budgets::create($validated);
        return response()->json($budget, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $budget = Budget::with('category', 'user')->findOrFail($id);
        return response()->json($budget);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Budgets $budgets)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $budget = Budgets::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'amount' => 'sometimes|numeric|min:0',
        ]);

        $budget->update($validated);
        return response()->json($budget);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $budget = Budgets::findOrFail($id);
        $budget->delete();

        return response()->json(['message' => 'Budget deleted successfully']);
    }
}
