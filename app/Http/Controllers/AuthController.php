<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends BaranjaController
{

    public function register(Request $request)
    {
        // $validEmails = $this->allActiveEmailsBaranjaModel();
       
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
            'role_id' => 2,
        ]);

        // $user->sendEmailVerificationNotification();

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'message' => 'The user registered successfully. Please check your email for verification.',
        ], 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($fields)) {
            $user = Auth::user();
            return response()->json([
                'status' => 'success',
                'message' => 'The user logged in successfully',
                'user' => $user,
            ], 200);
        }

        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    public function register_index()
    {
        return view('auth.register');
    }

    public function login_index()
    {
        return view('auth.login');
    }

    public function default_authentication()
    {
        return view('layouts.default-auth-nav');
    }

    public function allUsers()
    {
        $users = User::all();

        return $users;
    }

    public function allUsersWithEmail()
    {
        $emails = User::pluck('email')->toArray();
        return $emails;
    }

    
}
