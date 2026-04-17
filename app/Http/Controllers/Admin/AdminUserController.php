<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpecialistProfile;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $users = User::with('specialistProfile')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function updateSpecialistPassport(Request $request, User $user)
    {
        if (!$user->isSpecialist()) {
            return redirect()->route('admin.users.index')->with('error', 'Проверка паспорта доступна только для специалистов.');
        }

        $data = $request->validate([
            'passport_verified' => ['required', 'boolean'],
        ]);

        $profile = $user->specialistProfile;
        if (!$profile) {
            $profile = SpecialistProfile::create([
                'user_id' => $user->id,
                'city' => 'Не указан',
            ]);
        }

        $profile->update([
            'passport_verified' => (bool) $data['passport_verified'],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Статус паспорта обновлен.');
    }
}
