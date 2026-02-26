@extends('layouts.app')

@section('title', 'Facture #' . $order->numero_commande)

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <!-- Boutons d'action -->
            <div class="flex justify-end space-x-4 mb-6">
                <button onclick="window.print()" class="bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700">
                    <i class="fas fa-print mr-2"></i>Imprimer
                </button>
                <a href="{{ route('orders.confirmation', $order->id) }}" class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50">
                    <i class="fas fa-arrow-left mr-2"></i>Retour
                </a>
            </div>

            <!-- Contenu de la facture (même que ci-dessus) -->
            @include('orders.facture-content', ['order' => $order])
        </div>
    </div>
</div>
@endsection