@extends('layouts.app')

@section('title', 'Ajouter un produit - Fashion Hub')

@section('content')
<div class="bg-gray-100 min-h-screen py-8">
    <div class="max-w-3xl mx-auto px-4">
        <!-- En-tête -->
        <div class="mb-6">
            <a href="{{ route('admin.products') }}" class="text-pink-600 hover:text-pink-700 mb-4 inline-block">
                <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Ajouter un produit</h1>
            <p class="text-gray-600">Remplissez les informations ci-dessous</p>
        </div>

        <!-- Formulaire -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 gap-6">
                    <!-- Nom du produit -->
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">Nom du produit *</label>
                        <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600 @error('nom') border-red-500 @enderror"
                               placeholder="Ex: T-shirt blanc basic">
                        @error('nom')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" id="description" rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600"
                                  placeholder="Description détaillée du produit...">{{ old('description') }}</textarea>
                    </div>

                    <!-- Prix et Stock (2 colonnes) -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="prix" class="block text-sm font-medium text-gray-700 mb-2">Prix (€) *</label>
                            <input type="number" name="prix" id="prix" value="{{ old('prix') }}" required step="0.01" min="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600 @error('prix') border-red-500 @enderror"
                                   placeholder="29.99">
                            @error('prix')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">Stock *</label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock') }}" required min="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600 @error('stock') border-red-500 @enderror"
                                   placeholder="50">
                            @error('stock')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Catégorie -->
                    <div>
                        <label for="categorie_id" class="block text-sm font-medium text-gray-700 mb-2">Catégorie *</label>
                        <select name="categorie_id" id="categorie_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600 @error('categorie_id') border-red-500 @enderror">
                            <option value="">Sélectionnez une catégorie</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}" {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
                                    {{ $categorie->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('categorie_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Taille et Couleur (2 colonnes) -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="taille" class="block text-sm font-medium text-gray-700 mb-2">Tailles disponibles</label>
                            <input type="text" name="taille" id="taille" value="{{ old('taille') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600"
                                   placeholder="S, M, L, XL">
                            <p class="mt-1 text-xs text-gray-500">Séparez les tailles par des virgules</p>
                        </div>

                        <div>
                            <label for="couleur" class="block text-sm font-medium text-gray-700 mb-2">Couleur</label>
                            <input type="text" name="couleur" id="couleur" value="{{ old('couleur') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600"
                                   placeholder="Blanc, Noir, Rouge">
                        </div>
                    </div>

                    <!-- Image -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Image du produit</label>
                        <div class="mt-1 flex items-center space-x-4">
                            <div class="flex-shrink-0 h-32 w-32 bg-gray-200 rounded-lg overflow-hidden border-2 border-dashed border-gray-300" id="imagePreview">
                                <img src="" alt="Prévisualisation" class="w-full h-full object-cover hidden" id="preview">
                                <div class="w-full h-full flex items-center justify-center text-gray-400" id="placeholder">
                                    <i class="fas fa-cloud-upload-alt text-3xl"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <input type="file" name="image" id="image" accept="image/*"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600"
                                       onchange="previewImage(this)">
                                <p class="mt-1 text-xs text-gray-500">Formats acceptés : JPEG, PNG, JPG, GIF (Max 2Mo)</p>
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Boutons -->
                    <div class="flex justify-end space-x-4 pt-4 border-t">
                        <a href="{{ route('admin.products') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            Annuler
                        </a>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition font-semibold">
                            <i class="fas fa-save mr-2"></i>Enregistrer le produit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    const placeholder = document.getElementById('placeholder');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection