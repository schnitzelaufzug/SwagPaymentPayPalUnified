<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagPaymentPayPalUnified\PayPalBundle\V2\Resource;

use SwagPaymentPayPalUnified\PayPalBundle\RequestType;
use SwagPaymentPayPalUnified\PayPalBundle\Services\ClientService;
use SwagPaymentPayPalUnified\PayPalBundle\V2\Api\Order;
use SwagPaymentPayPalUnified\PayPalBundle\V2\Api\Patch;
use SwagPaymentPayPalUnified\PayPalBundle\V2\RequestUriV2;
use SwagPaymentPayPalUnified\PayPalBundle\V2\Resource\OrderArrayFactory\OrderArrayFactory;

class OrderResource
{
    /**
     * @var ClientService
     */
    private $clientService;

    /**
     * @var OrderArrayFactory
     */
    private $arrayFactory;

    public function __construct(ClientService $clientService, OrderArrayFactory $arrayFactory)
    {
        $this->clientService = $clientService;
        $this->arrayFactory = $arrayFactory;
    }

    /**
     * @param string $orderId
     *
     * @return Order
     */
    public function get($orderId)
    {
        $response = $this->clientService->sendRequest(
            RequestType::GET,
            \sprintf('%s/%s', RequestUriV2::ORDERS_RESOURCE, $orderId)
        );

        return (new Order())->assign($response);
    }

    /**
     * @param string $partnerAttributionId
     * @param string $paymentType
     * @param bool   $minimalResponse
     *
     * @return Order
     */
    public function create(Order $order, $paymentType, $partnerAttributionId, $minimalResponse = true)
    {
        $this->clientService->setPartnerAttributionId($partnerAttributionId);
        if ($minimalResponse === false) {
            $this->clientService->setHeader('Prefer', 'return=representation');
        }

        /*
         * This is only necessary, because the Request-Id-Header should be
         * optional, but isn't. This is a quirk of PayPals staging system again,
         * so may be removed later on if possible. Otherwise we'll need to
         * implement some way of storing this alongside the order, as outlined
         * below.
         *
         * TODO: (PT-12531) check back later (after testing against the public sandbox) to either remove or store this value
         *
         * @see https://developer.paypal.com/docs/api/reference/api-requests/#paypal-request-id
         */
        if ($order->getPaymentSource() !== null) {
            $id = bin2hex((string) openssl_random_pseudo_bytes(16));

            $this->clientService->setHeader('PayPal-Request-Id', $id);
        }

        $response = $this->clientService->sendRequest(
            RequestType::POST,
            RequestUriV2::ORDERS_RESOURCE,
            $this->arrayFactory->toArray($order, $paymentType)
        );

        return (new Order())->assign($response);
    }

    /**
     * @param Patch[] $patches
     * @param string  $orderId
     * @param string  $partnerAttributionId
     *
     * @return void
     */
    public function update(array $patches, $orderId, $partnerAttributionId)
    {
        $this->clientService->setPartnerAttributionId($partnerAttributionId);
        $this->clientService->sendRequest(
            RequestType::PATCH,
            \sprintf('%s/%s', RequestUriV2::ORDERS_RESOURCE, $orderId),
            $patches
        );
    }

    /**
     * @param string $orderId
     * @param string $partnerAttributionId
     * @param bool   $minimalResponse
     *
     * @return Order
     */
    public function capture(
        $orderId,
        $partnerAttributionId,
        $minimalResponse = false
    ) {
        $this->clientService->setPartnerAttributionId($partnerAttributionId);
        if ($minimalResponse === false) {
            $this->clientService->setHeader('Prefer', 'return=representation');
        }

        $response = $this->clientService->sendRequest(
            RequestType::POST,
            \sprintf('%s/%s/capture', RequestUriV2::ORDERS_RESOURCE, $orderId),
            null
        );

        return (new Order())->assign($response);
    }

    /**
     * @param string $orderId
     * @param string $partnerAttributionId
     * @param bool   $minimalResponse
     *
     * @return Order
     */
    public function authorize(
        $orderId,
        $partnerAttributionId,
        $minimalResponse = false
    ) {
        $this->clientService->setPartnerAttributionId($partnerAttributionId);
        if ($minimalResponse === false) {
            $this->clientService->setHeader('Prefer', 'return=representation');
        }

        $response = $this->clientService->sendRequest(
            RequestType::POST,
            \sprintf('%s/%s/authorize', RequestUriV2::ORDERS_RESOURCE, $orderId),
            null
        );

        return (new Order())->assign($response);
    }
}
