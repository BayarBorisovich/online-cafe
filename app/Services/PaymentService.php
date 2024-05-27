<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use YooKassa\Client;
use YooKassa\Common\Exceptions\ApiConnectionException;
use YooKassa\Common\Exceptions\ApiException;
use YooKassa\Common\Exceptions\AuthorizeException;
use YooKassa\Common\Exceptions\BadApiRequestException;
use YooKassa\Common\Exceptions\ExtensionNotFoundException;
use YooKassa\Common\Exceptions\ForbiddenException;
use YooKassa\Common\Exceptions\InternalServerError;
use YooKassa\Common\Exceptions\NotFoundException;
use YooKassa\Common\Exceptions\ResponseProcessingException;
use YooKassa\Common\Exceptions\TooManyRequestsException;
use YooKassa\Common\Exceptions\UnauthorizedException;

class PaymentService
{
    public function getClient(): Client
    {
        $client = new Client();
        $client->setAuth(Config::get('yookassa.shop_id'), Config::get('yookassa.secret_key'));

        return $client;
    }

    /**
     * @throws NotFoundException
     * @throws ResponseProcessingException
     * @throws ApiException
     * @throws ExtensionNotFoundException
     * @throws BadApiRequestException
     * @throws AuthorizeException
     * @throws InternalServerError
     * @throws ForbiddenException
     * @throws TooManyRequestsException
     * @throws ApiConnectionException
     * @throws UnauthorizedException
     */
    public function createPayment(float $totalPrice, int $orderId, string $name, int $transactionId): string
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
                'metadata' => array(
                    'transaction_id' => $transactionId,
                )
            ),
            uniqid('', true)
        );

        return $payment->getConfirmation()->getConfirmationUrl();
    }

    public function createTransaction(int $orderId, float $totalPrice, string $description = null): Model|Builder
    {
        return Transaction::query()->create([
            'order_id' => $orderId,
            'amount' => $totalPrice,
            'description' => $description,
        ]);

    }

}
