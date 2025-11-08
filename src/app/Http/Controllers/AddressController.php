<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Http\Requests\AddressRequest;

class AddressController extends Controller
{
    public function show()
    {
        $address = Auth::user()->address;

        return view('address',compact('address'));
    }

    public function update(AddressRequest $request)
    {
        Address::updateOrCreate(
            ['user_id' => Auth::id()],
            ['postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ]
    );

        return redirect()->route('purchase');
    }
}
