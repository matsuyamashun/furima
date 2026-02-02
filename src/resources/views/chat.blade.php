@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/chat.css') }}">
<link rel="stylesheet" href="{{ asset('css/modal.css') }}">
@endsection

@section('content')
<div class="content">

    <aside class="sidebar">
        <div class="sidebar__title">
            その他の取引
            @foreach($otherTransactions as $otherTransaction)
                <a href="{{ route('chat', $otherTransaction->id) }}"><p>{{ $otherTransaction->product->name }}</p></a>
            @endforeach

        </div>
    </aside>

    <main class="main__content">
        <div class="processing__name">
            <div class="profile__information">
                <img src="{{ $partner->profile?->avatar
                    ? asset('storage/'.$partner->profile->avatar)
                    : asset('images/default.png') }}"
                    width="50" class="profile-img">
                <p>{{ $partner->name }}さんとの取引画面</p>
            </div>

            @if(Auth::id() === $transaction->buyer_id && $transaction->status === 'processing')
            <form action="{{ route('transaction.complete', $transaction->id) }}" method="POST">
            @csrf
                <button class="processing__button">
                    取引を完了する
                </button>
            </form>
            @endif
        </div>

        <div class="item__image">
            <img src="{{ $transaction->product->image_url
                ? (Str::startsWith($transaction->product->image_url, 'http')
                    ? $transaction->product->image_url
                    : asset('storage/'.$transaction->product->image_url))
                : '' }}"
                width="180" height="180">

            <div class="item__description">
                <h1>{{ $transaction->product->name }}</h1>
                <h3>商品価格 ￥{{ $transaction->product->price }}</h3>
            </div>
        </div>

        <div class="processing__chat">
            @foreach($messages as $message)

                {{-- 購入者：左 --}}
                @if($message->sender_id === $transaction->buyer_id)
                    <div class="chat__left">
                        <div class="avatar__left">
                            <img src="{{ $transaction->buyer->profile?->avatar
                                ? asset('storage/'.$transaction->buyer->profile->avatar)
                                : asset('images/default.png') }}"
                                width="40">
                            <p>{{ $transaction->buyer->name }}</p>
                        </div>

                        <p class="chat__message js-display">{{ $message->chat }}</p>

                        @if(Auth::id() === $message->sender_id)
                            <div class="chat__action">
                                <form action="{{ route('chat.update', $message->id) }}" method="POST" class="js-edit-form hidden">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="chat" value="{{ $message->chat }}">
                                </form>

                                <button type="submit" class="js-edit-btn">編集</button>

                                <form action="{{ route('chat.destroy', $message->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">削除</button>
                                </form>
                            </div>
                        @endif

                        @if($message->image)
                            <img src="{{ asset('storage/' .$message->image )}}" width="150px" height="200px">
                        @endif
                    </div>

                {{-- 出品者：右 --}}
                @else
                    <div class="chat__right">
                        <div class="avatar__right">
                            <img src="{{ $transaction->seller->profile?->avatar
                                ? asset('storage/'.$transaction->seller->profile->avatar)
                                : asset('images/default.png') }}"
                                width="40">
                            <p>{{ $transaction->seller->name }}</p>
                        </div>

                        <p class="chat__message js-display">{{ $message->chat }}</p>

                        @if($message->image)
                            <img src="{{ asset('storage/' .$message->image)}}" width="150px" height="200px">
                        @endif

                        @if(Auth::id() === $message->sender_id)
                            <div class="chat__action">
                                <form action="{{ route('chat.update', $message->id) }}" method="POST" class="js-edit-form hidden">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="chat" value="{{ $message->chat }}">
                                </form>

                                <button type="submit" class="js-edit-btn">編集</button>

                                <form action="{{ route('chat.destroy', $message->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">削除</button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>

        <div class="chat__send">
            <form action="{{ route('chat', $transaction->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="text" name="chat" id="chat-input" placeholder="取引メッセージを記入してください" value="{{ old('chat') }}">

                <input type="file" name="image" id="chat-image" class="hidden">

                <label for="chat-image" class="chat__button">画像を追加</label>

                <button type="submit" class="send__button">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="gray" stroke-width="2">
                        <path d="M22 2L11 13"/>
                        <path d="M22 2L15 22L11 13L2 9L22 2Z"/>
                    </svg>
                </button>

                @error('chat')
                    <div class="form__error">{{ $message }}</div>
                @enderror

                @error('image')
                    <div class="form__error">{{ $message }}</div>
                @enderror
            </form>
        </div>
        @if( $transaction->status === 'completed' && ! $transaction->reviews->where('reviewer_id', Auth::id())->count()
        )
            @include('reviews.modal')
    <script>
        window.addEventListener('load', () => {
            document.getElementById('review-modal')?.classList.add('is-active');
        });
    </script>
        @endif
    </main>
</div>

<script>
document.querySelectorAll('.js-edit-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const action = btn.closest('.chat__action');
        const display = action.previousElementSibling; // p
        const form = action.querySelector('.js-edit-form');
        const input = form.querySelector('input');

        display.style.display = 'none';
        form.style.display = 'block';
        btn.style.display = 'none';

        input.focus();

        input.addEventListener('keydown', e => {
            if (e.key === 'Enter') {
                e.preventDefault();
                form.submit();
            }
        });
    });
});

</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('chat-input');
    if (!input) return;

    // 保存されてたら復元
    const saved = localStorage.getItem('chat_draft_{{ $transaction->id }}');
    if (saved) {
        input.value = saved;
    }

    // 入力されるたびに保存
    input.addEventListener('input', () => {
        localStorage.setItem(
            'chat_draft_{{ $transaction->id }}',
            input.value
        );
    });

    // 送信したら削除
    input.closest('form').addEventListener('submit', () => {
        localStorage.removeItem('chat_draft_{{ $transaction->id }}');
    });
});
</script>
@endsection