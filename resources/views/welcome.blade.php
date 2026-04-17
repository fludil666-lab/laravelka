@extends('layouts.marketplace')

@section('title', 'Главная')

@section('content')
<section class="card" style="padding: 24px; background: linear-gradient(135deg, #fff8d8, #fff 60%);">
    <p class="text-muted" style="text-transform: uppercase; letter-spacing: .8px; margin-bottom: 6px;">Маркетплейс услуг</p>
    <h1 style="font-size: 34px; line-height: 1.15; margin-bottom: 10px;">Найдите специалиста для домашних задач за пару минут</h1>
    <p style="max-width: 720px; color: #4d5561; margin-bottom: 16px;">
        Сантехника, электрика, укладка плитки, мастер на час и базовый ремонт.
        Разместите заказ или выберите из готовых профилей.
    </p>
    <form action="{{ route('specialists.index') }}" method="get" style="display:flex; gap:10px; flex-wrap:wrap; max-width:700px;">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Например: электрик, плитка, устранить течь" style="flex:1; min-width:260px; border:1px solid #e3e6ea; border-radius:11px; padding:12px 14px;">
        <button type="submit" class="btn btn-primary">Найти специалистов</button>
    </form>
</section>

<section class="card">
    <h2 style="font-size: 20px; margin-bottom: 14px;">Популярные категории</h2>
    <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(170px,1fr)); gap:10px;">
        <a href="{{ route('specialists.index', ['q' => 'электрик']) }}" class="badge" style="justify-content:center; padding:10px; text-decoration:none;">Электрик</a>
        <a href="{{ route('specialists.index', ['q' => 'сантехник']) }}" class="badge" style="justify-content:center; padding:10px; text-decoration:none;">Сантехник</a>
        <a href="{{ route('specialists.index', ['q' => 'плитка']) }}" class="badge" style="justify-content:center; padding:10px; text-decoration:none;">Укладка плитки</a>
        <a href="{{ route('specialists.index', ['q' => 'ремонт']) }}" class="badge" style="justify-content:center; padding:10px; text-decoration:none;">Базовый ремонт</a>
        <a href="{{ route('specialists.index', ['q' => 'мастер']) }}" class="badge" style="justify-content:center; padding:10px; text-decoration:none;">Мастер на час</a>
        <a href="{{ route('specialists.index') }}" class="badge" style="justify-content:center; padding:10px; text-decoration:none;">Все специалисты</a>
    </div>
</section>

<section class="card">
    <h2 style="font-size: 20px; margin-bottom: 12px;">Как это работает</h2>
    <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:12px;">
        <div style="border:1px solid #e3e6ea; border-radius:12px; padding:12px;">
            <strong>1. Опишите задачу</strong>
            <p class="text-muted" style="margin-top: 5px;">Адрес, удобная дата и краткое описание.</p>
        </div>
        <div style="border:1px solid #e3e6ea; border-radius:12px; padding:12px;">
            <strong>2. Выберите исполнителя</strong>
            <p class="text-muted" style="margin-top: 5px;">Сравните профиль, услуги и бейджи проверки.</p>
        </div>
        <div style="border:1px solid #e3e6ea; border-radius:12px; padding:12px;">
            <strong>3. Отслеживайте статус заказа</strong>
            <p class="text-muted" style="margin-top: 5px;">Новый, в работе, выполнен.</p>
        </div>
    </div>
</section>
@endsection
