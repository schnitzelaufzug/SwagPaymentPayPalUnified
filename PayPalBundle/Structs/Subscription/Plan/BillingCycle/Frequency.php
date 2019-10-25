<?php
declare(strict_types=1);
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagPaymentPayPalUnified\PayPalBundle\Structs\Subscription\Plan\BillingCycle;

class Frequency
{
    const INTERVAL_UNIT_DAY = 'DAY';
    const INTERVAL_UNIT_WEEK = 'WEEK';
    const INTERVAL_UNIT_MONTH = 'MONTH';
    const INTERVAL_UNIT_YEAR = 'YEAR';

    /**
     * @var string
     */
    private $intervalUnit;

    /**
     * @param string $intervalUnit
     */
    public function setIntervalUnit($intervalUnit)
    {
        $this->intervalUnit = $intervalUnit;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'interval_unit' => $this->intervalUnit,
        ];
    }
}
