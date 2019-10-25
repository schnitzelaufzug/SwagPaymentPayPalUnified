<?php
declare(strict_types=1);
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagPaymentPayPalUnified\PayPalBundle\Structs\Subscription\Plan\BillingCycle\PricingScheme;

class FixedPrice
{
    /**
     * @var string
     */
    private $currencyCode;

    /**
     * @var string
     */
    private $value;

    /**
     * @param string $currencyCode
     */
    public function setCurrencyCode($currencyCode)
    {
        $this->currencyCode = $currencyCode;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'currency_code' => $this->currencyCode,
            'value' => $this->value,
        ];
    }
}
