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
                        : '' }}"  width="250"
                        height="250"alt="商品画像" width="300px" height="300px">
            </div>

            <div class="product__detail">
                <h1 class="product__title">{{$product->name}}</h1>
                <p class="product__brand">{{$product->brand}}</p>
                <p class="product__price">￥{{$product->price}}(税込)</p>

                @auth
                    <div class="favorite__area">
                        @if(auth()->user()->favoriteProducts()->where('product_id', $product->id)->exists())

                        <form action="{{ route('favorite.destroy', $product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                            <button type="submit" class="favorite__button">❤️ お気に入り解除</button>
                        </form>
                        @else
                    
                        <form action="{{ route('favorite.store', $product->id) }}" method="POST">
                        @csrf
                            <button type="submit" class="favorite__button">🤍 お気に入り</button>
                        </form>
                        @endif
                    </div>
                @endauth

                <button class="product__button">購入手続きへ</button>
            </div>

            <div class="product__description">
                <section class="product__title">商品説明</section>
                <p class="product__description__comment">{{$product->description}}</p>
            </div>

            <div class="product__infomation">
                <section class="product__title">商品の情報</section>
                    <h4 class="product__category">カテゴリー</h4>
                    <p class="product__category__type">
                       @foreach($product->categories as $category) 
                           {{$category->name}}@if (!$loop->last),@endif
                        @endforeach
                    </p>
                    
                    <h4 class="product__condition">商品の状態</h2>
                    <p class="product__condition__type">
                        {{$product->condition_label}}
                    </p>
            </div>
            
            <div class="product__comment">
                <section class="product__comment__title">コメント</section>
                    
            </div>
    
        </div>
    </main>