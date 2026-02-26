<div class="p-6">
    <div class="flex justify-end">
        <button onclick="document.getElementById('quickViewModal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
            <i class="fas fa-times text-2xl"></i>
        </button>
    </div>
    
    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <div class="h-64 bg-gray-200 rounded-lg overflow-hidden">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-pink-100 to-purple-100">
                        <i class="fas fa-tshirt text-6xl text-pink-400"></i>
                    </div>
                @endif
            </div>
        </div>
        
        <div>
            <h3 class="text-2xl font-bold mb-2">{{ $product->nom }}</h3>
            <p class="text-gray-600 mb-4">{{ $product->categorie->nom }}</p>
            <p class="text-3xl font-bold text-pink-600 mb-4">{{ number_format($product->prix, 2) }} €</p>
            <p class="text-gray-700 mb-4">{{ Str::limit($product->description, 150) }}</p>
            
            @if($product->stock > 0)
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="flex items-center gap-2 mb-4">
                        <input type="number" name="quantite" value="1" min="1" max="{{ $product->stock }}"
                               class="w-20 border rounded-lg px-3 py-2">
                        <button type="submit" class="flex-1 bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700">
                            Ajouter au panier
                        </button>
                    </div>
                </form>
            @else
                <p class="text-red-600 font-semibold">Rupture de stock</p>
            @endif
            
            <a href="{{ route('products.show', $product->id) }}" class="text-pink-600 hover:text-pink-700">
                Voir détails complets →
            </a>
        </div>
    </div>
</div>