<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function show($id)
    {
        $product = Product::findOrFail($id);

        $user = Auth::user();

        return view('purchase',compact('product','user'));
    }

    public function store(Request $request,$id)
    {
        $product = Product::findOrFail($id);

        if($product->is_sold){
            return back();
        }

        Purchase::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'payment_method' => $request->payment_method,
        ]);

        $product->update(['is_sold' => true]);

        return redirect()->route('mypage');
    } 
}
