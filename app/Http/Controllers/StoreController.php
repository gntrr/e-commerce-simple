<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Support\ProductStore;
use App\Models\Order;
use App\Models\Cart;

class StoreController extends Controller
{
    public function index()
    {
        $products = ProductStore::all();
        return view('store.index', compact('products'));
    }
    
    public function show($sku)
    {
        $product = ProductStore::findBySku($sku);
        
        if (!$product) {
            abort(404);
        }
        
        return view('store.show', compact('product'));
    }
    
    public function checkout(Request $request)
    {
        if ($request->has('from_cart')) {
            return $this->checkoutFromCart($request);
        }
        
        return $this->checkoutDirect($request);
    }
    
    private function checkoutDirect(Request $request)
    {
        $request->validate([
            'sku' => 'required',
            'qty' => 'integer|min:50',
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);
        
        $product = ProductStore::findBySku($request->sku);
        if (!$product) {
            abort(422, 'Product not found');
        }
        
        // Generate order code
        $orderCode = 'INV-' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);
        
        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'code' => $orderCode,
            'product_sku' => $product['sku'],
            'product_name' => $product['name'],
            'price' => $product['price'],
            'qty' => $request->qty ?? 100,
            'customer_name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address
        ]);
        
        return $this->generateWhatsAppRedirect($order);
    }
    
    private function checkoutFromCart(Request $request)
    {
        $this->middleware('auth');
        
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);
        
        $user = Auth::user();
        $carts = $user->carts;
        
        if ($carts->isEmpty()) {
            return back()->with('error', 'Keranjang kosong!');
        }
        
        $orders = [];
        $totalAmount = 0;
        
        foreach ($carts as $cart) {
            $orderCode = 'INV-' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);
            
            $order = Order::create([
                'user_id' => $user->id,
                'code' => $orderCode,
                'product_sku' => $cart->product_sku,
                'product_name' => $cart->product_name,
                'price' => $cart->price,
                'qty' => $cart->qty,
                'customer_name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address
            ]);
            
            $orders[] = $order;
            $totalAmount += $cart->total;
        }
        
        // Clear cart after successful order
        $user->carts()->delete();
        
        return $this->generateWhatsAppRedirectMultiple($orders, $request, $totalAmount);
    }
    
    private function generateWhatsAppRedirect($order)
    {
        $total = $order->price * $order->qty;
        $message = "Halo, saya pesan {$order->product_name} ({$order->qty} gram)\n";
        $message .= "Kode: {$order->code}\n";
        $message .= "Total: Rp " . number_format($total, 0, ',', '.') . "\n";
        $message .= "Nama: {$order->customer_name}\n";
        $message .= "Telp: {$order->phone}\n";
        $message .= "Alamat: {$order->address}";
        
        $waNumber = env('WA_SELLER_NUMBER');
        $waUrl = 'https://wa.me/' . $waNumber . '?text=' . rawurlencode($message);
        
        return redirect($waUrl);
    }
    
    private function generateWhatsAppRedirectMultiple($orders, $request, $totalAmount)
    {
        $message = "Halo, saya pesan:\n";
        
        foreach ($orders as $order) {
            $message .= "- {$order->product_name} ({$order->qty} gram) - Rp " . number_format($order->price * $order->qty, 0, ',', '.') . "\n";
        }
        
        $message .= "\nTotal: Rp " . number_format($totalAmount, 0, ',', '.') . "\n";
        $message .= "Nama: {$request->name}\n";
        $message .= "Telp: {$request->phone}\n";
        $message .= "Alamat: {$request->address}";
        
        $waNumber = env('WA_SELLER_NUMBER');
        $waUrl = 'https://wa.me/' . $waNumber . '?text=' . rawurlencode($message);
        
        return redirect($waUrl);
    }
    
    public function myOrders()
    {
        $this->middleware('auth');
        
        $orders = Auth::user()->orders()->latest()->paginate(10);
        
        return view('store.orders', compact('orders'));
    }
}
