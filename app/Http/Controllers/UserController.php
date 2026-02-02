<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 1. Display all users
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // 2. Show create form
    public function create()
    {
        return view('admin.users.create');
    }

    // 3. Store new user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,admin',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $validated['profile_image'] = $path;
        }

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'เพิ่มผู้ใช้สำเร็จ');
    }

    // 4. Show user (optional for resource)
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    // 5. Show edit form
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // 5. Update user
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $validated['profile_image'] = $path;
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'อัปเดตผู้ใช้สำเร็จ');
    }

    // 6. Delete user
    public function destroy(User $user)
    {
        // Prevent deleting self
        if ($user->id === auth()->id()) {
            return back()->withErrors(['msg' => 'ไม่สามารถลบบัญชีของตัวเองได้']);
        }

        // Delete profile image
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'ลบผู้ใช้สำเร็จ');
    }
}
