@extends('layouts.app')

@section('title', 'Finaliser la commande')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-8">Finaliser la commande</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Formulaire de commande -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Informations de livraison</h2>
                
                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom *</label>
                            <input type="text" name="prenom" id="prenom" required
                                   class="mt-1 block w-full border rounded-md px-3 py-2">
                        </div>
                        
                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-700">Nom *</label>
                            <input type="text" name="nom" id="nom" required
                                   class="mt-1 block w-full border rounded-md px-3 py-2">
                        </div>
                        
                        <div class="col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                            <input type="email" name="email" id="email" required
                                   class="mt-1 block w-full border rounded-md px-3 py-2">
                        </div>
                        
                        <div class="col-span-2">
                            <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                            <input type="tel" name="telephone" id="telephone"
                                   class="mt-1 block w-full border rounded-md px-3 py-2">
                        </div>
                        
                        <div class="col-span-2">
                            <label for="adresse" class="block text-sm font-medium text-gray-700">Adresse de livraison *</label>
                            <textarea name="adresse" id="adresse" rows="3" required
                                      class="mt-1 block w-full border rounded-md px-3 py-2"></textarea>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <button type="submit" class="w-full bg-pink-600 text-white px-6 py-3 rounded-md hover:bg-pink-700 font-semibold">
                            Confirmer la commande
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Résumé de la commande -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Récapitulatif</h2>
                
                <div class="space-y-4">
                    @foreach($cart as $item)
                        <div class="flex justify-between">
                            <div>
                                <span class="font-medium">{{ $item['nom'] }}</span>
                                <span class="text-gray-600 text-sm block">x{{ $item['quantite'] }}</span>
                            </div>
                            <span class="font-semibold">{{ number_format($item['prix'] * $item['quantite'], 2) }} €</span>
                        </div>
                    @endforeach
                    
                    <div class="border-t pt-4">
                        <div class="flex justify-between text-lg">
                            <span class="font-bold">Total</span>
                            <span class="font-bold text-pink-600">{{ number_format($total, 2) }} €</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection