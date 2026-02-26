@extends('layouts.app')

@section('title', 'Notre Boutique - Fashion Hub')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header de la boutique -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Notre Collection</h1>
            <p class="text-gray-600">Découvrez les dernières tendances de la mode</p>
        </div>

        <!-- Barre de filtres mobile-friendly -->
        <div class="lg:hidden mb-4">
            <button id="mobile-filter-toggle" class="w-full bg-white p-4 rounded-lg shadow flex items-center justify-between">
                <span class="font-semibold">Filtres et tri</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                </svg>
            </button>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filtres -->
            <div class="lg:w-1/4" id="filter-sidebar">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-4">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold">Filtres</h2>
                        <a href="{{ route('products.index') }}" class="text-sm text-pink-600 hover:text-pink-700">
                            Réinitialiser
                        </a>
                    </div>

                    <form method="GET" action="{{ route('products.index') }}" id="filter-form">
                        <!-- Tri -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Trier par</label>
                            <select name="tri" class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                                <option value="nouveaute" {{ request('tri') == 'nouveaute' ? 'selected' : '' }}>Nouveautés</option>
                                <option value="prix_asc" {{ request('tri') == 'prix_asc' ? 'selected' : '' }}>Prix croissant</option>
                                <option value="prix_desc" {{ request('tri') == 'prix_desc' ? 'selected' : '' }}>Prix décroissant</option>
                            </select>
                        </div>

                        <!-- Type -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Type</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="type" value="" class="mr-2" {{ !request('type') ? 'checked' : '' }}>
                                    <span>Tous</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="type" value="adulte" class="mr-2" {{ request('type') == 'adulte' ? 'checked' : '' }}>
                                    <span>Adulte</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="type" value="enfant" class="mr-2" {{ request('type') == 'enfant' ? 'checked' : '' }}>
                                    <span>Enfant</span>
                                </label>
                            </div>
                        </div>

                        <!-- Genre -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Genre</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="genre" value="" class="mr-2" {{ !request('genre') ? 'checked' : '' }}>
                                    <span>Tous</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="genre" value="homme" class="mr-2" {{ request('genre') == 'homme' ? 'checked' : '' }}>
                                    <span>Homme</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="genre" value="femme" class="mr-2" {{ request('genre') == 'femme' ? 'checked' : '' }}>
                                    <span>Femme</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="genre" value="mixte" class="mr-2" {{ request('genre') == 'mixte' ? 'checked' : '' }}>
                                    <span>Mixte</span>
                                </label>
                            </div>
                        </div>

                        <!-- Catégorie -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Catégorie</label>
                            <select name="categorie" class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                                <option value="">Toutes les catégories</option>
                                @foreach($categories as $categorie)
                                    <option value="{{ $categorie->id }}" {{ request('categorie') == $categorie->id ? 'selected' : '' }}>
                                        {{ $categorie->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Prix -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Prix</label>
                            <div class="flex gap-2">
                                <input type="number" name="prix_min" placeholder="Min" 
                                       value="{{ request('prix_min') }}"
                                       class="w-1/2 border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                                <input type="number" name="prix_max" placeholder="Max"
                                       value="{{ request('prix_max') }}"
                                       class="w-1/2 border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-pink-600 text-white py-3 rounded-lg hover:bg-pink-700 transition duration-300 font-semibold">
                            Appliquer les filtres
                        </button>
                    </form>
                </div>
            </div>

            <!-- Grille des produits -->
            <div class="lg:w-3/4">
                @if($products->count() > 0)
                    <!-- Résultats -->
                    <div class="mb-4 text-sm text-gray-600">
                        {{ $products->firstItem() }} - {{ $products->lastItem() }} sur {{ $products->total() }} produits
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <div class="group bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 transform hover:-translate-y-1">
                                <!-- Image -->
                                <div class="relative h-64 bg-gray-200 overflow-hidden">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->nom }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-pink-100 to-purple-100">
                                            <svg class="w-16 h-16 text-pink-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <!-- Badges -->
                                    @if($product->stock <= 5 && $product->stock > 0)
                                        <span class="absolute top-2 left-2 bg-orange-500 text-white text-xs px-2 py-1 rounded-full">
                                            Plus que {{ $product->stock }}
                                        </span>
                                    @endif
                                    
                                    @if($product->stock == 0)
                                        <span class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                            Rupture
                                        </span>
                                    @endif
                                    
                                    <!-- Actions rapides -->
                                    <div class="absolute bottom-2 right-2 opacity-0 group-hover:opacity-100 transition duration-300">
                                        <button onclick="quickView({{ $product->id }})" 
                                                class="bg-white text-gray-800 p-2 rounded-full shadow-lg hover:bg-pink-600 hover:text-white transition duration-300 mr-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Infos produit -->
                                <div class="p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs text-pink-600 font-semibold uppercase tracking-wide">
                                            {{ $product->categorie->nom }}
                                        </span>
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    
                                    <h3 class="font-semibold text-lg mb-2">{{ $product->nom }}</h3>
                                    
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="text-2xl font-bold text-pink-600">{{ number_format($product->prix, 0) }}</span>
                                            <span class="text-gray-600 text-sm">€</span>
                                        </div>
                                        
                                        @if($product->stock > 0)
                                            <button onclick="addToCart({{ $product->id }})" 
                                                    class="bg-pink-600 text-white p-2 rounded-full hover:bg-pink-700 transition duration-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                            </button>
                                        @else
                                            <button disabled class="bg-gray-400 text-white p-2 rounded-full cursor-not-allowed">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                    
                                    <a href="{{ route('products.show', $product->id) }}" 
                                       class="mt-3 block text-center text-sm text-pink-600 hover:text-pink-700">
                                        Voir détails →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                        <svg class="w-24 h-24 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">Aucun produit trouvé</h3>
                        <p class="text-gray-500 mb-6">Essayez de modifier vos filtres</p>
                        <a href="{{ route('products.index') }}" class="inline-block bg-pink-600 text-white px-6 py-3 rounded-lg hover:bg-pink-700">
                            Voir tous les produits
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Quick View (à cacher par défaut) -->
<div id="quickViewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl max-w-2xl w-full mx-4 max-h-screen overflow-y-auto" id="quickViewContent">
        <!-- Contenu chargé dynamiquement -->
    </div>
</div>

<script>
// Filtres mobiles
document.getElementById('mobile-filter-toggle')?.addEventListener('click', function() {
    const sidebar = document.getElementById('filter-sidebar');
    sidebar.classList.toggle('hidden');
    sidebar.classList.toggle('fixed');
    sidebar.classList.toggle('inset-0');
    sidebar.classList.toggle('z-50');
    sidebar.classList.toggle('bg-white');
    sidebar.classList.toggle('p-4');
    sidebar.classList.toggle('overflow-y-auto');
});

// Ajout au panier AJAX
function addToCart(productId) {
    fetch('{{ route("cart.add-quick") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            product_id: productId,
            quantite: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            // Mettre à jour le compteur du panier
            const cartCount = document.querySelector('.cart-count');
            if(cartCount) {
                cartCount.textContent = data.count;
                cartCount.classList.remove('hidden');
            }
            
            // Notification
            showNotification(data.message, 'success');
        }
    });
}

// Quick view
function quickView(productId) {
    fetch(`/products/${productId}/quick-view`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('quickViewContent').innerHTML = html;
            document.getElementById('quickViewModal').classList.remove('hidden');
            document.getElementById('quickViewModal').classList.add('flex');
        });
}

// Fermer le modal
document.getElementById('quickViewModal')?.addEventListener('click', function(e) {
    if(e.target === this) {
        this.classList.add('hidden');
        this.classList.remove('flex');
    }
});

// Notification
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 animate__animated animate__fadeInRight ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>

<style>
.cart-count {
    @apply absolute -top-2 -right-2 bg-pink-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs;
}
</style>
@endsection