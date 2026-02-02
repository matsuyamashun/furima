<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $tabMypage = $request->query('tab', 'buy');

        $sellingTransactions = $user->sellingTransactions()->whereIn('status', ['processing', 'completed']);
        $buyingTransactions = $user->buyingTransactions()->whereIn('status', ['processing', 'completed']);
        $unreadCount = Message::whereHas('transaction', function ($q) use ($user) {
            $q->where('buyer_id', $user->id)
            ->orWhere('seller_id', $user->id);
        })
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->count();

        $myproducts = collect();//初期化
        $transactions = collect();

        //自動ソート
        if ($tabMypage === 'processing') {
            $transactions = Transaction::where(function ($q) use ($user) {
                $q->where('buyer_id', $user->id)
                ->orWhere('seller_id', $user->id);
        })
            ->whereIn('status', ['processing', 'completed'])
            ->with('product')
            ->withMax(['messages as last_received_at' => function ($q) use ($user) {
                $q->where('sender_id', '!=', $user->id);
        }], 'created_at')
        ->orderByRaw('last_received_at IS NULL ASC')
        ->orderByDesc('last_received_at')
        ->get();
        } elseif ($tabMypage === 'buy') {

            $myproducts = Product::where('user_id', $user->id)->get();
        } elseif ($tabMypage === 'sell') {

            $myproducts = $user->purchasedProducts;
        }

        $avgRating = $user->receivedReviews()->avg('rating');

        $rating = round($avgRating);

        return view('mypage', compact('user', 'myproducts', 'tabMypage', 'unreadCount', 'transactions', 'rating'));
    }
}
