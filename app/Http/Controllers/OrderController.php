<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide');
        }
        
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['prix'] * $item['quantite'];
        }
        
        return view('orders.checkout', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide');
        }
        
        // Validation
        $validated = $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email',
            'telephone' => 'nullable',
            'adresse' => 'required',
        ]);
        
        // Créer ou trouver le client
        $client = Client::firstOrCreate(
            ['email' => $validated['email']],
            [
                'nom' => $validated['nom'],
                'prenom' => $validated['prenom'],
                'telephone' => $validated['telephone'] ?? null,
                'adresse' => $validated['adresse']
            ]
        );
        
        // Calculer le total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['prix'] * $item['quantite'];
        }
        
        // Créer la commande
        $order = Order::create([
            'numero_commande' => 'CMD-' . strtoupper(Str::random(8)),
            'client_id' => $client->id,
            'total' => $total,
            'statut' => 'en_attente',
            'type_vente' => 'en_ligne'
        ]);
        
        // Créer les items et mettre à jour le stock
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantite' => $item['quantite'],
                'prix_unitaire' => $item['prix']
            ]);
            
            // Mettre à jour le stock
            $product->stock -= $item['quantite'];
            $product->save();
        }
        
        // Vider le panier
        session()->forget('cart');
        
        return redirect()->route('orders.confirmation', $order->id)
            ->with('success', 'Commande confirmée !');
    }

    public function confirmation($id)
    {
        $order = Order::with(['client', 'items.product'])->findOrFail($id);
        return view('orders.confirmation', compact('order'));
    }

    public function facture($id)
    {
        $order = Order::with(['client', 'items.product'])->findOrFail($id);
        $facture = $order->generateFacture();
        
        return view('orders.facture', compact('order', 'facture'));
    }

    // ADMIN
    public function adminIndex()
    {
        $orders = Order::with('client')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function adminShow($id)
    {
        $order = Order::with(['client', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->statut = $request->statut;
        $order->save();
        
        return redirect()->back()->with('success', 'Statut mis à jour');
    }
}