<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>mypage</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
   <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
</head>

<body>
    <header class="header">
        <div class="header__inner">
                <a class="header__logo" href="/"> 
                    <img src="{{ asset('images/logo.svg')}}" alt="logo">   
                </a>

                <form action="{{ route('index')}}" method="GET" class="header__search__form">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="　　なにをお探しですか？" class="header__search-input">
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

        <div class="profile__wrapper">
            <div class="profile">
                <div class="profile__image">
                    <img src="{{ $user->profile && $user->profile->avatar ? asset('storage/' . $user->profile->avatar) : asset('images/default.png') }}" alt="画像なし">
                </div>

                <div class="profile__info">
                    <h2 class="profile__name">{{$user->name}}</h2>
                    <a class="profile__edit" href="{{ route('profile.edit') }}">プロフィールを編集</a>
                </div>
            </div>
        </div>
        
        <div class="menu">
            <a href="{{ route('mypage',['tab' => 'buy'])}}" class="menu__tab{{ $tabMypage === 'buy' ? 'active' : ''}}">
                <span>出品した商品</span>
            </a>
            <a href="{{ route('mypage',[ 'tab' => 'sell' ])}}" class="menu__tab{{ $tabMypage === 'sell' ? 'active' : ''}}">
                購入した商品
            </a>
        </div>

        <div class="product__list">
            @forelse($myproducts as $product)
                <div class="product__card">
                    <a href="{{ route('item',['id' =>$product->id]) }}">
                        <img src="{{ $product->image_url 
                        ? (Str::startsWith($product->image_url, 'http') 
                        ? $product->image_url 
                        : asset('storage/' . $product->image_url)) 
                        : '' }}"  alt="商品画像" width="250" 
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
