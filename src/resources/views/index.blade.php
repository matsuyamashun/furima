<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>furima</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
   <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>

<body>
    <header class="header">
        <div class="header__inner">
                <a class="header__logo"> 
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
    <main class="main">
        <div class="menu">
            <a href="{{ route('index')}}" class="menu__tab{{($tab ?? '') === 'recommend' ? 'active' : ''}}">
                おすすめ
            </a>
            <a href="{{ route('favorite.index')}}" class="menu__tab{{ ($tab ?? '') === 'mylist' ? 'active' : ''}}">
                <span>マイリスト</span>
            </a>
        </div>

        <div class="product__list">
            @forelse($products as $product)
                <div class="product__card">
                    <a href="{{ route('item',$product->id) }}">
                        <img src="{{ $product->image_url 
                        ? (Str::startsWith($product->image_url, 'http') 
                        ? $product->image_url 
                        : asset('storage/' . $product->image_url)) 
                        : '' }}"  width="250"
                        height="250">

                        @if($product->is_sold)
                            <div class="sold-overlay">SOLD</div>
                        @endif
                        <p>{{ $product->name }}</p>
                    </a>
                </div>
            @empty
                <p>商品がありません</p>
            @endforelse
        </div>
    </main>
</body>