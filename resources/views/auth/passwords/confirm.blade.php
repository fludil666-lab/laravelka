@extends('layouts.marketplace')

@section('title', 'Подтверждение пароля')

@section('content')
<div style="max-width: 520px; margin: 0 auto;">
    <div class="card">
        <h1 style="font-size: 24px; margin-bottom: 8px;">Подтверждение пароля</h1>
        <p class="text-muted" style="margin-bottom: 16px;">Для безопасности повторно введите пароль.</p>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="form-group">
                <label for="password">Пароль</label>
                <input id="password" type="password" name="password" required autocomplete="current-password">
                @error('password')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
                <button type="submit" class="btn btn-primary">Подтвердить</button>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Забыли пароль?</a>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
