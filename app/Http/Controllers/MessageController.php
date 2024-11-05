<?php

namespace App\Http\Controllers;

use App\Jobs\SendMessage;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'chatroom_id' => 'required|exists:chatrooms,id',
            'user_id' => 'required|exists:users,id',
            'content' => 'nullable|string',
            'attachment' => 'nullable|file'
        ]);

        $message = new Message();
        $message->chatroom_id = $request->chatroom_id;
        $message->user_id = $request->user_id;
        $message->content = $request->content;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();

            $folder = '';
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                $folder = 'picture';
            } elseif (in_array($extension, ['mp4', 'mov', 'avi', 'mkv'])) {
                $folder = 'video';
            }

            $path = $file->storeAs('public/root/' . $folder, time() . '_' . $file->getClientOriginalName());
            $message->attachment = Storage::url($path);
        }

        $message->save();
        SendMessage::dispatch($message);
        return response()->json($message, 200);
    }

    public function listMessages($chatroomId)
    {
        return response()->json(Message::where('chatroom_id', $chatroomId)->get());
    }
}
