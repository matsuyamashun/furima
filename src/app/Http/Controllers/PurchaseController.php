<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;

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

        return view('purchase', compact('product', 'user', 'address'));
    }

    public function store(PurchaseRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product->is_sold) {
            return back()->withInput();
        }

        $payment = $request->payment_method;

        if ($payment === 'konbini') {

            Purchase::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'payment_method' => 'コンビニ支払い',
            ]);

            return redirect()->route('purchase.success', ['id' => $product->id]);
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $product->name,
                    ],
                    'unit_amount' => $product->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('purchase.success', ['id' => $product->id]),
            'cancel_url' => route('purchase', ['id' => $product->id]),
        ]);

        return redirect($session->url);
    }

    public function success($id)
    {
        DB::transaction(function () use ($id) {
            $product = Product::findOrFail($id);

            if (!$product->is_sold) {

                Purchase::create([
                    'user_id' => Auth::id(),
                    'product_id' => $product->id,
                    'payment_method' => 'カード支払い',
                ]);

                Transaction::create([
                    'product_id' => $product->id,
                    'seller_id' => $product->user_id,
                    'buyer_id' => Auth::id(),
                    'status' => 'processing',
                ]);

                $product->update(['is_sold' => true]);
            }
        });

        return redirect()->route('mypage', ['tab' => 'processing']);
    }
}
