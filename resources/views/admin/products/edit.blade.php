@extends('layouts.app')

@section('title', 'Modifier un produit - Fashion Hub')

@section('content')
<div class="bg-gray-100 min-h-screen py-8">
    <div class="max-w-3xl mx-auto px-4">
        <!-- En-tête -->
        <div class="mb-6">
            <a href="{{ route('admin.products') }}" class="text-pink-600 hover:text-pink-700 mb-4 inline-block">
                <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Modifier le produit</h1>
            <p class="text-gray-600">{{ $product->nom }}</p>
        </div>

        <!-- Formulaire -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6">
                    <!-- Nom du produit -->
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">Nom du produit *</label>
                        <input type="text" name="nom" id="nom" value="{{ old('nom', $product->nom) }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600 @error('nom') border-red-500 @enderror">
                        @error('nom')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" id="description" rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <!-- Prix et Stock -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="prix" class="block text-sm font-medium text-gray-700 mb-2">Prix (€) *</label>
                            <input type="number" name="prix" id="prix" value="{{ old('prix', $product->prix) }}" required step="0.01" min="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                        </div>

                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">Stock *</label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" required min="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                        </div>
                    </div>

                    <!-- Catégorie -->
                    <div>
                        <label for="categorie_id" class="block text-sm font-medium text-gray-700 mb-2">Catégorie *</label>
                        <select name="categorie_id" id="categorie_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                            <option value="">Sélectionnez une catégorie</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}" {{ old('categorie_id', $product->categorie_id) == $categorie->id ? 'selected' : '' }}>
                                    {{ $categorie->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Taille et Couleur -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="taille" class="block text-sm font-medium text-gray-700 mb-2">Tailles disponibles</label>
                            <input type="text" name="taille" id="taille" value="{{ old('taille', $product->taille) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600"
                                   placeholder="S, M, L, XL">
                        </div>

                        <div>
                            <label for="couleur" class="block text-sm font-medium text-gray-700 mb-2">Couleur</label>
                            <input type="text" name="couleur" id="couleur" value="{{ old('couleur', $product->couleur) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600"
                                   placeholder="Blanc, Noir, Rouge">
                        </div>
                    </div>

                    <!-- Image actuelle et nouvelle image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Image actuelle</label>
                        <div class="flex items-center space-x-4">
                            <div class="h-32 w-32 bg-gray-200 rounded-lg overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <i class="fas fa-tshirt text-3xl"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex-1">
                                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Changer l'image</label>
                                <input type="file" name="image" id="image" accept="image/*"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                                <p class="mt-1 text-xs text-gray-500">Laissez vide pour conserver l'image actuelle</p>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="flex justify-end space-x-4 pt-4 border-t">
                        <a href="{{ route('admin.products') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            Annuler
                        </a>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition font-semibold">
                            <i class="fas fa-save mr-2"></i>Mettre à jour
                        </button>
                    </div>
                </div>
            </form>

            <!-- Zone dangereuse -->
            <div class="mt-8 pt-6 border-t border-red-200">
                <h3 class="text-lg font-semibold text-red-600 mb-4">Zone dangereuse</h3>
                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" 
                      onsubmit="return confirm('Êtes-vous absolument sûr de vouloir supprimer ce produit ? Cette action est irréversible.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-trash mr-2"></i>Supprimer le produit
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection