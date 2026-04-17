@extends('layouts.marketplace')

@section('title', 'Регистрация')

@section('content')
<div style="max-width: 680px; margin: 0 auto;">
    <div class="card">
        <h1 style="font-size: 24px; margin-bottom: 8px;">Регистрация</h1>
        <p class="text-muted" style="margin-bottom: 16px;">Создайте аккаунт заказчика или исполнителя.</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Имя</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="email">Эл. почта</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="role">Тип аккаунта</label>
                <select id="role" name="role" required>
                    <option value="customer" {{ (old('role', request('role')) === 'customer') ? 'selected' : '' }}>Заказчик (ищу специалистов)</option>
                    <option value="specialist" {{ (old('role', request('role')) === 'specialist') ? 'selected' : '' }}>Исполнитель (оказываю услуги)</option>
                </select>
                @error('role')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div id="specialist-fields" style="{{ (old('role', request('role')) !== 'specialist') ? 'display:none' : '' }}">
                <div class="form-group">
                    <label for="city">Город</label>
                    <input id="city" type="text" name="city" value="{{ old('city') }}" placeholder="Например: Москва">
                </div>
                <div class="form-group">
                    <label for="description">О себе</label>
                    <textarea id="description" name="description" rows="3" placeholder="Кратко опишите услуги">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="phone">Телефон</label>
                <input id="phone" type="text" name="phone" value="{{ old('phone') }}" placeholder="+7 ...">
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

            <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('role').addEventListener('change', function () {
    document.getElementById('specialist-fields').style.display = this.value === 'specialist' ? 'block' : 'none';
});
</script>
@endpush
