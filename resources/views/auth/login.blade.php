@extends('layouts.marketplace')

@section('title', 'Вход')

@section('content')
<div style="max-width: 520px; margin: 0 auto;">
    <div class="card">
        <h1 style="font-size: 24px; margin-bottom: 8px;">Вход в аккаунт</h1>
        <p class="text-muted" style="margin-bottom: 16px;">Введите почту и пароль, чтобы продолжить.</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Эл. почта</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="password">Пароль</label>
                <input id="password" type="password" name="password" required autocomplete="current-password">
                @error('password')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group" style="display: flex; align-items: center; gap: 8px;">
                <input type="checkbox" name="remember" id="remember" value="1" {{ old('remember') ? 'checked' : '' }} style="width:auto;">
                <label for="remember" style="margin:0;">Запомнить меня</label>
            </div>

            <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                <button type="submit" class="btn btn-primary">Войти</button>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Забыли пароль?</a>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
