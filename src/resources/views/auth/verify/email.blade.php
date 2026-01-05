@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/email.css') }}" />
@endsection

@section('content')
    <div class="container">
        <div class="content">
            <p>登録していただいたメールアドレスに認証メールを送付しました。</p>
            <p>メール認証を完了させてください。</p>
                <a href="http://localhost:8025" class="form__button">
                認証はこちらから
                </a>
                <form action="{{ route('verification.send')}}" method="POST">
                    @csrf
                    <button class="form__resend" type="submit">認証メールを再送する</button>
            </form>
        </div>
    </div>
@endsection