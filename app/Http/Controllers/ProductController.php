<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Categorie;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('categorie');
        
        // Filtres avancés
        if ($request->filled('type')) {
            $query->whereHas('categorie', function($q) use ($request) {
                $q->where('type', $request->type);
            });
        }
        
        if ($request->filled('genre')) {
            $query->whereHas('categorie', function($q) use ($request) {
                $q->where('genre', $request->genre);
            });
        }
        
        if ($request->filled('categorie')) {
            $query->where('categorie_id', $request->categorie);
        }
        
        if ($request->filled('prix_min')) {
            $query->where('prix', '>=', $request->prix_min);
        }
        
        if ($request->filled('prix_max')) {
            $query->where('prix', '<=', $request->prix_max);
        }
        
        if ($request->filled('tri')) {
            switch($request->tri) {
                case 'prix_asc':
                    $query->orderBy('prix', 'asc');
                    break;
                case 'prix_desc':
                    $query->orderBy('prix', 'desc');
                    break;
                case 'nouveaute':
                    $query->latest();
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }
        
        $products = $query->paginate(12)->withQueryString();
        $categories = Categorie::all();
        
        // Statistiques pour les filtres
        $stats = [
            'min_price' => Product::min('prix'),
            'max_price' => Product::max('prix')
        ];
        
        return view('products.index', compact('products', 'categories', 'stats'));
    }

    public function show($id)
    {
        $product = Product::with('categorie')->findOrFail($id);
        
        // Produits similaires
        $similaires = Product::where('categorie_id', $product->categorie_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();
        
        return view('products.show', compact('product', 'similaires'));
    }

    // Ajout rapide au panier (AJAX)
    public function addQuick(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantite'] += $request->quantite;
        } else {
            $cart[$product->id] = [
                'nom' => $product->nom,
                'prix' => $product->prix,
                'quantite' => $request->quantite,
                'image' => $product->image
            ];
        }
        
        session()->put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'count' => count($cart),
            'message' => 'Produit ajouté au panier'
        ]);
    }
    public function quickView($id)
{
    $product = Product::with('categorie')->findOrFail($id);
    return view('products.quick-view', compact('product'));
}
}