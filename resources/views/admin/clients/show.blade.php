@extends('layouts.app')

@section('title', 'Détails client - Fashion Hub')

@section('content')
<div class="bg-gray-100 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- En-tête -->
        <div class="mb-6">
            <a href="{{ route('admin.clients') }}" class="text-pink-600 hover:text-pink-700 mb-4 inline-block">
                <i class="fas fa-arrow-left mr-2"></i>Retour à la liste des clients
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Profil client</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Colonne gauche - Infos client -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-4">
                    <div class="text-center mb-6">
                        <div class="w-24 h-24 bg-gradient-to-br from-purple-600 to-pink-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <span class="text-3xl font-bold text-white">{{ strtoupper(substr($client->name, 0, 1)) }}</span>
                        </div>
                        <h2 class="text-xl font-bold">{{ $client->name }}</h2>
                        <p class="text-gray-600">{{ $client->email }}</p>
                        <p class="text-sm text-gray-500 mt-2">Membre depuis {{ $client->created_at->format('d/m/Y') }}</p>
                    </div>

                    <div class="border-t pt-4">
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600">Total commandes</span>
                            <span class="font-bold">{{ $ordersCount }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600">Total dépensé</span>
                            <span class="font-bold text-pink-600">{{ number_format($totalSpent, 0) }} €</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600">Panier moyen</span>
                            <span class="font-bold">{{ $ordersCount > 0 ? number_format($totalSpent / $ordersCount, 0) : 0 }} €</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-6 space-y-2">
                        <button class="w-full bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700 transition flex items-center justify-center">
                            <i class="fas fa-envelope mr-2"></i>Envoyer un email
                        </button>
                        <button class="w-full border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition flex items-center justify-center">
                            <i class="fas fa-tag mr-2"></i>Ajouter une note
                        </button>
                    </div>
                </div>
            </div>

            <!-- Colonne droite - Historique commandes -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Historique des commandes</h3>

                    @if($client->orders->isEmpty())
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-shopping-bag text-5xl mb-4 opacity-50"></i>
                            <p>Aucune commande pour ce client</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($client->orders as $order)
                            <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <span class="font-semibold">{{ $order->numero_commande }}</span>
                                        <span class="text-sm text-gray-600 ml-2">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <span class="font-bold text-pink-600">{{ number_format($order->total, 2) }} €</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div>
                                        @if($order->statut == 'en_attente')
                                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">En attente</span>
                                        @elseif($order->statut == 'confirmee')
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Confirmée</span>
                                        @elseif($order->statut == 'livree')
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Livrée</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">Annulée</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-pink-600 hover:text-pink-700 text-sm">
                                        Voir détails →
                                    </a>
                                </div>

                                <!-- Mini liste des articles -->
                                <div class="mt-3 pt-3 border-t text-sm">
                                    <p class="text-gray-600 mb-2">{{ $order->items->count() }} article(s) :</p>
                                    <div class="space-y-1">
                                        @foreach($order->items->take(2) as $item)
                                            <div class="flex justify-between">
                                                <span>{{ $item->product->nom }} x{{ $item->quantite }}</span>
                                                <span>{{ number_format($item->prix_unitaire * $item->quantite, 2) }} €</span>
                                            </div>
                                        @endforeach
                                        @if($order->items->count() > 2)
                                            <p class="text-gray-500">+ {{ $order->items->count() - 2 }} autres articles</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection