@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}" />
@endsection

@section('content')
<div class="content">
    <h2 class="content__title">会員登録</h2>
</div>

<form class="content__form" action="{{ route('register')}}" method="POST" novalidate>
    @csrf

    <div class="form__group">
        <label>ユーザー名</label>
            <input class="form_name-input" type="text" name="name" value="{{ old('name')}}">
    </div>
    @error('name')
        <div class="form__error">{{$message}}</div>
    @enderror

    <div class="form__group">
        <label>メールアドレス</label>
            <input class="form__mail__input" type="email" name="email" value="{{ old('email')}}">
    </div>
    @error('email')
        <div class="form__error">{{$message}}</div>
    @enderror

    <div class="form__group">
        <label>パスワード</label>
            <input class="form__password-input" type="password" name="password">
    </div>
    @error('password')
        <div class="form__error">{{$message}}</div>
    @enderror

    <div class="form__group">
        <label>確認用パスワード</label>
            <input class="form__password__confirmation-input" type="password" name="password_confirmation" >
    </div>

    <div class="form__group">
        <button class="form__button" type="submit">登録する</button>
        <p class="form__link">
            <a href="/login">ログインはこちら</a>
        </p>
    </div>
</form>
@endsection