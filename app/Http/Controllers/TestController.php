<?php

namespace App\Http\Controllers;



use App\Models\Cart;
use App\Models\Order;
use App\Models\Transaction;
use App\Services\CartService;
use App\Services\PaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use YooKassa\Model\Notification\NotificationEventType;
use YooKassa\Model\Notification\NotificationFactory;
use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationWaitingForCapture;

class TestController extends Controller
{
    private PaymentService $paymentService;
    private CartService  $cartService;
    public function __construct(PaymentService $paymentService, CartService $cartService)
    {
        $this->paymentService = $paymentService;
        $this->cartService = $cartService;
    }
    public function test()
    {
//        $a = Auth::user()->orders()
//            ->with('transactions')->first()
//            ->transactions()->first();
//        $transaction = Transaction::query()->find(8);

//        $transaction = $this->paymentService
//            ->createTransaction(
//                9,
//                99999
//            );
//        $a = Auth::user()
//            ->carts()
//            ->with('products')
//            ->first()
//            ->products()->with('product')->orderBy('id', 'desc')->get();

        dd($this->cartService->getProducts());
    }

}
