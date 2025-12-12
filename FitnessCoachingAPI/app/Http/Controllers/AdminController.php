<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function index()
    {
        return Admin::paginate(15);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => ['required','string','max:255'],
            'email' => ['required','email','unique:admins,email'],
            'password' => ['required','string','min:8'],
        ]);
        $data['password'] = Hash::make($data['password']);
        $admin = Admin::create($data);
        return response()->json($admin, 201);
    }

    public function show(Admin $admin)
    {
        return $admin;
    }

    public function update(Request $request, Admin $admin)
    {
        // Prevent modifications to main admin account
        if ($admin->isMainAdmin()) {
            // Prevent email modification
            if (isset($request->email) && $request->email !== Admin::MAIN_ADMIN_EMAIL) {
                return response()->json([
                    'message' => 'Cannot change email of the main admin account.'
                ], 403);
            }
            
            // Prevent password modification
            if (isset($request->password)) {
                return response()->json([
                    'message' => 'Cannot change password of the main admin account. Password is static: ' . Admin::MAIN_ADMIN_PASSWORD
                ], 403);
            }
            
            // Only allow full_name updates
            $data = $request->validate([
                'full_name' => ['sometimes','string','max:255'],
            ]);
            
            // Ensure email is not in the update data
            unset($data['email'], $data['password']);
        } else {
            $data = $request->validate([
                'full_name' => ['sometimes','string','max:255'],
                'email' => ['sometimes','email','unique:admins,email,'.$admin->id],
                'password' => ['sometimes','string','min:8'],
            ]);
            
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }
        }
        
        $admin->update($data);
        return response()->json($admin);
    }

    public function destroy(Admin $admin)
    {
        // Prevent deletion of main admin account
        if ($admin->isMainAdmin()) {
            return response()->json([
                'message' => 'Cannot delete the main admin account.'
            ], 403);
        }

        $admin->delete();
        return response()->json(null, 204);
    }
}
