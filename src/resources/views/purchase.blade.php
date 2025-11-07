<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>furima</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
   <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
</head>

<body>
    <header class="header">
        <div class="header__inner">
                <a class="header__logo"href="/"> 
                    <img src="{{ asset('images/logo.svg')}}" alt="logo" >   
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
        <div class="product__content">
            <div class="product__image">
                    <img src="" width="400"
                    height="400"alt="商品画像">
                    <p class="product__name"></p>
                    <p>￥</p>

                    <div class="product__payment">
                        <section class="product__title">支払い方法</section>
                        <select name="" id="">
                            <option value=""></option>
                        </select>
                    </div>

                    <div class="product__address">
                        <section class="product__title">配達先</section>
                            <a href=""></a>
                            <div class="product__postal">
                                <p class="product__building"></p>
                            </div>
                    </div>
            </div>

            <div class="product__table">

            </div>

            <form action="#">
                <button class="form__submit" type="submit">購入する</button>
            </form>
        </div>
    </main>
</body>
</html>