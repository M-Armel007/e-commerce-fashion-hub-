<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RedirectAuthenticatedUsersController extends Controller
{
    public function redirect()
    {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard'); // Utilise le nouveau nom de route
        } else {
            return redirect()->route('home');
        }
    }
}