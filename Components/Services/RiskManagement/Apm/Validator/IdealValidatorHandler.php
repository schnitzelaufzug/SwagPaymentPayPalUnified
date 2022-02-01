<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagPaymentPayPalUnified\Components\Services\RiskManagement\Apm\Validator;

use SwagPaymentPayPalUnified\Components\Services\RiskManagement\Apm\ValidatorHandlerInterface;
use SwagPaymentPayPalUnified\PayPalBundle\PaymentType;
use Symfony\Component\Validator\Constraints\Collection as ValidatorConstraintsCollection;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\Range;

class IdealValidatorHandler implements ValidatorHandlerInterface
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
    public function createValidator($paymentType)
    {
        return new ValidatorConstraintsCollection([
            'country' => new EqualTo('NL'),
            'currency' => new EqualTo('EUR'),
            'amount' => new Range(['min' => 0.01, 'max' => \PHP_INT_MAX]),
        ]);
    }
}
