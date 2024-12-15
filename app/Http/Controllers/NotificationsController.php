<?php

namespace App\Http\Controllers;

use App\Models\Notifications;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $notifications = Notifications::query();

        if ($request->has('user_id')) {
            $notifications->where('user_id', $request->user_id);
        }

        return response()->json($notifications->get());
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
            'message' => 'required|string',
        ]);

        $notification = Notifications::create($validated);
        return response()->json($notification, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $notification = Notifications::findOrFail($id);
        return response()->json($notification);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notifications $notifications)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notifications $notifications)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $notification = Notifications::findOrFail($id);
        $notification->delete();
        return response()->json(['message' => 'Notification deleted successfully']);
    }

    public function markAsRead($id)
    {
        $notification = Notifications::findOrFail($id);
        $notification->update(['is_read' => true]);
        return response()->json(['message' => 'Notification marked as read', 'notification' => $notification]);
    }
}
