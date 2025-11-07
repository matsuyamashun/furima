<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;


class ProductController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $products = Product::when($user,function ($query) use ($user){
            $query->where('user_id','!=',$user->id);
        })->get();
        $tab = 'recommend';
       
        return view('index',compact('products','tab'));
    }

    public function store(ExhibitionRequest $request)
    {
        $path = $request->file('image')->store('public/images');
        $filename = basename($path);

        $product = Product::create([
            'user_id' =>Auth::id(),
            'name' => $request->name,
            'image_url' =>'images/' . $filename,
            'image'=>$request->image,
            'condition' => $request->condition,
            'brand' => $request->brand,
            'description' => $request->description,
            'price' => $request->price,
        ]);

            $product->categories()->sync($request->categories);
        

        return redirect()->route('index');
    }

    public function sell()
    {
        $categories = Category::all();
        return view('sell',compact('categories'));
    }

    public function show($id)
    {
        $product = Product::with('categories','comments.user.profile')->findOrfail($id);
        return view('item',compact('product'));
    }
}
