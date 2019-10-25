<?php
declare(strict_types=1);
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagPaymentPayPalUnified\PayPalBundle\Structs\Subscription\Plan;

use SwagPaymentPayPalUnified\PayPalBundle\Structs\Subscription\Plan\BillingCycle\Frequency;
use SwagPaymentPayPalUnified\PayPalBundle\Structs\Subscription\Plan\BillingCycle\PricingScheme;

class BillingCycle
{
    /**
     * @var PricingScheme
     */
    private $pricingScheme;

    /**
     * @var Frequency
     */
    private $frequency;

    /**
     * @var string
     */
    private $tenureType = 'REGULAR';

    /**
     * @var int
     */
    private $sequence;

    /**
     * @var int
     */
    private $totalCycles;

    public function setPricingScheme(PricingScheme $pricingScheme)
    {
        $this->pricingScheme = $pricingScheme;
    }

    public function setFrequency(Frequency $frequency)
    {
        $this->frequency = $frequency;
    }

    /**
     * @param string $tenureType
     */
    public function setTenureType($tenureType)
    {
        $this->tenureType = $tenureType;
    }

    /**
     * @param int $sequence
     */
    public function setSequence($sequence)
    {
        $this->sequence = $sequence;
    }

    /**
     * @param int $totalCycles
     */
    public function setTotalCycles($totalCycles)
    {
        $this->totalCycles = $totalCycles;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'pricing_scheme' => $this->pricingScheme->toArray(),
            'frequency' => $this->frequency->toArray(),
            'tenure_type' => $this->tenureType,
            'sequence' => $this->sequence,
            'total_cycles' => $this->totalCycles,
        ];
    }
}
