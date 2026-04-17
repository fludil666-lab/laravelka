<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $orders = Order::with(['customer', 'specialistProfile.user'])->latest()->paginate(20);
        $statusLabels = Order::statusLabels();

        return view('admin.orders.index', compact('orders', 'statusLabels'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(Order::statuses())],
        ]);

        $order->update([
            'status' => $data['status'],
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Статус заказа обновлен.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Заказ удален.');
    }
}
