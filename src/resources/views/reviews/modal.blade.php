<div id="review-modal" class="modal">
    <div class="modal__overlay"></div>

    <div class="modal__content">
        <div class="modal__title">
            <h1>取引が完了しました。</h1>
        </div>

        <p>今回の取引相手はどうでしたか？</p>

        <form action="" method="POST">
            @csrf

            <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">

            <div class="stars">

                @for($i = 5; $i >= 1; $i--)
                    <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}">
                    <label for="star{{ $i }}">★</label>
                @endfor
            </div>

            <button type="submit">送信する</button>
        </form>
    </div>
</div>