<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class webController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function subscribe(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:15',
        ]);

        $username = Str::slug($request->name) . '-' . Str::random(5);
        $user = User::where('username', $username)->first();

        while ($user) {
            $username = Str::slug($request->name) . '-' . Str::random(5);
            $user = User::where('username', $username)->first();
        }
        // Create the user
        $user = User::create([
            'username' => $username,
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
        ]);

        return redirect()->back()->with('success', 'User added successfully!');
    }
}
