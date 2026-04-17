<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SpecialistProfile;
use App\Models\SpecialistService;
use Illuminate\Http\Request;

class SpecialistProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        $user = request()->user();
        if (!$user->isSpecialist()) {
            return redirect()->route('home')->with('error', 'Доступно только исполнителям.');
        }
        $profile = $user->specialistProfile;
        if (!$profile) {
            $profile = SpecialistProfile::create([
                'user_id' => $user->id,
                'city' => '',
            ]);
        }
        $profile->load('services.category');
        $categories = Category::orderBy('sort_order')->get();
        return view('specialist-profile.edit', compact('profile', 'categories'));
    }

    public function update(Request $request)
    {
        $user = $request->user();
        if (!$user->isSpecialist()) {
            abort(403);
        }
        $profile = $user->specialistProfile;
        if (!$profile) {
            abort(404);
        }
        $data = $request->validate([
            'city' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);
        $data['with_guarantee'] = $request->boolean('with_guarantee');
        $data['works_by_contract'] = $request->boolean('works_by_contract');
        $data['is_organization'] = $request->boolean('is_organization');
        $profile->update($data);
        $profile->update(['last_online_at' => now()]);
        return redirect()->route('specialist-profile.edit')->with('success', 'Профиль обновлён.');
    }

    public function storeService(Request $request)
    {
        $user = $request->user();
        if (!$user->isSpecialist()) {
            abort(403);
        }
        $profile = $user->specialistProfile;
        if (!$profile) {
            abort(404);
        }
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'price_from' => 'nullable|integer|min:0',
            'price_type' => 'in:fixed,by_agreement',
        ]);
        $data['specialist_profile_id'] = $profile->id;
        $data['price_type'] = $data['price_type'] ?? 'by_agreement';
        SpecialistService::create($data);
        return redirect()->route('specialist-profile.edit')->with('success', 'Услуга добавлена.');
    }

    public function destroyService(SpecialistService $service)
    {
        if ($service->specialistProfile->user_id !== request()->user()->id) {
            abort(403);
        }
        $service->delete();
        return redirect()->route('specialist-profile.edit')->with('success', 'Услуга удалена.');
    }
}
