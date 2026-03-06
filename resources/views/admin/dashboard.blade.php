@extends('layouts.app')

@section('title', 'Dashboard Admin - Fashion Hub')

@section('content')
<div class="bg-gray-100 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin</h1>
            <p class="text-gray-600">Bienvenue, {{ Auth::user()->name }} ! Voici vos statistiques en temps réel.</p>
        </div>

        <!-- Cartes de statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Produits -->
            <div class="bg-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Produits</p>
                        <p class="text-3xl font-bold">{{ $stats['products'] }}</p>
                        <p class="text-sm text-gray-500 mt-2">
                            <span class="text-red-600">{{ $stats['out_of_stock'] }} en rupture</span>
                        </p>
                    </div>
                    <div class="bg-pink-100 p-3 rounded-full">
                        <i class="fas fa-tshirt text-pink-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Commandes -->
            <div class="bg-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Commandes</p>
                        <p class="text-3xl font-bold">{{ $stats['orders'] }}</p>
                        <p class="text-sm text-gray-500 mt-2">
                            {{ $stats['orders_this_month'] }} ce mois
                        </p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-shopping-bag text-blue-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Chiffre d'affaires -->
            <div class="bg-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Chiffre d'affaires</p>
                        <p class="text-3xl font-bold">{{ number_format($stats['revenue'], 0) }} €</p>
                        <p class="text-sm text-gray-500 mt-2">
                            {{ number_format($stats['revenue_this_month'], 0) }} € ce mois
                        </p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-euro-sign text-green-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Clients -->
            <div class="bg-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Clients</p>
                        <p class="text-3xl font-bold">{{ $stats['clients'] }}</p>
                        <p class="text-sm text-gray-500 mt-2">
                            <i class="fas fa-user-plus text-green-600"></i> Inscriptions récentes
                        </p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-users text-purple-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphique des ventes -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Ventes des 7 derniers jours</h3>
                <div class="h-64">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Stock critique</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span>En rupture</span>
                        <span class="font-bold text-red-600">{{ $stats['out_of_stock'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-red-600 h-2.5 rounded-full" style="width: {{ $stats['products'] > 0 ? ($stats['out_of_stock'] / $stats['products'] * 100) : 0 }}%"></div>
                    </div>
                    
                    <div class="flex justify-between items-center mt-4">
                        <span>Stock faible (<5)</span>
                        <span class="font-bold text-orange-600">{{ $stats['low_stock'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-orange-600 h-2.5 rounded-full" style="width: {{ $stats['products'] > 0 ? ($stats['low_stock'] / $stats['products'] * 100) : 0 }}%"></div>
                    </div>
                    
                    <div class="flex justify-between items-center mt-4">
                        <span>Stock normal</span>
                        <span class="font-bold text-green-600">{{ $stats['products'] - $stats['out_of_stock'] - $stats['low_stock'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $stats['products'] > 0 ? (($stats['products'] - $stats['out_of_stock'] - $stats['low_stock']) / $stats['products'] * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top produits et commandes récentes -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Top produits -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Top 5 produits les plus vendus</h3>
                <div class="space-y-4">
                    @forelse($topProducts as $product)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gray-200 rounded-lg overflow-hidden">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fas fa-tshirt text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold">{{ $product->nom }}</p>
                                    <p class="text-sm text-gray-600">{{ $product->order_items_count }} ventes</p>
                                </div>
                            </div>
                            <span class="font-bold text-pink-600">{{ number_format($product->prix, 0) }} €</span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center">Aucune vente pour le moment</p>
                    @endforelse
                </div>
            </div>

            <!-- Commandes récentes -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Dernières commandes</h3>
                <div class="space-y-4">
                    @forelse($recentOrders as $order)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-semibold">{{ $order->numero_commande }}</p>
                                <p class="text-sm text-gray-600">{{ $order->client->name ?? 'Client' }} • {{ $order->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="text-right">
                                <span class="font-bold text-pink-600">{{ number_format($order->total, 0) }} €</span>
                                <p class="text-xs">
                                    @if($order->statut == 'en_attente')
                                        <span class="text-yellow-600">En attente</span>
                                    @elseif($order->statut == 'confirmee')
                                        <span class="text-blue-600">Confirmée</span>
                                    @elseif($order->statut == 'livree')
                                        <span class="text-green-600">Livrée</span>
                                    @else
                                        <span class="text-red-600">Annulée</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center">Aucune commande récente</p>
                    @endforelse
                </div>
                <a href="{{ route('admin.orders') }}" class="mt-4 inline-block text-pink-600 hover:text-pink-700">
                    Voir toutes les commandes →
                </a>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="font-semibold text-lg mb-4">Actions rapides</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('admin.products.create') }}" class="bg-pink-50 p-4 rounded-xl text-center hover:bg-pink-100 transition">
                    <i class="fas fa-plus-circle text-pink-600 text-2xl mb-2"></i>
                    <p class="text-sm font-medium">Nouveau produit</p>
                </a>
                <a href="{{ route('admin.orders') }}" class="bg-blue-50 p-4 rounded-xl text-center hover:bg-blue-100 transition">
                    <i class="fas fa-eye text-blue-600 text-2xl mb-2"></i>
                    <p class="text-sm font-medium">Voir commandes</p>
                </a>
                <a href="{{ route('admin.sales.create') }}" class="bg-green-50 p-4 rounded-xl text-center hover:bg-green-100 transition">
                    <i class="fas fa-cash-register text-green-600 text-2xl mb-2"></i>
                    <p class="text-sm font-medium">Vente sur place</p>
                </a>
                <a href="{{ route('admin.clients') }}" class="bg-purple-50 p-4 rounded-xl text-center hover:bg-purple-100 transition">
                    <i class="fas fa-users text-purple-600 text-2xl mb-2"></i>
                    <p class="text-sm font-medium">Gérer clients</p>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js pour les graphiques -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Ventes (€)',
                data: {!! json_encode($chartData) !!},
                borderColor: 'rgb(236, 72, 153)',
                backgroundColor: 'rgba(236, 72, 153, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + ' €';
                        }
                    }
                }
            }
        }
    });
</script>
@endsection