<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Coach;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    /**
     * Show chat interface for coach with a specific client
     */
    public function showCoachChat(Client $client)
    {
        $coach = Session::get('user');
        
        // Ensure client belongs to this coach
        if ($client->coach_id !== $coach->id) {
            abort(403);
        }

        $messages = Message::where('coach_id', $coach->id)
            ->where('client_id', $client->id)
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read when coach views them
        Message::where('coach_id', $coach->id)
            ->where('client_id', $client->id)
            ->where('sender_type', 'client')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('coach.chat', compact('client', 'messages', 'coach'));
    }

    /**
     * Show chat interface for client with their coach
     */
    public function showClientChat()
    {
        $client = Session::get('user');
        $coach = $client->coach;

        if (!$coach) {
            return redirect()->route('client.dashboard')->withErrors(['error' => 'No coach assigned.']);
        }

        $messages = Message::where('coach_id', $coach->id)
            ->where('client_id', $client->id)
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read when client views them
        Message::where('coach_id', $coach->id)
            ->where('client_id', $client->id)
            ->where('sender_type', 'coach')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('client.chat', compact('client', 'coach', 'messages'));
    }

    /**
     * Send a message (coach to client or client to coach)
     */
    public function sendMessage(Request $request)
    {
        $user = Session::get('user');
        $userType = Session::get('role');

        if ($userType === 'coach') {
            $request->validate([
                'client_id' => 'required|exists:clients,id',
                'message' => 'nullable|string|max:5000',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            ]);

            $client = Client::findOrFail($request->client_id);
            
            // Ensure client belongs to this coach
            if ($client->coach_id !== $user->id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('chat-images', 'public');
            }

            $message = Message::create([
                'coach_id' => $user->id,
                'client_id' => $client->id,
                'sender_type' => 'coach',
                'message' => $request->message ?? '',
                'image' => $imagePath,
            ]);

            return response()->json([
                'success' => true,
                'message' => $message->load(['coach', 'client']),
            ]);
        } elseif ($userType === 'client') {
            $request->validate([
                'message' => 'nullable|string|max:5000',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            ]);

            $coach = $user->coach;
            
            if (!$coach) {
                return response()->json(['error' => 'No coach assigned'], 400);
            }

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('chat-images', 'public');
            }

            $message = Message::create([
                'coach_id' => $coach->id,
                'client_id' => $user->id,
                'sender_type' => 'client',
                'message' => $request->message ?? '',
                'image' => $imagePath,
            ]);

            return response()->json([
                'success' => true,
                'message' => $message->load(['coach', 'client']),
            ]);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }

    /**
     * Get messages for a conversation (AJAX endpoint)
     */
    public function getMessages(Request $request)
    {
        $user = Session::get('user');
        $userType = Session::get('role');

        if ($userType === 'coach') {
            $request->validate([
                'client_id' => 'required|exists:clients,id',
            ]);

            $client = Client::findOrFail($request->client_id);
            
            if ($client->coach_id !== $user->id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $messages = Message::where('coach_id', $user->id)
                ->where('client_id', $client->id)
                ->orderBy('created_at', 'asc')
                ->get();

            return response()->json(['messages' => $messages]);
        } elseif ($userType === 'client') {
            $coach = $user->coach;
            
            if (!$coach) {
                return response()->json(['error' => 'No coach assigned'], 400);
            }

            $messages = Message::where('coach_id', $coach->id)
                ->where('client_id', $user->id)
                ->orderBy('created_at', 'asc')
                ->get();

            return response()->json(['messages' => $messages]);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
