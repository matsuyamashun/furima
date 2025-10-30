<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
    public function index()
    {
        $user = Product::all();

        $products = Product::query()
        ->when($user,function($query) use($user){
            $query->where('user_id', '!=',$user->id);
        })
        ->get();
        $tab = 'recommend';
       
        return view('index',compact('products','tab'));
    }

    public function mylist()
    {
        $user =  Auth::user();
        $products = $user->favorites ?? collect();
        $tab = 'mylist';
        return view('index',compact('products','tab'));
    }

    public function store(Request $request)
    {
        $path = $request->file('image')->store('public/images');
        $filename = basename($path);

        Product::create([
            'name' => $request->name,
            'image_url' =>'images/' . $filename,
        ]);

        return redirect()->route('index');
    }
}
