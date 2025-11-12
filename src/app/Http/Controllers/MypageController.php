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

        if ($tabMypage === 'sell') {
            $myproducts = $user->purchasedProducts;
        } else {
            $myproducts = Product::where('user_id', $user->id)->get();
        }

        return view('mypage', compact('user', 'myproducts', 'tabMypage'));
    }
}