<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagPaymentPayPalUnified\Components\Services\OrderBuilder\PaymentSource\PaymentSourceValueHandler;

use SwagPaymentPayPalUnified\Components\PayPalOrderParameter\PayPalOrderParameter;
use SwagPaymentPayPalUnified\PayPalBundle\PaymentType;
use SwagPaymentPayPalUnified\PayPalBundle\V2\Api\Order\PaymentSource\Ideal;

class IdealPaymentSourceValueHandler extends AbstractPaymentSourceValueHandler
{
    /**
     * {@inheritDoc}
     */
    public function supports($paymentType)
    {
        return $paymentType === PaymentType::APM_IDEAL;
    }

    /**
     * {@inheritDoc}
     */
    public function createPaymentSourceValue(PayPalOrderParameter $orderParameter)
    {
        $paymentSourceValue = new Ideal();

        $this->setDefaultValues($paymentSourceValue, $orderParameter);

        return $paymentSourceValue;
    }
}
