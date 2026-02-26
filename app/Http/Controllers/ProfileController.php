<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $orders = $user->orders()->with('items.product')->latest()->get();
        
        return view('profile.index', compact('user', 'orders'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('current_password')) {
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
            } else {
                return back()->withErrors(['current_password' => 'Mot de passe actuel incorrect']);
            }
        }

        $user->save();

        return back()->with('success', 'Profil mis à jour avec succès');
    }

    public function orders()
    {
        $orders = auth()->user()->orders()->with('items.product')->latest()->paginate(10);
        return view('profile.orders', compact('orders'));
    }
}