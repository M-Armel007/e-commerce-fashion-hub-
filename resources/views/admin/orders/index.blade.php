@extends('layouts.app')

@section('title', 'Gestion des commandes - Fashion Hub')

@section('content')
<div class="bg-gray-100 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Gestion des commandes</h1>
            <p class="text-gray-600">Suivez et gérez toutes les commandes</p>
        </div>

        <!-- Filtres rapides -->
        <div class="bg-white rounded-xl shadow-lg p-4 mb-6">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.orders') }}" class="px-4 py-2 bg-pink-600 text-white rounded-lg">Toutes</a>
                <a href="{{ route('admin.orders', ['statut' => 'en_attente']) }}" class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg hover:bg-yellow-200">En attente</a>
                <a href="{{ route('admin.orders', ['statut' => 'confirmee']) }}" class="px-4 py-2 bg-blue-100 text-blue-800 rounded-lg hover:bg-blue-200">Confirmées</a>
                <a href="{{ route('admin.orders', ['statut' => 'livree']) }}" class="px-4 py-2 bg-green-100 text-green-800 rounded-lg hover:bg-green-200">Livrées</a>
                <a href="{{ route('admin.orders', ['statut' => 'annulee']) }}" class="px-4 py-2 bg-red-100 text-red-800 rounded-lg hover:bg-red-200">Annulées</a>
            </div>
        </div>

        <!-- Liste des commandes -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N° Commande</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-semibold">{{ $order->numero_commande }}</td>
                            <td class="px-6 py-4">{{ $order->client->name ?? 'Client sur place' }}</td>
                            <td class="px-6 py-4">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 font-bold text-pink-600">{{ number_format($order->total, 2) }} €</td>
                            <td class="px-6 py-4">
                                @if($order->statut == 'en_attente')
                                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">En attente</span>
                                @elseif($order->statut == 'confirmee')
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">Confirmée</span>
                                @elseif($order->statut == 'livree')
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Livrée</span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">Annulée</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($order->type_vente == 'en_ligne')
                                    <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs">En ligne</span>
                                @else
                                    <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs">Sur place</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-pink-600 hover:text-pink-800 font-medium">
                                    Voir détails
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection