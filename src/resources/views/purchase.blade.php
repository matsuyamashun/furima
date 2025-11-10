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
            <div class="product">
                <div class="product__image">
                    <img src="{{ $product->image_url 
                    ? (Str::startsWith($product->image_url, 'http') 
                    ? $product->image_url 
                    : asset('storage/' . $product->image_url)) 
                    : '' }}" width="150"
                    height="150"alt="商品画像">
                    <div class="product__information">
                        <p class="product__name">{{ $product->name }}</p>
                        <p class="product__price">￥{{ $product->price }}</p>
                    </div>
                </div>

                <form action="{{ route('purchase.store',['id' => $product->id]) }}" method="POST">
                    @csrf
                    <div class="product__payment">
                        <section class="product__title">支払い方法</section>
                        <select class="form__select" name="payment_method">
                            <option value="">選択してください</option>
                            <option value="コンビニ支払い" {{ old('payment_method') == 'コンビニ支払い' ? 'selected' : ''}}>コンビニ支払い</option>
                            <option value="カード支払い" {{ old('payment_method') == 'カード支払い' ? 'selected' : ''}}>カード支払い</option>
                        </select>
                        @error('payment_method')
                            <div class="form__error">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="product__delivary">
                        <div class="product__change__delivary">
                        <section class="product__title">配達先</section>
                            <a href="{{ route('address.show',['product_id' => $product->id ])}}">変更する</a>
                        </div>
                        <div class="product__postal">
                            <p>〒{{ $address->postal_code}}</p>
                            <div class="product__address">
                                <p>{{ $address->address}}</p>
                                <p>{{ $address->building ?? ''}}</p>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="product__datail">
                <div class="product__table">
                    <table>
                        <tr>
                            <th>商品代金</th>
                            <td>￥{{ $product->price}}</td>
                        </tr>
                        <tr>
                            <th>支払い方法</th>
                            <td>{{ old('payment_method') }}</td>
                        </tr>
                    </table>
                </div>
                <button class="form__submit" type="submit">購入する</button>
            </div>
            </form>
        </div>
    </main>
</body>
</html>