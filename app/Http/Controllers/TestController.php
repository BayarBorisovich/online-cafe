<?php

namespace App\Http\Controllers;



use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
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
    public function test()
    {
        $product = Product::with('category')->get();

        dd($product);
    }

}
