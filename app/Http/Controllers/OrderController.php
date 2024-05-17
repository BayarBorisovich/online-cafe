<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class OrderController extends Controller
{
    public function getOrder(): View
    {
        return view('order');
    }

    public function createOrder(OrderRequest $request): JsonResponse|RedirectResponse
    {
        $data = $request->validated();

        $products = Auth::user()
            ->carts()
            ->with('products')
            ->first()
            ->products()->with('product')->get();

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_name' => $data['user_name'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'comment' => $data['comment'],
                'user_id' => Auth::id(),
            ]);

            foreach ($products as $cartProduct) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartProduct->product->id,
                    'quantity' => $cartProduct->quantity,
                    'price' => $cartProduct->product->price,
                ]);
           }

            Auth::user()
                ->carts()
                ->with('products')
                ->first()
                ->products()->with('product')->delete();

        } catch (\Exception $exception) {
            DB::rollBack();
            $error = $exception->getMessage();

            return response()->json(['error' => 'Произошла ошибка при оформлении заказа' . $error]);
        }
        DB::commit();

        return redirect()->route('items');
    }

    public function getOrderItems(): View
    {
        return view('orderItem');
    }
    public function getOrders(): JsonResponse
    {
        $products = Auth::user()
            ->orders()
            ->with('items')
            ->first()
            ->items()->with('product')->get();

        $orderSum = [];
        $totalQuantity = [];
        foreach ($products as $product) {
            $totalQuantity[] = $product->quantity;
            $orderSum[] = $product->product->price * $product->quantity;

        }

        return response()->json([
            'order' => $products,
            'sum' => array_sum($orderSum),
            'totalQuantity' => array_sum($totalQuantity),
        ]);
    }
}
