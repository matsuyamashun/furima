<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>furima</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
   <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
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
                <a href="{{ route('mypage') }}"class="header__link">マイページ</a>
                <a href="{{ route('sell') }}" class="header__link__sell">出品</a>
            </div>
        </div>
    </header>
    <main>
        <div class="content">
            <h2 class="content__title">商品の出品</h2>
        </div>
        <form class="content__form" action="{{ route('sell.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form__group">
                <label for="image" class="form__label">商品画像</label>
                <div class="form__image">
                    <input class="form__image__input" type="file" id="image" name="image" value="{{ old('image') }}">
                    <label class="form__image__button" for="image">画像を選択する</label>
                </div>
                @error('image')
                <div class="form__error">  {{$message}}</div>
                @enderror
            </div>

            <div class="form__group">
                <p class="form__title">商品の詳細</p>

                <div class="category__box">
                    <label class="category__label">カテゴリー</label>
                    <div class="category__tag">
                        <input type="radio" id="fashion" name="category" value="ファッション">
                        <label class="tag" for="fashion">ファッション</label>
                        <input type="radio" id="homeappliances" name="category"
                        value="家電" value="{{ old('category')}}">
                        <label class="tag" for="homeappliances">家電</label>
                        <input type="radio" id="interior" name="category" value="インテリア">
                        <label class="tag" for="interior">インテリア</label>
                        <input type="radio" id="ladies" name="category" value="レディース">
                        <label class="tag" for="ladies">レディース</label>
                        <input type="radio" id="mens" name="category" value="メンズ">
                        <label class="tag" for="mens">メンズ</label>
                        <input type="radio" id="kosume" name="category" value="コスメ">
                        <label class="tag" for="kosume">コスメ</label>
                        <input type="radio" id="book" name="category" value="本">
                        <label class="tag" for="book">本</label>
                        <input type="radio" id="game" name="category" value="ゲーム">
                        <label class="tag" for="game">ゲーム</label>
                        <input type="radio" id="sport" name="category" value="スポーツ">
                        <label class="tag" for="sport">スポーツ</label>
                        <input type="radio" id="kittchin" name="category" value="キッチン">
                        <label class="tag" for="kittchin">キッチン</label>
                        <input type="radio" id="handmeid" name="category" value="ハンドメイド">
                        <label class="tag" for="handmeid">ハンドメイド</label>
                        <input type="radio" id="accessories" name="category" value="アクセサリー">
                        <label class="tag" for="accessories">アクセサリー</label>
                        <input type="radio" id="toy" name="category" value="おもちゃ">
                        <label class="tag" for="toy">おもちゃ</label>
                        <input type="radio" id="babyguzz" name="category" value="ベビーグッズ">
                        <label class="tag" for="babyguzz">ベビーグッズ</label>
                        @error('category')
                        <div class="form__error">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="form__group">
                    <label class="category__label" for="condition">商品の状態</label>
                    <select name="condition" id="condition">
                        <option value="" disabled selected>選択してください</option>
                        <option value="new">良好</option>
                        <option value="like_new">目立った傷や汚れなし</option>
                        <option value="fair">やや傷や汚れあり</option>
                        <option value="poor">状態が悪い</option>
                    </select>
                </div>
                @error('conditon')
                <div class="form__error">{{$message}}</div>
                @enderror
            </div>

            <div class="form__group">
                <p class="form__title">商品名と説明</p>
                <label class="form__label" for="name">商品名</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}">
                @error('name')
                <div class="form__error">{{$message}}</div>
                @enderror
            </div>

            <div class="form__group">
                <label class="form__label" for="brand">ブランド名</label>
                <input type="text" id="brand" name="brand" value="{{ old('brand') }}">
            </div>

            <div class="form__group">
                <label class="form__label" for="description">商品の説明</label>
                <textarea id="description" name="description" value="{{ old('description') }}"></textarea>
                @error('description')
                <div class="form__error">{{$message}}</div>
                @enderror
            </div>

            <div class="form__group">
                <label class="form__label" for="price">販売価格</label>
                <input type="text" id="price" name="price"placeholder="￥" value="{{old('price')}}">
                @error('price')
                <div class="form__error">{{$message}}</div>
                @enderror
            </div>

            <button class="button__submit" type="submit">出品する</button>
        </form>
    </main>
</body>