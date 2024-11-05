<?php

namespace App\Http\Controllers;

use App\Models\Chatroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatroomController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'max_members' => 'required|integer|min:1'
        ]);

        $chatroom = Chatroom::create($request->only('name', 'max_members'));
        return response()->json($chatroom, 200);
    }

    public function list()
    {
        return response()->json(Chatroom::all());
    }

    public function index()
    {
        return view('content.chatrooms');
    }

    public function enter($id, Request $request)
    {
        $user = Auth::user();
        $chatroom = Chatroom::findOrFail($id);

        if ($chatroom->users()->count() >= $chatroom->max_members) {
            return response()->json([
                'error' => 'Chatroom is full. Cannot join at the moment.'
            ], 403);
        }

        if ($chatroom->users()->where('user_id', $user->id)->exists()) {
            return response()->json([
                'message' => 'You are already a member of this chatroom.'
            ], 200);
        }

        $chatroom->users()->attach($user->id);

        return response()->json([
            'message' => 'Successfully joined the chatroom.',
            'chatroom' => $chatroom
        ], 200);
    }

    public function leave($id, Request $request)
    {
        $user = Auth::user();
        $chatroom = Chatroom::findOrFail($id);

        if (!$chatroom->users()->where('user_id', $user->id)->exists()) {
            return response()->json([
                'error' => 'You are not a member of this chatroom.'
            ], 403);
        }

        $chatroom->users()->detach($user->id);

        return response()->json([
            'message' => 'Successfully left the chatroom.',
            'chatroom' => $chatroom
        ], 200);
    }

    public function show($id)
    {
        $chatroom = Chatroom::with('users')->findOrFail($id);
        return view('content.chatroom', compact('chatroom'));
    }
}
