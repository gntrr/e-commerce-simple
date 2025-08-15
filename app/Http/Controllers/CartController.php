<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;

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
            'qty' => 'integer|min:1'
        ]);

        $productModel = Product::where('sku', $request->sku)
            ->where('is_active', true)
            ->first();
        if (!$productModel) {
            return back()->with('error', 'Produk tidak ditemukan');
        }
        
        $product = [
            'sku' => $productModel->sku,
            'name' => $productModel->name,
            'price' => $productModel->price,
            'photo' => $productModel->photo,
            'desc' => $productModel->description
        ];

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
                'qty' => $request->qty ?? 1
            ]);
        }

        return back()->with('success', "✅ {$product['name']} berhasil ditambahkan ke keranjang!");
    }

    public function update(Request $request, Cart $cart)
    {
        $this->authorize('update', $cart);
        
        $request->validate([
            'qty' => 'required|integer|min:1'
        ]);
        
        $cart->update([
            'qty' => $request->qty
        ]);
        
        return redirect()->back()->with('success', "📝 Jumlah {$cart->product_name} berhasil diperbarui!");
    }

    public function remove(Cart $cart)
    {
        $this->authorize('delete', $cart);
        
        $productName = $cart->product_name;
        $cart->delete();
        
        return redirect()->back()->with('success', "🗑️ {$productName} berhasil dihapus dari keranjang!");
    }

    public function clear()
    {
        auth()->user()->carts()->delete();
        
        return redirect()->back()->with('success', "🧹 Keranjang berhasil dikosongkan!");
    }
}
