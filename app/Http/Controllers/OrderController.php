<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function getOrder(): View
    {
        return view('order');
    }

    public function createOrder(OrderRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($data->fails)
        Order::create([
            'user_name' => $data['user_name'],
            'phone'=> $data['phone'],
            'city' => $data['city'],
            'street' => $data['street'],
            'house' => $data['house'],
            'comment' => $data['comment'],
            'user_id' => Auth::id(),
        ]);

       return response()->json(['success' => 'Данные успешно сохранены']);
    }
}
