@extends('layouts.app')

@section('title', 'Mon Profil - Fashion Hub')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Mon Profil</h1>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Menu latéral -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-4">
                    <div class="text-center mb-6">
                        <div class="w-24 h-24 bg-gradient-to-br from-purple-600 to-pink-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <span class="text-3xl font-bold text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                        <h2 class="font-semibold text-xl">{{ auth()->user()->name }}</h2>
                        <p class="text-gray-600">{{ auth()->user()->email }}</p>
                    </div>
                    
                    <nav class="space-y-2">
                        <a href="{{ route('profile.index') }}" class="block px-4 py-3 bg-pink-50 text-pink-600 rounded-lg font-medium">
                            <i class="fas fa-user mr-2"></i>Informations personnelles
                        </a>
                        <a href="{{ route('profile.orders') }}" class="block px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                            <i class="fas fa-shopping-bag mr-2"></i>Mes commandes
                        </a>
                        <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                            <i class="fas fa-heart mr-2"></i>Mes favoris
                        </a>
                        <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                            <i class="fas fa-map-marker-alt mr-2"></i>Adresses
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition">
                                <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                            </button>
                        </form>
                    </nav>
                </div>
            </div>
            
            <!-- Contenu principal -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-semibold mb-6">Modifier mes informations</h2>
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="border-t pt-6">
                                <h3 class="font-semibold text-lg mb-4">Changer le mot de passe</h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe actuel</label>
                                        <input type="password" name="current_password" id="current_password"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                                    </div>
                                    
                                    <div>
                                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">Nouveau mot de passe</label>
                                        <input type="password" name="new_password" id="new_password"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                                    </div>
                                    
                                    <div>
                                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmer le nouveau mot de passe</label>
                                        <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <button type="submit" class="bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold px-6 py-3 rounded-lg hover:from-purple-700 hover:to-pink-700 transition">
                                    Mettre à jour le profil
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection