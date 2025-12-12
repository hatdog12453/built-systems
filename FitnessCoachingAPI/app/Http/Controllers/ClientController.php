<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function index()
    {
        return Client::with(['coach'])->paginate(15);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'coach_id' => ['required','exists:coaches,id'],
            'full_name' => ['required','string','max:255'],
            'email' => ['required','email','unique:clients,email'],
            'password' => ['required','string','min:8'],
            'height' => ['nullable','numeric'],
            'weight' => ['nullable','numeric'],
            'age' => ['nullable','integer'],
            'goal' => ['nullable','string','max:255'],
            'payment_status' => ['nullable','string','max:255'],
            'subscription_type' => ['nullable','string'],
            'status' => ['nullable','string'],
        ]);
        $data['password'] = Hash::make($data['password']);
        $client = Client::create($data);
        return response()->json($client, 201);
    }

    public function show(Client $client)
    {
        return $client->load(['coach','mealPlan','sessionPlan','progressTracker','payments']);
    }

    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'coach_id' => ['sometimes','exists:coaches,id'],
            'full_name' => ['sometimes','string','max:255'],
            'email' => ['sometimes','email','unique:clients,email,'.$client->id],
            'password' => ['sometimes','string','min:8'],
            'height' => ['nullable','numeric'],
            'weight' => ['nullable','numeric'],
            'age' => ['nullable','integer'],
            'goal' => ['nullable','string','max:255'],
            'payment_status' => ['nullable','string','max:255'],
            'subscription_type' => ['nullable','string'],
            'status' => ['nullable','string'],
        ]);
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $client->update($data);
        return response()->json($client);
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return response()->json(null, 204);
    }
}
