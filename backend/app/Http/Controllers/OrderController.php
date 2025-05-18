<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\QueryBuilder;

class OrderController extends Controller
{
    public function index() {
        $orders = QueryBuilder::for(Order::class)
            ->with('user', 'plan')
            ->allowedFilters('user.name', 'user.email', 'plan.name')
            ->allowedSorts('amount', 'created_at')
            ->paginate();

        return JsonResource::collection($orders);
    }

    public function show(Order $order) {
        return new JsonResource($order);
    }

    public function save(Request $request, ?Order $order=null) {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'amount' => ['required', 'number'],
            'transaction_id' => ['nullable', 'string'],
            'plan_id' => ['required', 'exists:plan,id']
        ]);

        $order = $order ?? new Order();

        $order->fill($validated);

        $order->save();

        return $this->show($order);
    }

    public function store(Request $request) {
        return $this->save($request);
    }

    public function update(Request $request, Order $order) {
        return $this->save($request, $order);
    } 

    public function destroy(Order $order) {
        return $order->delete();
    }
}
