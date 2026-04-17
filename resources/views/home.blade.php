@extends('layouts.marketplace')

@section('title', 'Р›РёС‡РЅС‹Р№ РєР°Р±РёРЅРµС‚')

@section('content')
<h1 style="margin-bottom: 20px; font-size: 22px;">Р›РёС‡РЅС‹Р№ РєР°Р±РёРЅРµС‚</h1>

<div class="card">
    <p>Р’С‹ РІРѕС€Р»Рё РєР°Рє <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->role }})</p>
    <p style="margin-top: 12px;">
        <a href="{{ route('specialists.index') }}">РќР°Р№С‚Рё СЃРїРµС†РёР°Р»РёСЃС‚Р°</a>
        В· <a href="{{ route('orders.index') }}">РњРѕРё Р·Р°РєР°Р·С‹</a>
        @if(Auth::user()->isSpecialist())
            В· <a href="{{ route('specialist-profile.edit') }}">РњРѕР№ РїСЂРѕС„РёР»СЊ РёСЃРїРѕР»РЅРёС‚РµР»СЏ</a>
        @else
            В· <a href="{{ route('become-specialist') }}">РЎС‚Р°С‚СЊ РёСЃРїРѕР»РЅРёС‚РµР»РµРј</a>
        @endif
        @if(Auth::user()->isAdmin())
            В· <a href="{{ route('admin.dashboard') }}">РђРґРјРёРЅ-РїР°РЅРµР»СЊ</a>
        @endif
    </p>
</div>
@endsection

