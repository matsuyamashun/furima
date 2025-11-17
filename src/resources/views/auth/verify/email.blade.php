@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/email.css') }}" />
@endsection 

@section('content')
    <div class="container">
        <div class="content">
            <p>登録していただいたメールアドレスに認証メールを送付しました。</p>
            <p>メール認証を完了させてください。</p>
            <form  method="GET">
                <button class="form__button" type="submit">認証はこちらから</button>
            </form>
            <form action="{{ route('verification.send')}}" method="POST">
                @csrf
                <button class="form__resend" type="submit">認証メールを再送する</button>
            </form>
        </div>
    </div>
@endsection