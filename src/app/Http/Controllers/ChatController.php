<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\Message;
use App\Http\Requests\ChatRequest;
use App\Mail\TransactionCompletedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ChatController extends Controller
{
    public function show(Transaction $transaction)
    {
        $transaction ->load('reviews');

        $messages = $transaction->messages()
            ->with('sender.profile')
            ->orderBy('created_at')
            ->get();

        $transaction->messages()
            ->where('sender_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $partner = Auth::id() === $transaction->seller_id ? $transaction->buyer : $transaction->seller;

        $otherTransactions = Transaction::where(function ($q) {
            $q->where('buyer_id', auth()->id())
                ->orWhere('seller_id', auth()->id());
            })
            ->where('id', '!=', $transaction->id) // 今見てる取引は除外
            ->where('status', '!=', 'finished')//取引終了でも除外
            ->with('product')
            ->get();

        $product = $transaction->product;

        return view('chat', compact('messages', 'transaction', 'partner', 'product', 'otherTransactions'));
    }

    public function store(ChatRequest $request, Transaction $transaction)
    {
        if (
            Auth::id() !== $transaction->buyer_id &&
            Auth::id() !== $transaction->seller_id
        ) {
            abort(403);
        }

        $path = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('chat_images', 'public');
        }

        $transaction->messages()->create([
            'sender_id' => Auth::id(),
            'chat' => $request->chat,
            'image' => $path,
            'is_read' => false,
        ]);

        return redirect()->route('chat', $transaction->id);
    }

    public function update(Request $request, $id)
    {
        $message = Message::findOrFail($id);

        $message->update([
            'chat' => $request->chat,
        ]);

        return back();
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);

        $message->delete();

        return back();
    }

    public function complete(Transaction $transaction)
    {
        if (Auth::id() !== $transaction->buyer_id) {
            abort(403);
        }

        $transaction->update([
            'status' => 'completed',
        ]);

        Mail::to($transaction->seller->email)
            ->send(new TransactionCompletedMail($transaction));

        return redirect()->route('chat', $transaction->id)->with('openReviewModal', true);
    }
}