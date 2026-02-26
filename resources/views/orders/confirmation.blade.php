@extends('layouts.app')

@section('title', 'Confirmation de commande - Fashion Hub')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4">
        <!-- Message de succès -->
        <div class="text-center mb-8">
            <div class="inline-block bg-green-100 p-4 rounded-full mb-4">
                <svg class="w-16 h-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Merci pour votre commande !</h1>
            <p class="text-gray-600">Votre commande a été enregistrée avec succès.</p>
        </div>

        <!-- Récapitulatif de la commande -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6">
            <!-- En-tête -->
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-semibold">Commande #{{ $order->numero_commande }}</h2>
                        <p class="text-sm opacity-90">Date : {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <span class="bg-white text-pink-600 px-3 py-1 rounded-full text-sm font-semibold">
                        {{ $order->statut == 'en_attente' ? 'En attente de paiement' : 'Confirmée' }}
                    </span>
                </div>
            </div>

            <!-- Contenu -->
            <div class="p-6">
                <!-- Informations client -->
                @if($order->client)
                <div class="mb-6 pb-6 border-b">
                    <h3 class="font-semibold text-lg mb-3">Informations de livraison</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Nom complet</p>
                            <p class="font-medium">{{ $order->client->nom }} {{ $order->client->prenom }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-medium">{{ $order->client->email }}</p>
                        </div>
                        @if($order->client->telephone)
                        <div>
                            <p class="text-sm text-gray-600">Téléphone</p>
                            <p class="font-medium">{{ $order->client->telephone }}</p>
                        </div>
                        @endif
                        @if($order->client->adresse)
                        <div class="col-span-2">
                            <p class="text-sm text-gray-600">Adresse</p>
                            <p class="font-medium">{{ $order->client->adresse }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Articles commandés -->
                <h3 class="font-semibold text-lg mb-3">Articles commandés</h3>
                <div class="space-y-4 mb-6">
                    @foreach($order->items as $item)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="h-16 w-16 bg-gray-100 rounded-lg overflow-hidden">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                        </svg>
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
                            <p class="text-sm text-gray-600">{{ number_format($item->prix_unitaire * $item->quantite, 2) }} €</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Total -->
                <div class="border-t pt-4">
                    <div class="flex justify-between text-lg">
                        <span class="font-bold">Total</span>
                        <span class="font-bold text-pink-600">{{ number_format($order->total, 2) }} €</span>
                    </div>
                </div>

                <!-- Mode de paiement -->
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-2"></i>
                        Vous recevrez un email de confirmation avec les détails de votre commande.
                    </p>
                </div>
            </div>
        </div>

        <!-- Boutons d'action -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('orders.facture', $order->id) }}" 
               class="bg-pink-600 text-white px-8 py-3 rounded-lg hover:bg-pink-700 transition font-semibold text-center">
                <i class="fas fa-file-pdf mr-2"></i>Télécharger la facture
            </a>
            <a href="{{ route('products.index') }}" 
               class="border-2 border-pink-600 text-pink-600 px-8 py-3 rounded-lg hover:bg-pink-50 transition font-semibold text-center">
                Continuer mes achats
            </a>
        </div>
    </div>
</div>
@endsection