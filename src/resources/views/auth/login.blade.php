@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}" />
@endsection 

@section('content')
<div class="content">
    <h2 class="content__title">ログイン</h2>
</div>

<form class="content__form" action="{{ route('login')}}" method="POST" novalidate>
    @csrf
    <!-- メールアドレス -->
    <div class="form__group">
        <label>メールアドレス</label>
            <input class="form__mail__input" type="email" name="email">
    </div>
    @error('email')
        <div class="form__error">{{$message}}</div>
    @enderror
    <!-- パスワード -->
    <div class="form__group">
        <label>パスワード</label>
            <input class="form__password-input" type="password" name="password">
    </div>
    @error('password')
        <div class="form__error">{{$message}}</div>
    @enderror
    <div class="form__group">
        <button class="form__button" type="submit">ログインする</button>
        <p class="form__link">
            <a href="/register">会員登録はこちら</a>
        </p>
    </div>  
   @if($errors->has('email') && $errors->first('email') === 'ログイン情報が登録されていません')
        <div class="form__error">{{ $errors->first('email') }}</div>
    @endif

</form>
@endsection