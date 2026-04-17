@extends('layouts.marketplace')

@section('title', 'Специалисты')

@section('content')
<div class="card" style="display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap;">
    <div>
        <h1 style="font-size: 24px; margin-bottom: 4px;">Каталог специалистов</h1>
        <p class="text-muted">
            @if(request('q'))
                Поисковый запрос: "{{ request('q') }}"
            @else
                Выберите исполнителя и создайте заказ в один клик.
            @endif
        </p>
    </div>
    <a href="{{ route('specialists.index') }}" class="btn btn-outline">Сбросить фильтры</a>
</div>

@forelse($specialists as $sp)
    <article class="card">
        <div style="display:grid; grid-template-columns:86px minmax(0,1fr) auto; gap:14px; align-items:start;">
            <div>
                @if($sp->user->avatar)
                    <img src="{{ asset('storage/' . $sp->user->avatar) }}" alt="" style="width:86px; height:86px; border-radius:50%; object-fit:cover;">
                @else
                    <div style="width:86px; height:86px; border-radius:50%; background:#eef1f5; display:flex; align-items:center; justify-content:center; font-size:26px; color:#8a93a0;">👤</div>
                @endif
            </div>

            <div style="min-width:0;">
                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap; margin-bottom:6px;">
                    <strong style="font-size:18px;">{{ $sp->user->name }}</strong>
                    @if($sp->passport_verified)<span class="badge">Паспорт проверен</span>@endif
                    @if($sp->with_guarantee)<span class="badge">Гарантия</span>@endif
                </div>
                <p class="text-muted" style="margin-bottom:8px;">{{ $sp->city }} · в сети {{ $sp->last_online_at ? $sp->last_online_at->diffForHumans() : 'недавно' }}</p>

                @if(($sp->description ?? '') !== '')
                    <p style="margin-bottom:8px;">{{ Str::limit($sp->description, 210) }}</p>
                @endif

                @if($sp->services->count())
                    <div style="display:flex; gap:8px; flex-wrap:wrap;">
                        @foreach($sp->services->take(3) as $srv)
                            <span style="display:inline-flex; align-items:center; padding:5px 10px; border-radius:999px; border:1px solid #e3e6ea; background:#f8fafc; font-size:13px;">
                                {{ $srv->title }}
                                @if($srv->price_type !== 'by_agreement' && $srv->price_from)
                                    · от {{ number_format($srv->price_from) }}
                                @endif
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>

            <div style="display:flex; flex-direction:column; gap:8px;">
                <a href="{{ route('specialists.show', $sp) }}" class="btn btn-outline">Профиль</a>
                <a href="{{ route('specialists.show', $sp) }}#order" class="btn btn-primary">Создать заказ</a>
            </div>
        </div>
    </article>
@empty
    <div class="card">
        <p style="margin-bottom: 8px;">Специалисты не найдены.</p>
        <p class="text-muted">Попробуйте другую категорию или город.</p>
    </div>
@endforelse

{{ $specialists->withQueryString()->links() }}
@endsection

@section('sidebar')
<div class="card">
    <h3 style="font-size: 17px; margin-bottom: 12px;">Фильтры</h3>
    <form action="{{ route('specialists.index') }}" method="get">
        @if(request('q'))<input type="hidden" name="q" value="{{ request('q') }}">@endif

        <div class="form-group">
            <label>Категория</label>
            <select name="category_id">
                <option value="">Любая</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ (string) request('category_id') === (string) $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Город</label>
            <input type="text" name="city" value="{{ request('city') }}" placeholder="Например: Москва">
        </div>

        <div class="form-group">
            <label style="display:flex; gap:8px; align-items:center;">
                <input type="checkbox" name="with_guarantee" value="1" {{ request('with_guarantee') ? 'checked' : '' }}>
                Только с гарантией
            </label>
        </div>

        <div class="form-group">
            <label style="display:flex; gap:8px; align-items:center;">
                <input type="checkbox" name="works_by_contract" value="1" {{ request('works_by_contract') ? 'checked' : '' }}>
                Работа по договору
            </label>
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%;">Применить</button>
    </form>
</div>

<div class="card">
    <h3 style="font-size: 17px; margin-bottom: 8px;">Подсказки</h3>
    <ul style="padding-left: 18px; color:#4f5864;">
        <li style="margin-bottom: 6px;">Используйте фильтр по городу для точных результатов</li>
        <li style="margin-bottom: 6px;">Откройте профиль перед созданием заказа</li>
        <li>Проверяйте бейджи паспорта и гарантии</li>
    </ul>
</div>
@endsection
