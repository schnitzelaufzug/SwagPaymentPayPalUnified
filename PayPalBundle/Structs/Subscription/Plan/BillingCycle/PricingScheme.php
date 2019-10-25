<?php
declare(strict_types=1);
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagPaymentPayPalUnified\PayPalBundle\Structs\Subscription\Plan\BillingCycle;

use SwagPaymentPayPalUnified\PayPalBundle\Structs\Subscription\Plan\BillingCycle\PricingScheme\FixedPrice;

class PricingScheme
{
    /**
     * @var FixedPrice
     */
    private $fixedPrice;

    public function setFixedPrice(FixedPrice $fixedPrice)
    {
        $this->fixedPrice = $fixedPrice;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'fixed_price' => $this->fixedPrice->toArray(),
        ];
    }
}
