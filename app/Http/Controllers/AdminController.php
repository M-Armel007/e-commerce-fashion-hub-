<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Categorie;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Dashboard avec statistiques réelles
     */
    public function dashboard()
    {
        // Statistiques réelles
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total');
        $totalClients = User::where('role', 'client')->count();
        
        // Commandes récentes
        $recentOrders = Order::with('client')
            ->latest()
            ->take(5)
            ->get();
        
        // Produits en rupture de stock
        $outOfStock = Product::where('stock', 0)->count();
        
        // Produits faible stock
        $lowStock = Product::where('stock', '>', 0)
            ->where('stock', '<', 5)
            ->count();
        
        // Chiffre d'affaires du mois
        $revenueThisMonth = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');
        
        // Commandes du mois
        $ordersThisMonth = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        // Top 5 produits les plus vendus
        $topProducts = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(5)
            ->get();
        
        // Statistiques pour les graphiques (7 derniers jours)
        $chartData = [];
        $chartLabels = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->format('d/m');
            
            $dayRevenue = Order::whereDate('created_at', $date)->sum('total');
            $chartData[] = $dayRevenue;
        }
        
        $stats = [
            'products' => $totalProducts,
            'orders' => $totalOrders,
            'revenue' => $totalRevenue,
            'clients' => $totalClients,
            'out_of_stock' => $outOfStock,
            'low_stock' => $lowStock,
            'revenue_this_month' => $revenueThisMonth,
            'orders_this_month' => $ordersThisMonth,
        ];
        
        return view('admin.dashboard', compact(
            'stats', 
            'recentOrders', 
            'topProducts',
            'chartLabels',
            'chartData'
        ));
    }

    /**
     * Liste des produits avec pagination
     */
    public function products()
    {
        $products = Product::with('categorie')
            ->withCount('orderItems')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.products.index', compact('products'));
    }

    /**
     * Formulaire de création de produit
     */
    public function createProduct()
    {
        $categories = Categorie::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Enregistrement d'un nouveau produit
     */
    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'taille' => 'nullable|string',
            'couleur' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        Product::create($validated);

        return redirect()->route('admin.products')
            ->with('success', 'Produit ajouté avec succès');
    }

    /**
     * Formulaire d'édition de produit
     */
    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Categorie::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Mise à jour d'un produit
     */
    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'taille' => 'nullable|string',
            'couleur' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        $product->update($validated);

        return redirect()->route('admin.products')
            ->with('success', 'Produit mis à jour avec succès');
    }

    /**
     * Suppression d'un produit
     */
    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        
        // Supprimer l'image associée
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();

        return redirect()->route('admin.products')
            ->with('success', 'Produit supprimé avec succès');
    }

    /**
     * Liste des commandes
     */
    public function orders()
    {
        $orders = Order::with(['client', 'items.product'])
            ->latest()
            ->paginate(15);
        
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Détail d'une commande
     */
    public function showOrder($id)
    {
        $order = Order::with(['client', 'items.product'])
            ->findOrFail($id);
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Mise à jour du statut d'une commande
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'statut' => 'required|in:en_attente,confirmee,livree,annulee'
        ]);

        $order->statut = $request->statut;
        $order->save();

        return redirect()->back()
            ->with('success', 'Statut de la commande mis à jour');
    }

    /**
     * Liste des clients
     */
    public function clients()
    {
        $clients = User::where('role', 'client')
            ->withCount('orders')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Détail d'un client
     */
    public function showClient($id)
    {
        $client = User::where('role', 'client')
            ->with('orders')
            ->findOrFail($id);
        
        $totalSpent = $client->orders->sum('total');
        $ordersCount = $client->orders->count();
        
        return view('admin.clients.show', compact('client', 'totalSpent', 'ordersCount'));
    }

    /**
     * Ventes sur place
     */
    public function sales()
    {
        $sales = Order::where('type_vente', 'sur_place')
            ->with('items.product')
            ->latest()
            ->paginate(15);
        
        return view('admin.sales.index', compact('sales'));
    }

    /**
     * Formulaire de vente sur place
     */
    public function createSale()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('admin.sales.create', compact('products'));
    }

    /**
     * Enregistrement d'une vente sur place
     */
    public function storeSale(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantite' => 'required|integer|min:1',
            'client_nom' => 'nullable|string',
            'client_email' => 'nullable|email'
        ]);

        // Calculer le total
        $total = 0;
        foreach ($request->products as $item) {
            $product = Product::find($item['id']);
            $total += $product->prix * $item['quantite'];
        }

        // Créer la commande
        $order = Order::create([
            'numero_commande' => 'SP-' . strtoupper(Str::random(8)),
            'client_id' => null,
            'total' => $total,
            'statut' => 'livree',
            'type_vente' => 'sur_place'
        ]);

        // Créer les items et mettre à jour le stock
        foreach ($request->products as $item) {
            $product = Product::find($item['id']);
            
            $order->items()->create([
                'product_id' => $product->id,
                'quantite' => $item['quantite'],
                'prix_unitaire' => $product->prix
            ]);

            $product->stock -= $item['quantite'];
            $product->save();
        }

        return redirect()->route('admin.sales')
            ->with('success', 'Vente enregistrée avec succès');
    }

    /**
     * Statistiques avancées
     */
    public function statistics()
    {
        // Ventes par mois
        $monthlySales = Order::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get();

        // Top catégories
        $topCategories = Categorie::withCount('products')
            ->withSum('products', 'stock')
            ->orderBy('products_count', 'desc')
            ->get();

        // Moyenne par commande
        $avgOrderValue = Order::avg('total');

        return view('admin.statistics', compact('monthlySales', 'topCategories', 'avgOrderValue'));
    }
}