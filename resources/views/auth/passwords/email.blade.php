@extends('layouts.marketplace')

@section('title', 'Сброс пароля')

@section('content')
<div style="max-width: 520px; margin: 0 auto;">
    <div class="card">
        <h1 style="font-size: 24px; margin-bottom: 8px;">Сброс пароля</h1>
        <p class="text-muted" style="margin-bottom: 16px;">Укажите эл. почту, и мы отправим ссылку для восстановления доступа.</p>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email">Эл. почта</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')<div class="error">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn btn-primary">Отправить ссылку</button>
        </form>
    </div>
</div>
@endsection
