@extends('layouts.marketplace')

@section('title', 'Подтверждение почты')

@section('content')
<div style="max-width: 620px; margin: 0 auto;">
    <div class="card">
        <h1 style="font-size: 24px; margin-bottom: 8px;">Подтверждение эл. почты</h1>

        @if (session('resent'))
            <div class="alert alert-success" style="margin: 10px 0 14px;">
                Новая ссылка для подтверждения отправлена на вашу почту.
            </div>
        @endif

        <p style="margin-bottom: 12px;">
            Перед продолжением проверьте почту и перейдите по ссылке из письма.
        </p>
        <p class="text-muted" style="margin-bottom: 12px;">
            Если письмо не пришло, отправьте ссылку повторно.
        </p>

        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Отправить повторно</button>
        </form>
    </div>
</div>
@endsection
