<?php

namespace App\Http\Controllers;

use App\Models\SpecialistProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BecomeSpecialistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Request $request)
    {
        $user = $request->user();
        if ($user->role === 'specialist') {
            return redirect()->route('specialist-profile.edit');
        }
        if ($user->role === 'admin') {
            return redirect()->route('home')->with('error', 'Администратор не может стать исполнителем.');
        }
        SpecialistProfile::firstOrCreate(
            ['user_id' => $user->id],
            ['city' => 'Не указан', 'description' => '']
        );
        $user->update(['role' => 'specialist']);
        return redirect()->route('specialist-profile.edit')->with('success', 'Теперь вы исполнитель. Заполните профиль и добавьте услуги.');
    }
}
