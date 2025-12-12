<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CoachController extends Controller
{
    public function index()
    {
        return Coach::withCount('clients')->paginate(15);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => ['required','string','max:255'],
            'email' => ['required','email','unique:coaches,email'],
            'password' => ['required','string','min:8'],
            'quotes' => ['nullable','string'],
        ]);
        $data['password'] = Hash::make($data['password']);
        $coach = Coach::create($data);
        return response()->json($coach, 201);
    }

    public function show(Coach $coach)
    {
        return $coach->load('clients');
    }

    public function update(Request $request, Coach $coach)
    {
        $data = $request->validate([
            'full_name' => ['sometimes','string','max:255'],
            'email' => ['sometimes','email','unique:coaches,email,'.$coach->id],
            'password' => ['sometimes','string','min:8'],
            'quotes' => ['nullable','string'],
        ]);
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $coach->update($data);
        return response()->json($coach);
    }

    public function destroy(Coach $coach)
    {
        $coach->delete();
        return response()->json(null, 204);
    }
}
