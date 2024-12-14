<?php

namespace App\Http\Controllers;

use App\Models\SavingGoals;
use Illuminate\Http\Request;

class SavingGoalsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $goals = SavingGoals::all();
        return response()->json($goals);
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
            'goal_name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0',
            'current_amount' => 'nullable|numeric|min:0',
            'deadline' => 'required|date|after:today',
        ]);

        $goal = SavingGoals::create($validated);
        return response()->json($goal, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $goal = SavingGoals::findOrFail($id);
        return response()->json($goal);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SavingGolas $savingGolas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $goal = SavingGoals::findOrFail($id);

        $validated = $request->validate([
            'goal_name' => 'nullable|string|max:255',
            'target_amount' => 'nullable|numeric|min:0',
            'current_amount' => 'nullable|numeric|min:0',
            'deadline' => 'nullable|date|after:today',
        ]);

        $goal->update($validated);
        return response()->json($goal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $goal = SavingGoals::findOrFail($id);
        $goal->delete();
        return response()->json(['message' => 'Savings goal deleted successfully']);
    }
}
