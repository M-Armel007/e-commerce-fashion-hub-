<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['prix'] * $item['quantite'];
        }
        
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantite'] += $request->quantite ?? 1;
        } else {
            $cart[$product->id] = [
                'nom' => $product->nom,
                'prix' => $product->prix,
                'quantite' => $request->quantite ?? 1,
                'image' => $product->image
            ];
        }
        
        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', 'Produit ajouté au panier');
    }

    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        
        foreach ($request->quantites as $id => $quantite) {
            if (isset($cart[$id])) {
                $cart[$id]['quantite'] = $quantite;
            }
        }
        
        session()->put('cart', $cart);
        
        return redirect()->route('cart.index')->with('success', 'Panier mis à jour');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        return redirect()->route('cart.index')->with('success', 'Produit retiré du panier');
    }

    public function clear()
    {
        session()->forget('cart');
        
        return redirect()->route('cart.index')->with('success', 'Panier vidé');
    }
}