@extends('layouts.marketplace')

@section('title', 'Мои заказы')

@section('content')
<h1 style="margin-bottom: 20px; font-size: 22px;">Мои заказы</h1>

@forelse($orders as $order)
    @php($isCustomerOrder = auth()->id() === (int) $order->customer_id)
    <div class="card">
        <div style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
            <div>
                <strong>Заказ #{{ $order->id }}</strong>
                <span class="badge" style="margin-left: 8px;">{{ $order->status_label }}</span>
                <p class="text-muted" style="margin-top: 6px;">{{ $order->address }}</p>
                <p class="text-muted" style="font-size: 13px;">{{ $order->scheduled_date->format('d.m.Y') }} {{ $order->scheduled_time }}</p>
                <p>
                    Заказчик: {{ $order->customer->name }} ({{ $order->customer->email }})<br>
                    Исполнитель:
                    @if($order->specialistProfile && $order->specialistProfile->user)
                        <a href="{{ route('specialists.show', $order->specialistProfile) }}">{{ $order->specialistProfile->user->name }}</a>
                    @else
                        не указан
                    @endif
                </p>
            </div>
            <div style="display: flex; gap: 8px; align-items: flex-start; flex-wrap: wrap;">
                @if($isCustomerOrder && !in_array($order->status, ['completed', 'cancelled'], true))
                    <form action="{{ route('orders.cancel', $order) }}" method="post" onsubmit="return confirm('Отменить этот заказ?');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline">Отменить заказ</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@empty
    <p class="text-muted">Заказов пока нет. <a href="{{ route('specialists.index') }}">Найти специалиста</a>.</p>
@endforelse

{{ $orders->links() }}
@endsection
