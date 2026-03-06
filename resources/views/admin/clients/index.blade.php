@extends('layouts.app')

@section('title', 'Gestion des clients - Fashion Hub')

@section('content')
<div class="bg-gray-100 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Gestion des clients</h1>
            <p class="text-gray-600">{{ $clients->total() }} clients inscrits</p>
        </div>

        <!-- Statistiques clients -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <p class="text-gray-600 text-sm">Total clients</p>
                <p class="text-3xl font-bold">{{ $clients->total() }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6">
                <p class="text-gray-600 text-sm">Nouveaux ce mois</p>
                <p class="text-3xl font-bold text-green-600">{{ $clients->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6">
                <p class="text-gray-600 text-sm">Clients actifs</p>
                <p class="text-3xl font-bold text-blue-600">{{ $clients->filter(fn($client) => $client->orders_count > 0)->count() }}</p>
            </div>
        </div>

        <!-- Liste des clients -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inscrit le</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commandes</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total dépensé</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($clients as $client)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-pink-600 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ substr($client->name, 0, 1) }}
                                    </div>
                                    <span class="font-semibold">{{ $client->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $client->email }}</td>
                            <td class="px-6 py-4">{{ $client->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">{{ $client->orders_count }}</td>
                            <td class="px-6 py-4 font-semibold">{{ number_format($client->orders->sum('total'), 0) }} €</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.clients.show', $client->id) }}" class="text-pink-600 hover:text-pink-800">
                                    Voir profil
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t">
                {{ $clients->links() }}
            </div>
        </div>
    </div>
</div>
@endsection