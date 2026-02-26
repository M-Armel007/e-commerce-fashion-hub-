<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Categorie;

class HomeController extends Controller
{
    public function index()
    {
        // Produits en vedette (les plus récents)
        $nouveautes = Product::with('categorie')
            ->latest()
            ->take(8)
            ->get();
        
        // Meilleures ventes (simulées par produits avec stock le plus bas)
        $meilleuresVentes = Product::with('categorie')
            ->orderBy('stock', 'asc')
            ->take(4)
            ->get();
        
        // Catégories populaires
        $categoriesPopulaires = Categorie::withCount('products')
            ->having('products_count', '>', 0)
            ->take(6)
            ->get();
        
        return view('home', compact('nouveautes', 'meilleuresVentes', 'categoriesPopulaires'));
    }
}