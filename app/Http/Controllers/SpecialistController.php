<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SpecialistProfile;
use Illuminate\Http\Request;

class SpecialistController extends Controller
{
    public function index(Request $request)
    {
        $query = SpecialistProfile::with(['user', 'services.category'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->where('is_published', true);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qry) use ($q) {
                $qry->where('description', 'like', "%{$q}%")
                    ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$q}%"));
            });
        }
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }
        if ($request->filled('category_id')) {
            $query->whereHas('services', fn($s) => $s->where('category_id', $request->category_id));
        }
        if ($request->boolean('with_guarantee')) {
            $query->where('with_guarantee', true);
        }
        if ($request->boolean('works_by_contract')) {
            $query->where('works_by_contract', true);
        }

        $specialists = $query->latest()->paginate(10);
        $categories = Category::whereNull('parent_id')->orderBy('sort_order')->get();

        return view('specialists.index', compact('specialists', 'categories'));
    }

    public function show(SpecialistProfile $specialist)
    {
        $specialist->load(['user', 'services.category']);
        if (!$specialist->is_published && (!auth()->check() || auth()->id() !== $specialist->user_id)) {
            abort(404);
        }
        return view('specialists.show', compact('specialist'));
    }
}
