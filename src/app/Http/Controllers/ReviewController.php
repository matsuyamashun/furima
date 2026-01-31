<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $transaction = Transaction::findOrFail($request->transaction_id);

        if ($transaction->reviews()->where('reviewer_id', Auth::id())->exists()) {
            return redirect()->route('chat', $transaction->id);
        }

        $reviewedId = Auth::id() === $transaction->buyer_id ? $transaction->seller_id : $transaction->buyer_id;

        Review::create([
            'transaction_id' => $transaction->id,
            'reviewer_id' => Auth::id(),
            'reviewed_id' => $reviewedId,
            'rating' => $request->rating,
        ]);

        //お互い評価済みで完了
        if ($transaction->reviews()->count() === 2) {
            $transaction->update(['status' => 'finished']);

            return redirect()->route('index');
        }
        return redirect()->route('chat', $transaction->id);
    }
}
