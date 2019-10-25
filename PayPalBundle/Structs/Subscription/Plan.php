<?php
declare(strict_types=1);
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagPaymentPayPalUnified\PayPalBundle\Structs\Subscription;

use SwagPaymentPayPalUnified\PayPalBundle\Structs\Subscription\Plan\BillingCycle;
use SwagPaymentPayPalUnified\PayPalBundle\Structs\Subscription\Plan\PaymentPreferences;

class Plan
{
    /**
     * @var string
     */
    private $productId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var BillingCycle[]
     */
    private $billingCycles;

    /**
     * @var PaymentPreferences
     */
    private $paymentPreferences;

    /**
     * @param string $productId
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param BillingCycle[] $billingCycles
     */
    public function setBillingCycles($billingCycles)
    {
        $this->billingCycles = $billingCycles;
    }

    public function setPaymentPreferences(PaymentPreferences $paymentPreferences)
    {
        $this->paymentPreferences = $paymentPreferences;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $billingCycles = [];
        foreach ($this->billingCycles as $billingCycle) {
            $billingCycles[] = $billingCycle->toArray();
        }

        return [
            'product_id' => $this->productId,
            'name' => $this->name,
            'billing_cycles' => $billingCycles,
            'payment_preferences' => $this->paymentPreferences->toArray(),
        ];
    }
}
