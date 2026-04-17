@extends('layouts.marketplace')

@section('title', 'Заказы')

@section('content')
<h1 style="margin-bottom: 20px; font-size: 22px;">Заказы</h1>
<p><a href="{{ route('admin.dashboard') }}">Назад в админку</a></p>

@foreach($orders as $order)
    <div class="card">
        <strong>#{{ $order->id }}</strong> <span class="badge">{{ $order->status_label }}</span><br>
        Заказчик: {{ $order->customer->name }} ({{ $order->customer->email }})<br>
        Исполнитель: {{ $order->specialistProfile->user->name }}<br>
        Адрес: {{ $order->address }} · {{ $order->scheduled_date->format('d.m.Y') }} {{ $order->scheduled_time }}

        <form action="{{ route('admin.orders.status.update', $order) }}" method="post" style="margin-top: 12px; display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            @csrf
            @method('PATCH')
            <label for="status-{{ $order->id }}">Статус</label>
            <select id="status-{{ $order->id }}" name="status" style="padding: 8px 10px; border: 1px solid #d9d9d9; border-radius: 6px;">
                @foreach($statusLabels as $statusValue => $statusLabel)
                    <option value="{{ $statusValue }}" {{ $order->status === $statusValue ? 'selected' : '' }}>{{ $statusLabel }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Обновить</button>
        </form>

        <form action="{{ route('admin.orders.destroy', $order) }}" method="post" style="margin-top: 10px;" onsubmit="return confirm('Удалить заказ #{{ $order->id }}?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline">Удалить заказ</button>
        </form>
    </div>
@endforeach

{{ $orders->links() }}
@endsection
