<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PurchaseRequest;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $user = Auth::user();
        $address = $user->address;
        if (!$address) {
        $profile = $user->profile;
        $address = (object)[
            'postal_code' => $profile->postal_code ?? '',
            'address' => $profile->address ?? '',
            'building' => $profile->building ?? '',
        ];
    }
        $product_id = $product->id;

        return view('purchase',compact('product','user','address','product_id'));
    }

    public function store(PurchaseRequest $request,$id)
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

        return back()->withInput();
    } 
}
