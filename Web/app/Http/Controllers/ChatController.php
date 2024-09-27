<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(){
        return view('chat');
    }
    public function sendMessage(Request $request)
    {
        $message = $request->input('message');

        // Process the message (e.g., use an AI chatbot API or respond with a static message)
        $reply = "This is a sample response to: " . $message;

        // Return response as JSON
        return response()->json(['reply' => $reply]);
    }

    private function generateBotReply($message)
    {
// Dummy bot reply logic, replace with actual bot response logic
        if (strtolower($message) === 'hello') {
            return 'Hello! How can I assist you today?';
        }

        return 'Sorry, I didn\'t understand that.';
    }
}
