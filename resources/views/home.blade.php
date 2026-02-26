@extends('layouts.app')

@section('content')
<!-- HERO SECTION BANNIÈRE PRINCIPALE -->
<div class="relative bg-gradient-to-r from-purple-600 to-pink-600 text-white">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative max-w-7xl mx-auto px-4 py-24 sm:py-32">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-4 animate__animated animate__fadeInDown">
                Fashion Hub
            </h1>
            <p class="text-xl md:text-2xl mb-8 animate__animated animate__fadeInUp">
                Découvrez les dernières tendances de la mode
            </p>
            <div class="space-x-4">
                <a href="{{ route('products.index') }}" 
                   class="inline-block bg-white text-pink-600 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition duration-300 transform hover:scale-105">
                    Acheter maintenant
                </a>
                <a href="#nouveautes" 
                   class="inline-block border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-pink-600 transition duration-300">
                    Découvrir
                </a>
            </div>
        </div>
    </div>
</div>

<!-- CATÉGORIES POPULAIRES -->
<section class="py-16 bg-white" id="categories">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-4">Catégories populaires</h2>
        <p class="text-gray-600 text-center mb-12">Explorez nos collections par catégorie</p>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($categoriesPopulaires as $categorie)
            <a href="{{ route('products.index', ['categorie' => $categorie->id]) }}" 
               class="group relative overflow-hidden rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                <div class="aspect-w-1 aspect-h-1 bg-gradient-to-br from-pink-400 to-purple-500 p-6">
                    <div class="flex flex-col items-center justify-center text-white">
                        <svg class="w-12 h-12 mb-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
                        </svg>
                        <span class="text-sm font-semibold text-center">{{ $categorie->nom }}</span>
                    </div>
                </div>
                <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-20 transition duration-300"></div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- NOUVEAUTÉS -->
<section class="py-16 bg-gray-50" id="nouveautes">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-4">Nouveautés</h2>
        <p class="text-gray-600 text-center mb-12">Les dernières pièces de notre collection</p>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($nouveautes as $product)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden group hover:shadow-2xl transition duration-300 transform hover:-translate-y-1">
                <div class="relative h-64 bg-gray-200 overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->nom }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-pink-100 to-purple-100">
                            <svg class="w-16 h-16 text-pink-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
                            </svg>
                        </div>
                    @endif
                    
                    @if($product->stock < 5 && $product->stock > 0)
                        <span class="absolute top-2 right-2 bg-orange-500 text-white text-xs px-2 py-1 rounded-full">
                            Plus que {{ $product->stock }}
                        </span>
                    @endif
                    
                    @if($product->stock == 0)
                        <span class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                            Rupture
                        </span>
                    @endif
                </div>
                
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-1">{{ $product->nom }}</h3>
                    <p class="text-gray-500 text-sm mb-2">{{ $product->categorie->nom }}</p>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-bold text-pink-600">{{ number_format($product->prix, 0) }} €</span>
                        <a href="{{ route('products.show', $product->id) }}" 
                           class="bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700 transition duration-300 text-sm">
                            Voir
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-10">
            <a href="{{ route('products.index') }}" 
               class="inline-block bg-pink-600 text-white px-8 py-3 rounded-full hover:bg-pink-700 transition duration-300">
                Voir tous les produits
            </a>
        </div>
    </div>
</section>

<!-- BANNIÈRE PROMOTIONNELLE -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-gradient-to-r from-yellow-400 via-pink-500 to-purple-500 rounded-3xl p-12 text-center text-white">
            <h2 class="text-4xl font-bold mb-4">Livraison gratuite</h2>
            <p class="text-xl mb-8">Pour toute commande supérieure à 50€</p>
            <a href="{{ route('products.index') }}" 
               class="inline-block bg-white text-pink-600 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition duration-300">
                Profiter de l'offre
            </a>
        </div>
    </div>
</section>

<!-- MEILLEURES VENTES -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-4">Meilleures ventes</h2>
        <p class="text-gray-600 text-center mb-12">Ce que nos clients préfèrent</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($meilleuresVentes as $product)
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-4 hover:shadow-lg transition duration-300">
                <div class="relative h-48 bg-gray-200 rounded-lg mb-4 overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                            </svg>
                        </div>
                    @endif
                </div>
                <h3 class="font-semibold">{{ $product->nom }}</h3>
                <p class="text-pink-600 font-bold mt-2">{{ number_format($product->prix, 0) }} €</p>
                <button onclick="addToCartQuick({{ $product->id }})" 
                        class="mt-3 w-full bg-pink-600 text-white py-2 rounded-lg hover:bg-pink-700 transition duration-300 text-sm">
                    Ajouter au panier
                </button>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- NEWSLETTER -->
<section class="py-16 bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Restez informé</h2>
        <p class="text-gray-300 mb-8">Recevez nos dernières offres et nouveautés</p>
        
        <form class="max-w-md mx-auto flex gap-2">
            <input type="email" 
                   placeholder="Votre email" 
                   class="flex-1 px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-600">
            <button type="submit" 
                    class="bg-pink-600 text-white px-6 py-3 rounded-lg hover:bg-pink-700 transition duration-300">
                S'abonner
            </button>
        </form>
    </div>
</section>

<!-- AJOUTER ANIMATE.CSS POUR LES ANIMATIONS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<script>
function addToCartQuick(productId) {
    fetch('/cart/add-quick', {
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
            alert('Produit ajouté au panier !');
            window.location.reload();
        }
    });
}
</script>
@endsection