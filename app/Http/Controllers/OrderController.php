<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (!Schema::hasTable('orders')) {
            return redirect()->route('home')->with('error', 'Таблица заказов не найдена. Выполните: php artisan migrate');
        }

        $user = $request->user();

        $orders = Order::with(['customer', 'specialistProfile.user'])
            ->where(function ($query) use ($user) {
                $query->where('customer_id', $user->id);

                if ($user->isSpecialist()) {
                    $query->orWhereHas('specialistProfile', fn($q) => $q->where('user_id', $user->id));
                }
            })
            ->latest()
            ->paginate(15);

        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'specialist_profile_id' => 'required|exists:specialist_profiles,id',
            'address' => 'required|string|max:500',
            'scheduled_date' => 'required|date|after_or_equal:today',
            'scheduled_time' => 'required|date_format:H:i',
            'description' => 'nullable|string|max:1000',
        ]);

        $scheduledAt = Carbon::createFromFormat(
            'Y-m-d H:i',
            $data['scheduled_date'] . ' ' . $data['scheduled_time'],
            config('app.timezone')
        );

        if ($scheduledAt->lt(now())) {
            return back()
                ->withErrors(['scheduled_date' => 'Выберите будущие дату и время.'])
                ->withInput();
        }

        $data['customer_id'] = $request->user()->id;
        $data['status'] = Order::STATUS_PENDING;
        Order::create($data);

        return redirect()->route('orders.index')->with('success', 'Заказ создан.');
    }

    public function cancel(Request $request, Order $order)
    {
        if ((int) $order->customer_id !== (int) $request->user()->id) {
            abort(403);
        }

        if (in_array($order->status, [Order::STATUS_COMPLETED, Order::STATUS_CANCELLED], true)) {
            return redirect()->route('orders.index')->with('error', 'Этот заказ уже нельзя отменить.');
        }

        $order->update([
            'status' => Order::STATUS_CANCELLED,
        ]);

        return redirect()->route('orders.index')->with('success', 'Заказ отменен.');
    }
}
