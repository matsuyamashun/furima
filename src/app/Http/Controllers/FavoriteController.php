<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function store($productId)
    {
        $user = Auth::user();

        $user->favoriteProducts()->syncWithoutDetaching([$productId]);

        if(!$user->favoriteProducts()->where('product_id',$productId)->exists()) {
            $user->favoriteProducts()->attach($productId);
        }
        return back();
    }

    public function destroy($productId)
    {
        $user = Auth::user();
        $user->favoriteProducts()->detach($productId);

        return back();
    }

    public function index()
{
    $user = Auth()->user();

    $products = $user->favoriteProducts()->get();
    $tab = 'mylist';
    return view('index', compact('products','tab'));
}
}
