@extends('layouts.marketplace')

@section('title', 'Пользователи')

@section('content')
<h1 style="margin-bottom: 20px; font-size: 22px;">Пользователи</h1>
<p><a href="{{ route('admin.dashboard') }}">Назад в админку</a></p>

@foreach($users as $u)
    <div class="card">
        <strong>{{ $u->name }}</strong> ({{ $u->email }}) - роль: {{ $u->role }}

        @if($u->specialistProfile)
            <div style="margin-top: 8px;">
                Город специалиста: {{ $u->specialistProfile->city }}
            </div>
            <div style="margin-top: 8px;">
                Паспорт: {{ $u->specialistProfile->passport_verified ? 'Подтвержден' : 'Не подтвержден' }}
            </div>
        @endif

        @if($u->isSpecialist())
            <form action="{{ route('admin.users.passport.update', $u) }}" method="post" style="margin-top: 12px; display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                @csrf
                @method('PATCH')
                <label for="passport-{{ $u->id }}">Статус паспорта</label>
                <select id="passport-{{ $u->id }}" name="passport_verified" style="padding: 8px 10px; border: 1px solid #d9d9d9; border-radius: 6px;">
                    <option value="1" {{ optional($u->specialistProfile)->passport_verified ? 'selected' : '' }}>Подтвержден</option>
                    <option value="0" {{ optional($u->specialistProfile)->passport_verified ? '' : 'selected' }}>Не подтвержден</option>
                </select>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
        @endif
    </div>
@endforeach

{{ $users->links() }}
@endsection
