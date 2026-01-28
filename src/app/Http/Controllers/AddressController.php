<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Http\Requests\AddressRequest;

class AddressController extends Controller
{
    public function show($id)
    {
        $address = Auth::user()->address;
        $product_id = $id;

        return view('address',compact('address','product_id'));
    }

    public function update(AddressRequest $request,$product_id)
    {
        Address::updateOrCreate(
            ['user_id' => Auth::id()],
            ['postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ]
    );
        return redirect()->route('purchase',['id' =>$product_id]);
    }
}
