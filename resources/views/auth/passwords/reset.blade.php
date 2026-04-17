@extends('layouts.marketplace')

@section('title', 'Новый пароль')

@section('content')
<div style="max-width: 520px; margin: 0 auto;">
    <div class="card">
        <h1 style="font-size: 24px; margin-bottom: 8px;">Установить новый пароль</h1>
        <p class="text-muted" style="margin-bottom: 16px;">Заполните поля ниже, чтобы завершить восстановление аккаунта.</p>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="email">Эл. почта</label>
                <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                @error('email')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="password">Пароль</label>
                <input id="password" type="password" name="password" required autocomplete="new-password">
                @error('password')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="password-confirm">Подтверждение пароля</label>
                <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn-primary">Сохранить пароль</button>
        </form>
    </div>
</div>
@endsection
