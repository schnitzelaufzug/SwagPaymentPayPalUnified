<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagPaymentPayPalUnified\Tests\Functional\Subscriber\Mock\PaymentMeansSubscriberTest;

use SwagPaymentPayPalUnified\Tests\Functional\PayPalUnifiedPaymentIdTrait;

class EventArgsMockWithUnifiedReturn extends \Enlight_Event_EventArgs
{
    use PayPalUnifiedPaymentIdTrait;

    /**
     * @var array<array{id: int}>
     */
    public $result;

    /**
     * @return array<array{id: int}>
     */
    public function getReturn()
    {
        return [
            ['id' => 0],
            ['id' => 1],
            ['id' => 2],
            ['id' => 3],
            ['id' => 4],
            ['id' => $this->getUnifiedPaymentId()],
        ];
    }

    /**
     * @param array<array{id: int}> $result
     */
    public function setReturn($result)
    {
        $this->result = $result;
    }
}
