<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>furima</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
   <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>

<body>
    <header class="header">
        <div class="header__inner">
                <a class="header__logo"href="/"> 
                    <img src="{{ asset('images/logo.svg')}}" alt="logo" >   
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
    <main>
        <div class="content">
            <h2 class="content__title">プロフィール設定</h2>
        </div>

        <form class="content__form" action="{{ route('profile.update')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="profile-avatar">
                <img 
                 src="{{ $profile && $profile->avatar ? asset('storage/'.$profile->avatar) : 'https://via.placeholder.com/150' }}"
                alt="画像" class="profile-img">
                    <label class="btn-upload">
                        画像を選択する
                    <input type="file" name="avatar" hidden>
                    </label>
                    @error('avatar')
                        <div class="form__error">{{$message}}</div>
                    @enderror
            </div>

            <div class="form__group">
                <label>ユーザー名</label>
                <input class="form__name__input"  type="text"name="username" value="{{old('username',$profile->username ?? '')}}">
            @error('username')
                <div class="form__error">{{$message}}</div>
            @enderror
            </div>

            <div class="form__group">
                <label>郵便番号</label>
                <input class="form__postal__input"  type="text"name="postal_code" value="{{old('postal_code',$profile->postal_code ?? '')}}">
                @error('postal_code')
                    <div class="form__error">{{$message}}</div>
                @enderror
            </div>

            <div class="form__group">
                <label>住所</label>
                <input class="form__address__input"  type="text"name="address" value="{{old('address',$profile->address ?? '')}}">
                @error('address')
                    <div class="form__error">{{$message}}</div>
                @enderror
            </div>

            <div class="form__group">
                <label>建物名</label>
                <input class="form__building__input"  type="text"name="building" value="{{old('building',$profile->building ?? '')}}">
            </div>

            <div class="form__group">
                <button class="form__button">更新する</button>
            </div>
        </form>
    </main>
</body>