<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\ProductStore;
use App\Models\Order;

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
        $request->validate([
            'sku' => 'required',
            'qty' => 'integer|min:1',
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
            'code' => $orderCode,
            'product_sku' => $product['sku'],
            'product_name' => $product['name'],
            'price' => $product['price'],
            'qty' => $request->qty ?? 1,
            'customer_name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address
        ]);
        
        // Generate WhatsApp message
        $total = $product['price'] * ($request->qty ?? 1);
        $message = "Halo, saya pesan {$product['name']} (x{$order->qty})\n";
        $message .= "Kode: {$orderCode}\n";
        $message .= "Total: Rp " . number_format($total, 0, ',', '.') . "\n";
        $message .= "Nama: {$request->name}\n";
        $message .= "Telp: {$request->phone}\n";
        $message .= "Alamat: {$request->address}";
        
        $waNumber = env('WA_SELLER_NUMBER');
        $waUrl = 'https://wa.me/' . $waNumber . '?text=' . rawurlencode($message);
        
        return redirect($waUrl);
    }
}
