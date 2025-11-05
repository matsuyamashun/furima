<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function index() 
    {
        $user = Auth::user();

        $myproducts = Product::where('user_id',$user->id)->get();
        $tabMypage = 'listed';

        return view('mypage',compact('user','myproducts','tabMypage'));
    }

        public function purchased()
    {
        $user =  Auth::user();
        $myproducts = $user->favoriteProducts ?? collect();
        $tabMypage = 'purchased';
        return view('mypage',compact('user','myproducts','tabMypage'));
    }
}