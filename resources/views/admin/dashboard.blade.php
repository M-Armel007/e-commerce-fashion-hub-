@extends('layouts.app')

@section('title', 'Dashboard Admin - Fashion Hub')

@section('content')
<div class="bg-gray-100 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin</h1>
            <p class="text-gray-600">Bienvenue sur votre espace d'administration</p>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Produits</p>
                        <p class="text-3xl font-bold">{{ $stats['products'] }}</p>
                    </div>
                    <div class="bg-pink-100 p-3 rounded-full">
                        <i class="fas fa-tshirt text-pink-600 text-2xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Commandes</p>
                        <p class="text-3xl font-bold">{{ $stats['orders'] }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-shopping-bag text-blue-600 text-2xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Chiffre d'affaires</p>
                        <p class="text-3xl font-bold">{{ number_format($stats['revenue'], 0) }} €</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-euro-sign text-green-600 text-2xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Clients</p>
                        <p class="text-3xl font-bold">150</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-users text-purple-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Graphiques (simulés) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Ventes du mois</h3>
                <div class="h-64 flex items-end justify-around">
                    @foreach(['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'] as $day)
                        <div class="flex flex-col items-center">
                            <div class="w-12 bg-pink-500 rounded-t-lg" style="height: {{ rand(30, 100) }}px"></div>
                            <span class="text-sm text-gray-600 mt-2">{{ $day }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Répartition des ventes</h3>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between mb-1">
                            <span>Homme</span>
                            <span>45%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-pink-600 h-2 rounded-full" style="width: 45%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-1">
                            <span>Femme</span>
                            <span>35%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-purple-600 h-2 rounded-full" style="width: 35%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-1">
                            <span>Enfant</span>
                            <span>20%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 20%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Dernières commandes -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-semibold text-lg">Dernières commandes</h3>
                <a href="{{ route('admin.orders') }}" class="text-pink-600 hover:text-pink-700">Voir tout →</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left">N° Commande</th>
                            <th class="px-4 py-2 text-left">Client</th>
                            <th class="px-4 py-2 text-left">Date</th>
                            <th class="px-4 py-2 text-left">Total</th>
                            <th class="px-4 py-2 text-left">Statut</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $order->numero_commande }}</td>
                            <td class="px-4 py-3">{{ $order->client->nom ?? 'Client sur place' }}</td>
                            <td class="px-4 py-3">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3 font-semibold">{{ number_format($order->total, 2) }} €</td>
                            <td class="px-4 py-3">
                                @if($order->statut == 'en_attente')
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">En attente</span>
                                @elseif($order->statut == 'confirmee')
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Confirmée</span>
                                @elseif($order->statut == 'livree')
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Livrée</span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">{{ $order->statut }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-pink-600 hover:text-pink-700">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection