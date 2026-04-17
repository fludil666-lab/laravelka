<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SpecialistProfile;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $stats = [
            'users' => User::count(),
            'specialists' => SpecialistProfile::count(),
            'orders' => Order::count(),
        ];
        $recentOrders = Order::with(['customer', 'specialistProfile.user'])->latest()->take(10)->get();
        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
