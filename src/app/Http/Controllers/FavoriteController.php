<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function store(Product $product)
    {
        $user = auth()->user();

        if (!$user->favoriteProducts()->where('product_id', $product->id)->exists()) {
            $user->favoriteProducts()->attach($product->id);
        }

    return back();
    }

    public function destroy(Product $product)
    {
        $user = auth()->user();

        if ($user->favoriteProducts()->where('product_id', $product->id)->exists()) {
            $user->favoriteProducts()->detach($product->id);
        }

        return back();
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        if ($request->filled('search')) {
        session(['search' => $request->search]);
        } elseif ($request->has('clear')) {
        session()->forget('search');
        }

        $search = session('search');

        $products = $user->favoriteProducts()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->get();

        $tab = 'mylist';

        return view('index', compact('products', 'tab', 'search'));
    }

}
