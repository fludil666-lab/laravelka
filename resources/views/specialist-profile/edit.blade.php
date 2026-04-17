@extends('layouts.marketplace')

@section('title', 'Мой профиль исполнителя')

@section('content')
<h1 style="margin-bottom: 20px; font-size: 22px;">Мой профиль исполнителя</h1>

<form action="{{ route('specialist-profile.update') }}" method="post" class="card" style="margin-bottom: 24px;">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label>Город</label>
        <input type="text" name="city" value="{{ old('city', $profile->city) }}" required>
        @error('city')<div class="error">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
        <label>О себе / описание услуг</label>
        <textarea name="description" rows="5">{{ old('description', $profile->description) }}</textarea>
        @error('description')<div class="error">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
        <label class="checkbox"><input type="checkbox" name="with_guarantee" value="1" {{ old('with_guarantee', $profile->with_guarantee) ? 'checked' : '' }}> С гарантией</label>
    </div>
    <div class="form-group">
        <label class="checkbox"><input type="checkbox" name="works_by_contract" value="1" {{ old('works_by_contract', $profile->works_by_contract) ? 'checked' : '' }}> Работа по договору</label>
    </div>
    <div class="form-group">
        <label class="checkbox"><input type="checkbox" name="is_organization" value="1" {{ old('is_organization', $profile->is_organization) ? 'checked' : '' }}> Организация (не частное лицо)</label>
    </div>
    <button type="submit" class="btn btn-primary">Сохранить профиль</button>
</form>

<h2 style="font-size: 18px; margin-bottom: 12px;">Мои услуги</h2>
<form action="{{ route('specialist-profile.services.store') }}" method="post" class="card" style="margin-bottom: 16px;">
    @csrf
    <div class="form-group">
        <label>Категория</label>
        <select name="category_id" required>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Название услуги</label>
        <input type="text" name="title" value="{{ old('title') }}" required placeholder="Например: Устранение засора канализации">
        @error('title')<div class="error">{{ $message }}</div>@enderror
    </div>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
        <div class="form-group">
            <label>Цена от (руб)</label>
            <input type="number" name="price_from" value="{{ old('price_from') }}" min="0" placeholder="Оставьте пустым для «по договорённости»">
        </div>
        <div class="form-group">
            <label>Тип цены</label>
            <select name="price_type">
                <option value="by_agreement">По договорённости</option>
                <option value="fixed" {{ old('price_type') === 'fixed' ? 'selected' : '' }}>Фиксированная</option>
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Добавить услугу</button>
</form>

@foreach($profile->services as $srv)
    <div class="card" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <strong>{{ $srv->title }}</strong> ({{ $srv->category->name }}) — {{ $srv->price_type === 'by_agreement' ? 'по договорённости' : 'от ' . $srv->price_from . ' р' }}
        </div>
        <form action="{{ route('specialist-profile.services.destroy', $srv) }}" method="post" onsubmit="return confirm('Удалить услугу?');">
            @csrf
            <button type="submit" class="btn btn-outline" style="color: #c00;">Удалить</button>
        </form>
    </div>
@endforeach
@endsection
