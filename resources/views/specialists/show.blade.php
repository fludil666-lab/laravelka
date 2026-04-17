@extends('layouts.marketplace')

@section('title', $specialist->user->name)

@section('content')
<div class="card">
    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
        <div style="flex-shrink: 0;">
            @if($specialist->user->avatar)
                <img src="{{ asset('storage/' . $specialist->user->avatar) }}" alt="" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover;">
            @else
                <div style="width: 120px; height: 120px; border-radius: 50%; background: #e5e5e5; display: flex; align-items: center; justify-content: center; font-size: 48px;">👤</div>
            @endif
        </div>
        <div style="flex: 1;">
            <h1 style="margin-bottom: 8px;">{{ $specialist->user->name }}</h1>
            <p class="text-muted" style="margin-bottom: 8px;">{{ $specialist->city }} · В сети {{ $specialist->last_online_at ? $specialist->last_online_at->diffForHumans() : 'давно' }}</p>
            @if($specialist->reviews()->count() > 0)
                <p style="margin-bottom: 12px;">★ {{ number_format($specialist->reviews()->avg('rating'), 1) }} ({{ $specialist->reviews()->count() }} оценок)</p>
            @endif
            @if($specialist->passport_verified)<span class="badge">Паспорт проверен</span>@endif
            @if($specialist->works_by_contract)<span class="badge">Работает по договору</span>@endif
            @if($specialist->with_guarantee)<span class="badge">С гарантией</span>@endif
            @if($specialist->description)
                <div style="margin-top: 16px; white-space: pre-wrap;">{{ $specialist->description }}</div>
            @endif
            <div style="margin-top: 16px; display: flex; gap: 8px; flex-wrap: wrap;">
                @if($specialist->user->phone)
                    <a href="tel:{{ $specialist->user->phone }}" class="btn btn-outline">Телефон</a>
                @endif
                <a href="#order" class="btn btn-primary">Предложить заказ</a>
            </div>
        </div>
    </div>
</div>

@if($specialist->services->count() > 0)
    <div class="card">
        <h2 style="font-size: 18px; margin-bottom: 12px;">Услуги и цены</h2>
        <ul style="list-style: none;">
            @foreach($specialist->services as $srv)
                <li style="padding: 8px 0; border-bottom: 1px solid #eee;">
                    {{ $srv->title }} — {{ $srv->price_type === 'by_agreement' ? 'по договорённости' : 'от ' . number_format($srv->price_from) . ' р' }}
                </li>
            @endforeach
        </ul>
    </div>
@endif

@auth
    @if(!Auth::user()->isSpecialist() || Auth::id() !== $specialist->user_id)
    <div class="card" id="order">
        <h2 style="font-size: 18px; margin-bottom: 12px;">Предложить заказ</h2>
        <form action="{{ route('orders.store') }}" method="post">
            @csrf
            <input type="hidden" name="specialist_profile_id" value="{{ $specialist->id }}">
            <div class="form-group">
                <label>Адрес</label>
                <input type="text" name="address" value="{{ old('address') }}" required placeholder="Город, улица, дом">
                @error('address')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div class="form-group">
                    <label>Дата</label>
                    <input type="date" name="scheduled_date" value="{{ old('scheduled_date') }}" required>
                    @error('scheduled_date')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Время</label>
                    <input type="time" name="scheduled_time" value="{{ old('scheduled_time') }}" required>
                    @error('scheduled_time')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="form-group">
                <label>Описание заказа</label>
                <textarea name="description" rows="3" placeholder="Что нужно сделать">{{ old('description') }}</textarea>
                @error('description')<div class="error">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary">Отправить заказ</button>
        </form>
    </div>
    @endif
@else
    <p class="text-muted"><a href="{{ route('login') }}">Войдите</a>, чтобы предложить заказ.</p>
@endauth
@endsection
