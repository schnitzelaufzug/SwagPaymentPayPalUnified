<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagPaymentPayPalUnified\PayPalBundle\Resources\Subscription;

use Shopware\Components\HttpClient\RequestException;
use SwagPaymentPayPalUnified\PayPalBundle\RequestType;
use SwagPaymentPayPalUnified\PayPalBundle\RequestUri;
use SwagPaymentPayPalUnified\PayPalBundle\Services\ClientService;
use SwagPaymentPayPalUnified\PayPalBundle\Structs\Subscription\Plan;

class PlanResource
{
    /**
     * @var ClientService
     */
    private $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    /**
     * @throws RequestException
     *
     * @return array
     */
    public function create(Plan $plan)
    {
        return $this->clientService->sendRequest(RequestType::POST, RequestUri::BILLING_PLAN_RESOURCE, $plan->toArray());
    }
}
