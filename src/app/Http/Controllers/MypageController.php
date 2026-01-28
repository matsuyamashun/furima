<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $tabMypage = $request->query('tab', 'buy');

        $sellingTransactions = $user->sellingTransactions()->where('status', 'processing');
        $buyingTransactions = $user->buyingTransactions()->where('status', 'processing');
        $transactionsCount = $sellingTransactions->get()->concat($buyingTransactions->get())->count();

        $myproducts = collect();//初期化
        $transactions = collect();

        if ($tabMypage === 'buy') {

            $myproducts = Product::where('user_id', $user->id)->get();
        } elseif ($tabMypage === 'sell') {

            $myproducts = $user->purchasedProducts;
        } elseif ($tabMypage === 'processing') {
            $transactions = $sellingTransactions->with('product')->get()->concat($buyingTransactions->with('product')->get());
        }
        return view('mypage', compact('user', 'myproducts', 'tabMypage', 'transactionsCount', 'transactions'));
    }
}
