@extends('layouts.marketplace')

@section('title', 'Админ-панель')

@section('content')
<h1 style="margin-bottom: 20px; font-size: 22px;">Админ-панель</h1>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <div class="card">
        <div class="text-muted">Пользователей</div>
        <strong style="font-size: 24px;">{{ $stats['users'] }}</strong>
        <a href="{{ route('admin.users.index') }}" style="font-size: 13px;">Список</a>
    </div>
    <div class="card">
        <div class="text-muted">Исполнителей</div>
        <strong style="font-size: 24px;">{{ $stats['specialists'] }}</strong>
    </div>
    <div class="card">
        <div class="text-muted">Заказов</div>
        <strong style="font-size: 24px;">{{ $stats['orders'] }}</strong>
        <a href="{{ route('admin.orders.index') }}" style="font-size: 13px;">Список</a>
    </div>
</div>

<h2 style="font-size: 18px; margin-bottom: 12px;">Последние заказы</h2>
@foreach($recentOrders as $order)
    <div class="card">
        #{{ $order->id }} — {{ $order->customer->name }} → {{ $order->specialistProfile->user->name }} · {{ $order->address }} · {{ $order->status_label }}
    </div>
@endforeach
@endsection
