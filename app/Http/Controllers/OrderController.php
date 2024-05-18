<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;


class OrderController extends Controller
{
    private CartService  $cartService;
    private PaymentService  $paymentService;
    public function __construct(CartService $cartService, PaymentService $paymentService)
    {
        $this->cartService = $cartService;
        $this->paymentService = $paymentService;
    }
    public function getOrder(): View
    {
        return view('order');
    }

    public function createOrder(OrderRequest $request): RedirectResponse|JsonResponse
    {
        $data = $request->validated();

        $products = $this->cartService->getProducts();

        $totalInTheBasket = $this->cartService->totalInTheBasket();

        DB::beginTransaction();

        try {

            $order = Auth::user()->orders()->create([
                'user_name' => $data['user_name'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'comment' => $data['comment'],
            ]);

            foreach ($products as $cartProduct) {
                OrderItem::query()->create([
                    'order_id' => $order->id,
                    'product_id' => $cartProduct->product->id,
                    'quantity' => $cartProduct->quantity,
                    'price' => $cartProduct->product->price,
                ]);
           }
            $path = $this->paymentService->createPayment($totalInTheBasket['orderSum'], $order->id, $order->user_name);

            Auth::user()
                ->carts()
                ->with('products')
                ->first()
                ->products()->with('product')->delete();

        } catch (\Exception $exception) {
            DB::rollBack();
            Log::channel('daily')->error('Произошла ошибка при оформлении заказа ' . $exception->getMessage() . ' ' . $exception->getLine());

            return response()->json(['error' => 'Произошла ошибка при оформлении заказа']);
        }
        DB::commit();

        return response()->json([
        'path' => $path,
        ]);
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
            'sum' => round(array_sum($orderSum), 2),
            'totalQuantity' => array_sum($totalQuantity),
        ]);
    }
}
