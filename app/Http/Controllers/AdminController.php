<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $recentOrders = Order::with('client')->latest()->take(5)->get();
        
        // Statistiques simples
        $stats = [
            'products' => $totalProducts,
            'orders' => $totalOrders,
            'revenue' => Order::sum('total')
        ];
        
        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }

    public function products()
    {
        $products = Product::with('categorie')->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function sales()
    {
        $sales = Order::where('type_vente', 'sur_place')
            ->with('client')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.sales.index', compact('sales'));
    }

    // Vente sur place
    public function createSale()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('admin.sales.create', compact('products'));
    }

    public function storeSale(Request $request)
    {
        $validated = $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantite' => 'required|integer|min:1',
            'client_nom' => 'nullable',
            'client_email' => 'nullable|email'
        ]);
        
        // Créer client si nécessaire
        $client = null;
        if (!empty($validated['client_email'])) {
            $client = Client::firstOrCreate(
                ['email' => $validated['client_email']],
                ['nom' => $validated['client_nom'] ?? 'Client sur place']
            );
        }
        
        // Calculer total
        $total = 0;
        foreach ($validated['products'] as $item) {
            $product = Product::find($item['id']);
            $total += $product->prix * $item['quantite'];
        }
        
        // Créer commande
        $order = Order::create([
            'numero_commande' => 'SP-' . strtoupper(Str::random(8)),
            'client_id' => $client ? $client->id : null,
            'total' => $total,
            'statut' => 'livree',
            'type_vente' => 'sur_place'
        ]);
        
        // Créer items et mettre à jour stock
        foreach ($validated['products'] as $item) {
            $product = Product::find($item['id']);
            
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantite' => $item['quantite'],
                'prix_unitaire' => $product->prix
            ]);
            
            $product->stock -= $item['quantite'];
            $product->save();
        }
        
        return redirect()->route('admin.sales')
            ->with('success', 'Vente enregistrée avec succès. Facture #' . $order->numero_commande);
    }
}