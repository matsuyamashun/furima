<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(CommentRequest $request,$id)
    {
        $product = Product::findOrFail($id);

        Comment::create([
            'product_id' =>$id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);
        return redirect()->route('item',['id' =>$id]);
    }
}
