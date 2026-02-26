@extends('layouts.app')

@section('title', 'Mon Panier')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-8">Mon Panier</h1>
    
    @if(empty($cart))
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <p class="text-gray-500 text-lg mb-4">Votre panier est vide</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-pink-600 text-white px-6 py-3 rounded-md hover:bg-pink-700">
                Découvrir nos produits
            </a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <form action="{{ route('cart.update') }}" method="POST">
                @csrf
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produit</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prix</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantité</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($cart as $id => $item)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-16 w-16 bg-gray-200 rounded flex items-center justify-center mr-4">
                                        @if($item['image'] ?? false)
                                            <img src="{{ asset('storage/' . $item['image']) }}" alt="" class="h-full w-full object-cover rounded">
                                        @else
                                            <span class="text-gray-400 text-xs">Image</span>
                                        @endif
                                    </div>
                                    <span class="font-medium">{{ $item['nom'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ number_format($item['prix'], 2) }} €</td>
                            <td class="px-6 py-4">
                                <input type="number" name="quantites[{{ $id }}]" value="{{ $item['quantite'] }}" 
                                       min="1" max="10" class="w-20 border rounded-md px-2 py-1">
                            </td>
                            <td class="px-6 py-4 font-semibold">
                                {{ number_format($item['prix'] * $item['quantite'], 2) }} €
                            </td>
                            <td class="px-6 py-4">
                                <button type="submit" formaction="{{ route('cart.remove', $id) }}" 
                                        class="text-red-600 hover:text-red-800">
                                    Supprimer
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="p-6 bg-gray-50 border-t">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-lg">Total: <span class="font-bold text-pink-600">{{ number_format($total, 2) }} €</span></p>
                        </div>
                        <div class="space-x-4">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                                Mettre à jour
                            </button>
                            <button type="submit" formaction="{{ route('cart.clear') }}" 
                                    class="bg-gray-600 text-white px-6 py-2 rounded-md hover:bg-gray-700">
                                Vider le panier
                            </button>
                            <a href="{{ route('orders.checkout') }}" class="bg-pink-600 text-white px-6 py-2 rounded-md hover:bg-pink-700">
                                Commander
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection