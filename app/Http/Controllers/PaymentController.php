<?php

namespace App\Http\Controllers;


use App\Models\Transaction;
use App\Services\PaymentService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use YooKassa\Model\Notification\NotificationEventType;
use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationWaitingForCapture;


class PaymentController extends Controller
{
    public function callback(Request $request, PaymentService $paymentService): void
    {
        $source = file_get_contents('php://input');
        $requestBody = json_decode($source, true);

        Log::channel('daily')->info('requestBody ' . json_encode($requestBody)); // в лог
        Log::channel('daily')->info("source  $source"); // в лог


//        $transaction = Auth::user()->orders()
//            ->with('transactions')->first()
//            ->transactions()->first();


        try {
            $notification = ($requestBody['event'] === NotificationEventType::PAYMENT_SUCCEEDED)
                ? new NotificationSucceeded($requestBody)
                : new NotificationWaitingForCapture($requestBody);
        } catch (Exception $e) {
            // Обработка ошибок при неверных данных
            Log::channel('daily')->error('error' . $e->getMessage());
        }
        $payment = $notification->getObject();

        if (isset ($payment->status) && $payment->status === 'succeeded') {
            if ($payment->paid === true) {
                $metadata = $payment->metadata;
                if ( isset($metadata->transaction_id) ) {
                    $transactionId = $metadata->transaction_id;
                    $transaction = Transaction::query()->find($transactionId);
                    $transaction->update([
                        'status' => 'CONFIRMED'
                    ]);
                }
            }
        }

//        try {
//            $source = file_get_contents('php://input');
//            $data = json_decode($source, true);
//
//            Log::channel('daily')->info('source ' . $source); // в лог
//
//
//            $factory = new \YooKassa\Model\Notification\NotificationFactory();
//            $notificationObject = $factory->factory($data);
//            $responseObject = $notificationObject->getObject();
//
//            $client = $paymentService->getClient();
//
//            if (!$client->isNotificationIPTrusted($_SERVER['REMOTE_ADDR'])) {
//                header('HTTP/1.1 400 Something went wrong');
//                exit();
//            }
//
//            if ($notificationObject->getEvent() === \YooKassa\Model\Notification\NotificationEventType::PAYMENT_SUCCEEDED) {
//                $someData = [
//                    'paymentId' => $responseObject->getId(),
//                    'paymentStatus' => $responseObject->getStatus(),
//                ];
//                // Специфичная логика
//                // ...
//            } elseif ($notificationObject->getEvent() === \YooKassa\Model\Notification\NotificationEventType::PAYMENT_WAITING_FOR_CAPTURE) {
//                $someData = [
//                    'paymentId' => $responseObject->getId(),
//                    'paymentStatus' => $responseObject->getStatus(),
//                ];
//                // Специфичная логика
//                // ...
//            } elseif ($notificationObject->getEvent() === \YooKassa\Model\Notification\NotificationEventType::PAYMENT_CANCELED) {
//                $someData = [
//                    'paymentId' => $responseObject->getId(),
//                    'paymentStatus' => $responseObject->getStatus(),
//                ];
//                // Специфичная логика
//                // ...
//            } elseif ($notificationObject->getEvent() === \YooKassa\Model\Notification\NotificationEventType::REFUND_SUCCEEDED) {
//                $someData = [
//                    'refundId' => $responseObject->getId(),
//                    'refundStatus' => $responseObject->getStatus(),
//                    'paymentId' => $responseObject->getPaymentId(),
//                ];
//                // ...
//                // Специфичная логика
//            } else {
//                header('HTTP/1.1 400 Something went wrong');
//                exit();
//            }
//
//            // Специфичная логика
//            // ...
//
////            $client->setAuth('xxxxxx', 'test_XXXXXXX');
//
//            // Получим актуальную информацию о платеже
//            if ($paymentInfo = $client->getPaymentInfo($someData['paymentId'])) {
//                $paymentStatus = $paymentInfo->getStatus();
//                Log::channel('daily')->info('paymentStatus ' . $paymentStatus); // в лог
//
//                // Специфичная логика
//                // ...
//            } else {
//                header('HTTP/1.1 400 Something went wrong');
//                exit();
//            }
//
//        } catch (Exception $e) {
//            header('HTTP/1.1 400 Something went wrong');
//            Log::channel('daily')->error('ошибка ' . $e); // в лог
//
//            exit();
//        }

    }
}
