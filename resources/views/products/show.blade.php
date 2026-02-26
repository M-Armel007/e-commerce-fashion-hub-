@extends('layouts.app')

@section('title', $product->nom . ' - Fashion Hub')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Fil d'Ariane -->
        <nav class="text-sm mb-8">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-pink-600">Accueil</a>
                    <svg class="w-3 h-3 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-pink-600">Boutique</a>
                    <svg class="w-3 h-3 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </li>
                <li class="text-pink-600 font-semibold">{{ $product->nom }}</li>
            </ol>
        </nav>

        <!-- Produit principal -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-12">
            <div class="md:flex">
                <!-- Galerie d'images -->
                <div class="md:w-1/2 p-8">
                    <div class="relative">
                        <!-- Image principale -->
                        <div class="aspect-w-1 aspect-h-1 bg-gray-100 rounded-xl overflow-hidden mb-4">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->nom }}" 
                                     class="w-full h-full object-cover" 
                                     id="mainImage">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-pink-100 to-purple-100">
                                    <svg class="w-24 h-24 text-pink-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Miniatures -->
                        <div class="grid grid-cols-4 gap-2">
                            @if($product->image)
                                <div class="aspect-w-1 aspect-h-1 bg-gray-100 rounded-lg overflow-hidden cursor-pointer border-2 border-transparent hover:border-pink-600 transition"
                                     onclick="changeImage('{{ asset('storage/' . $product->image) }}')">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="" class="w-full h-full object-cover">
                                </div>
                            @endif
                            <!-- Ajoutez d'autres miniatures ici si vous avez plusieurs images -->
                        </div>
                    </div>
                </div>
                
                <!-- Détails produit -->
                <div class="md:w-1/2 p-8">
                    <!-- Catégorie -->
                    <div class="mb-4">
                        <span class="text-sm font-semibold text-pink-600 uppercase tracking-wide">
                            {{ $product->categorie->nom }}
                        </span>
                    </div>
                    
                    <!-- Titre -->
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->nom }}</h1>
                    
                    <!-- Prix et disponibilité -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <span class="text-4xl font-bold text-pink-600">{{ number_format($product->prix, 2) }}</span>
                            <span class="text-gray-600 text-xl">€</span>
                        </div>
                        <div class="text-right">
                            @if($product->stock > 10)
                                <span class="text-green-600 font-semibold">
                                    <svg class="w-5 h-5 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    En stock
                                </span>
                            @elseif($product->stock > 0)
                                <span class="text-orange-600 font-semibold">
                                    <svg class="w-5 h-5 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Plus que {{ $product->stock }} en stock
                                </span>
                            @else
                                <span class="text-red-600 font-semibold">
                                    <svg class="w-5 h-5 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    Rupture de stock
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Description</h3>
                        <p class="text-gray-700 leading-relaxed">
                            {{ $product->description ?? 'Aucune description disponible pour ce produit.' }}
                        </p>
                    </div>
                    
                    <!-- Caractéristiques -->
                    @if($product->taille || $product->couleur)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-3">Caractéristiques</h3>
                            <div class="grid grid-cols-2 gap-4">
                                @if($product->taille)
                                    <div>
                                        <span class="text-sm text-gray-600 block">Tailles disponibles</span>
                                        <span class="font-semibold">{{ $product->taille }}</span>
                                    </div>
                                @endif
                                
                                @if($product->couleur)
                                    <div>
                                        <span class="text-sm text-gray-600 block">Couleur</span>
                                        <span class="font-semibold">{{ $product->couleur }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                    
                    <!-- Ajout au panier -->
                    @if($product->stock > 0)
                        <form action="{{ route('cart.add') }}" method="POST" class="mb-6">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <div class="flex items-center gap-4">
                                <div>
                                    <label for="quantite" class="block text-sm font-medium text-gray-700 mb-1">Quantité</label>
                                    <div class="flex items-center border rounded-lg">
                                        <button type="button" onclick="decrementQuantity()" 
                                                class="px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-l-lg transition">
                                            -
                                        </button>
                                        <input type="number" name="quantite" id="quantite" value="1" min="1" max="{{ $product->stock }}"
                                               class="w-16 text-center border-0 focus:ring-0">
                                        <button type="button" onclick="incrementQuantity({{ $product->stock }})" 
                                                class="px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-r-lg transition">
                                            +
                                        </button>
                                    </div>
                                </div>
                                
                                <button type="submit" 
                                        class="flex-1 bg-pink-600 text-white px-6 py-3 rounded-lg hover:bg-pink-700 transition duration-300 font-semibold flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Ajouter au panier
                                </button>
                            </div>
                        </form>
                        
                        <!-- Boutons d'action supplémentaires -->
                        <div class="flex gap-4">
                            <button onclick="addToWishlist({{ $product->id }})" 
                                    class="flex-1 border-2 border-pink-600 text-pink-600 px-4 py-2 rounded-lg hover:bg-pink-50 transition duration-300 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                Favoris
                            </button>
                            <button onclick="shareProduct()" 
                                    class="border-2 border-gray-300 text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-50 transition duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                </svg>
                            </button>
                        </div>
                    @else
                        <div class="bg-red-50 border border-red-200 rounded-lg p-6 text-center mb-6">
                            <p class="text-red-600 font-semibold mb-2">Produit temporairement indisponible</p>
                            <p class="text-sm text-gray-600">Recevez une notification quand il sera de retour</p>
                            <button class="mt-3 bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                                M'avertir
                            </button>
                        </div>
                    @endif
                    
                    <!-- Informations complémentaires -->
                    <div class="border-t pt-6 mt-6">
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div>
                                <svg class="w-6 h-6 text-pink-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-xs text-gray-600">Livraison 24/48h</span>
                            </div>
                            <div>
                                <svg class="w-6 h-6 text-pink-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <span class="text-xs text-gray-600">Paiement sécurisé</span>
                            </div>
                            <div>
                                <svg class="w-6 h-6 text-pink-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                <span class="text-xs text-gray-600">Retours gratuits</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Produits similaires -->
        @if(isset($similaires) && $similaires->count() > 0)
            <section class="mb-12">
                <h2 class="text-2xl font-bold mb-6">Vous aimerez aussi</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($similaires as $similaire)
                        <a href="{{ route('products.show', $similaire->id) }}" 
                           class="group bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                            <div class="aspect-w-1 aspect-h-1 bg-gray-200">
                                @if($similaire->image)
                                    <img src="{{ asset('storage/' . $similaire->image) }}" 
                                         alt="" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-pink-100 to-purple-100">
                                        <svg class="w-8 h-8 text-pink-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-3">
                                <h3 class="font-semibold text-sm">{{ $similaire->nom }}</h3>
                                <p class="text-pink-600 font-bold mt-1">{{ number_format($similaire->prix, 0) }} €</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
        
        <!-- Avis clients -->
        <section class="bg-white rounded-2xl shadow-xl p-8">
            <h2 class="text-2xl font-bold mb-6">Avis clients</h2>
            
            <div class="flex items-center gap-8 mb-8">
                <div class="text-center">
                    <div class="text-5xl font-bold text-pink-600">4.5</div>
                    <div class="flex mt-2">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @endfor
                    </div>
                    <p class="text-sm text-gray-600 mt-1">128 avis</p>
                </div>
                
                <div class="flex-1">
                    <button class="w-full bg-pink-600 text-white px-6 py-3 rounded-lg hover:bg-pink-700 transition font-semibold">
                        Donner mon avis
                    </button>
                </div>
            </div>
            
            <!-- Liste des avis -->
            <div class="space-y-4">
                <div class="border-b pb-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-semibold">Marie L.</span>
                        <span class="text-sm text-gray-500">Il y a 2 jours</span>
                    </div>
                    <div class="flex mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= 5 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @endfor
                    </div>
                    <p class="text-gray-700">Superbe qualité, conforme à la description. Je recommande !</p>
                </div>
                
                <div class="border-b pb-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-semibold">Thomas D.</span>
                        <span class="text-sm text-gray-500">Il y a 5 jours</span>
                    </div>
                    <div class="flex mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @endfor
                    </div>
                    <p class="text-gray-700">Très beau produit, livraison rapide. Parfait !</p>
                </div>
            </div>
            
            <button class="mt-4 text-pink-600 hover:text-pink-700 font-semibold">
                Voir tous les avis →
            </button>
        </section>
    </div>
</div>

<script>
function changeImage(src) {
    document.getElementById('mainImage').src = src;
}

function decrementQuantity() {
    const input = document.getElementById('quantite');
    const currentValue = parseInt(input.value);
    if (currentValue > 1) {
        input.value = currentValue - 1;
    }
}

function incrementQuantity(max) {
    const input = document.getElementById('quantite');
    const currentValue = parseInt(input.value);
    if (currentValue < max) {
        input.value = currentValue + 1;
    }
}

function addToWishlist(productId) {
    // À implémenter avec votre système de wishlist
    alert('Produit ajouté aux favoris !');
}

function shareProduct() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $product->nom }}',
            text: '{{ $product->description }}',
            url: window.location.href
        });
    } else {
        // Fallback
        navigator.clipboard.writeText(window.location.href);
        alert('Lien copié dans le presse-papier !');
    }
}
</script>
@endsection