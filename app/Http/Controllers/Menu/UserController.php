<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('menu.users', compact('users'));
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();

        if (!Auth::user()->is_superuser) {
            unset($data['is_superuser']);
            unset($data['is_owner']);
        }

        User::create($data);
        
        return redirect()->route('users')->with('success', 'User created successfully.');
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();
    
        if (!Auth::user()->is_superuser) {
            unset($data['is_superuser']);
            unset($data['is_owner']);
        }
    
        $user->update($data);
    
        return redirect()->route('users')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users')->with('success', 'User deleted successfully.');
    }
}
