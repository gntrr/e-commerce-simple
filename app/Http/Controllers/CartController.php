<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Support\ProductStore;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $carts = Auth::user()->carts;
        $total = $carts->sum('total');
        
        return view('cart.index', compact('carts', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'sku' => 'required',
            'qty' => 'integer|min:50'
        ]);

        $product = ProductStore::findBySku($request->sku);
        if (!$product) {
            return back()->with('error', 'Produk tidak ditemukan');
        }

        $cart = Cart::where('user_id', Auth::id())
                   ->where('product_sku', $request->sku)
                   ->first();

        if ($cart) {
            // Update quantity if item already exists
            $cart->update([
                'qty' => $cart->qty + ($request->qty ?? 100)
            ]);
        } else {
            // Create new cart item
            Cart::create([
                'user_id' => Auth::id(),
                'product_sku' => $product['sku'],
                'product_name' => $product['name'],
                'price' => $product['price'],
                'qty' => $request->qty ?? 100
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, Cart $cart)
    {
        $this->authorize('update', $cart);
        
        $request->validate([
            'qty' => 'required|integer|min:50'
        ]);

        $cart->update([
            'qty' => $request->qty
        ]);

        return back()->with('success', 'Keranjang berhasil diupdate!');
    }

    public function remove(Cart $cart)
    {
        $this->authorize('delete', $cart);
        
        $cart->delete();

        return back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    public function clear()
    {
        Auth::user()->carts()->delete();
        
        return back()->with('success', 'Keranjang berhasil dikosongkan!');
    }
}
