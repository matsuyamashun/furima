<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ExhibitionRequest;


class ProductController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $products = Product::all();
        
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

    public function store(ExhibitionRequest $request)
    {
        $path = $request->file('image')->store('public/images');
        $filename = basename($path);

        Product::create([
            'name' => $request->name,
            'image_url' =>'images/' . $filename,
            'image'=>$request->image,
            'category' => $request->category,
            'condition' => $request->condition,
            'brand' => $request->brand,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return redirect()->route('index');
    }

    public function sell()
    {
        return view('sell');
    }
}
