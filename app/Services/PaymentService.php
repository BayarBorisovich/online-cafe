<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use YooKassa\Client;

class PaymentService
{
    public function getClient(): Client
    {
        $client = new Client();
        $client->setAuth(Config::get('yookassa.shop_id'), Config::get('yookassa.secret_key'));

        return $client;
    }

    public function createPayment(float $totalPrice, int $orderId, string $name): string
    {
        $client = $this->getClient();

        $payment = $client->createPayment(
            array(
                'amount' => array(
                    'value' => $totalPrice,
                    'currency' => 'RUB',
                ),
                'confirmation' => array(
                    'type' => 'redirect',
                    'return_url' => route('items'),
                ),
                'capture' => true,
                'description' => "Заказ № $orderId, для $name",
            ),
            uniqid('', true)
        );

        return $payment->getConfirmation()->getConfirmationUrl();
    }

}
