<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>furima</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
   <link rel="stylesheet" href="{{ asset('css/item.css') }}">
</head>

<body>
    <header class="header">
        <div class="header__inner">
                <a class="header__logo" href="/"> 
                    <img src="{{ asset('images/logo.svg')}}" alt="logo">   
                </a>

                <form action= method="GET" class="header__search__form">
                    <input type="text" name="seach" placeholder="　　なにをお探しですか？" class="header__search-input">
                </form>

            <div class="header__nav">
            @auth
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="header__link__button__logout">ログアウト</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="header__link">ログイン</a>

            @endauth
                <a href="{{ route('mypage') }}" class="header__link">マイページ</a>
                <a href="{{ route('sell') }}" class="header__link__sell">出品</a>
            </div>
        </div>
    </header>

    <main>
        <div class="puroduct__content">
            <div class="product__image">
                <img src="{{ $product->image_url 
                    ? (Str::startsWith($product->image_url, 'http') 
                    ? $product->image_url 
                    : asset('storage/' . $product->image_url)) 
                    : '' }}"  width="400"
                    height="400"alt="商品画像" >
            </div>

            <div class="product__detail">
                <h1 class="product__title">{{$product->name}}</h1>
                <p class="product__brand">{{$product->brand ?? 'ブランドなし'}}</p>
                <p class="product__price">￥{{$product->price}}(税込)</p>
                
                @auth
                <div class="favorite">
                    <div class="fvorite__area">
                        @if(auth()->user()->favoriteProducts()->where('product_id', $product->id)->exists())

                        <form action="{{ route('favorite.destroy', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="favorite__button">⭐ </button>
                        </form>
                @else

                        <form action="{{ route('favorite.store', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="favorite__button">☆</button>
                        </form>
                @endif
                        <p class="favorite__count">
                            {{ $product->favorites()->count() }}</p>
                    </div>
 
                    <div class="comment__area">
                        💬
                        <p class="comment__icon">{{ $product->comments->count() }}</p>
                    </div>
                </div>

                <a class="product__button" href="{{ route('purchase')}}">購入手続きへ</a>
                @endauth
                
                <section class="product__description">
                    <h2 class="product__title">商品説明</h2>
                    <p>{{$product->description}}</p>
                </section>

                <section class="product__infomation">
                    <h2 class="product__title">商品の情報</h2>

                    <div class="information__row">
                        <span class="information__label">カテゴリー</span>
                        <span class="information__category">
                            @foreach($product->categories as $category) 
                               {{$category->name}}@if (!$loop->last),@endif
                            @endforeach
                        </span>
                    </div>
                    
                    <div class="information__row">
                        <span class="information__label">商品の状態</span>
                        <span
                        class="information__condition">
                            {{$product->condition_label}}
                        </span>
                    </div>
                </section>
            
                <div class="product__comment">
                    <section class="product__comment">
                        コメント（{{ $product->comments->count() }}）
                    </section>

                    @foreach($product->comments as $comment)
                        <div class="comment__item">
                            <img 
                            src="{{ $comment->user->profile && $comment->user->profile->avatar 
                            ? asset('storage/' . $comment->user->profile->avatar) 
                            : asset('images/default.png') }}" 
                            alt="ユーザー画像" 
                            class="comment__avatar">

                            <p class="comment__user">{{ $comment->user->name}}</p>
                        </div>
                            <p class="comment__text">{{ $comment->content}}
                            </p>
                    @endforeach

                    @auth
                        <form class="comment__form" action="{{ route('comment.store',['id' =>$product->id]) }}" method="POST">
                            @csrf
                            <label class="form__label">商品へのコメント</label>
                            <textarea name="content" ></textarea>
                            @error('content')
                                <p class="form__error">{{$message}}</p>
                            @enderror

                            <button class="product__button" type="submit">コメントを送信する</button>
                        </form>       
                    @endauth  
                </div>         
            </div>
    </main>
</body>
</html>