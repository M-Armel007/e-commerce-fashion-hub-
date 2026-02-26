@extends('layouts.app')

@section('title', 'Détails de la commande - Fashion Hub')

@section('content')
<div class="bg-gray-100 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('admin.orders') }}" class="text-pink-600 hover:text-pink-700 mb-4 inline-block">
                <i class="fas fa-arrow-left mr-2"></i>Retour aux commandes
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Détails de la commande</h1>
            <p class="text-gray-600">Référence : {{ $order->numero_commande }}</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informations commande -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Statut et actions -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-lg">Statut de la commande</h3>
                        <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="flex items-center space-x-2">
                            @csrf
                            <select name="statut" class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-600">
                                <option value="en_attente" {{ $order->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                <option value="confirmee" {{ $order->statut == 'confirmee' ? 'selected' : '' }}>Confirmée</option>
                                <option value="livree" {{ $order->statut == 'livree' ? 'selected' : '' }}>Livrée</option>
                                <option value="annulee" {{ $order->statut == 'annulee' ? 'selected' : '' }}>Annulée</option>
                            </select>
                            <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700 transition">
                                Mettre à jour
                            </button>
                        </form>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Date de commande</p>
                            <p class="font-semibold">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Type de vente</p>
                            <p class="font-semibold">{{ $order->type_vente == 'en_ligne' ? 'En ligne' : 'Sur place' }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Articles commandés -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="font-semibold text-lg mb-4">Articles commandés</h3>
                    
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex items-center justify-between border-b pb-4 last:border-0 last:pb-0">
                            <div class="flex items-center space-x-4">
                                <div class="h-16 w-16 bg-gray-200 rounded-lg overflow-hidden">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fas fa-tshirt text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold">{{ $item->product->nom }}</p>
                                    <p class="text-sm text-gray-600">Quantité: {{ $item->quantite }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold">{{ number_format($item->prix_unitaire, 2) }} €</p>
                                <p class="text-sm text-gray-600">Total: {{ number_format($item->prix_unitaire * $item->quantite, 2) }} €</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-4 pt-4 border-t">
                        <div class="flex justify-between text-lg">
                            <span class="font-bold">Total</span>
                            <span class="font-bold text-pink-600">{{ number_format($order->total, 2) }} €</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Informations client -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-4">
                    <h3 class="font-semibold text-lg mb-4">Informations client</h3>
                    
                    @if($order->client)
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-600">Nom complet</p>
                                <p class="font-semibold">{{ $order->client->nom }} {{ $order->client->prenom }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Email</p>
                                <p class="font-semibold">{{ $order->client->email }}</p>
                            </div>
                            @if($order->client->telephone)
                            <div>
                                <p class="text-sm text-gray-600">Téléphone</p>
                                <p class="font-semibold">{{ $order->client->telephone }}</p>
                            </div>
                            @endif
                            @if($order->client->adresse)
                            <div>
                                <p class="text-sm text-gray-600">Adresse de livraison</p>
                                <p class="font-semibold">{{ $order->client->adresse }}</p>
                            </div>
                            @endif
                        </div>
                    @else
                        <p class="text-gray-600">Client non enregistré (vente sur place)</p>
                    @endif
                    
                    <!-- Actions -->
                    <div class="mt-6 space-y-2">
                        <a href="{{ route('orders.facture', $order->id) }}" target="_blank"
                           class="block w-full bg-blue-600 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-file-pdf mr-2"></i>Voir la facture
                        </a>
                        <button onclick="window.print()"
                                class="block w-full border border-gray-300 text-gray-700 text-center px-4 py-2 rounded-lg hover:bg-gray-50 transition">
                            <i class="fas fa-print mr-2"></i>Imprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style media="print">
    nav, footer, .bg-gray-100 > div > div:first-child, .sticky, button, a[target="_blank"] {
        display: none !important;
    }
    body {
        background: white !important;
    }
    .bg-white {
        box-shadow: none !important;
    }
</style>
@endsection