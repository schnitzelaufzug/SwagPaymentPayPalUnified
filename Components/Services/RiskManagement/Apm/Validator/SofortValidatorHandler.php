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
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Collection as ValidatorConstraintsCollection;
use Symfony\Component\Validator\Constraints\Range;

class SofortValidatorHandler implements ValidatorHandlerInterface
{
    /**
     * {@inheritDoc}
     */
    public function supports($paymentType)
    {
        return $paymentType === PaymentType::APM_SOFORT;
    }

    /**
     * {@inheritDoc}
     */
    public function createValidator($paymentType)
    {
        return new ValidatorConstraintsCollection([
            'country' => [
                new Choice([
                    'choices' => ['AT', 'BE', 'DE', 'ES', 'IT', 'NL'],
                    'groups' => ['euro'],
                ]),
                new Choice([
                    'choices' => ['GB'],
                    'groups' => ['uk'],
                ]),
            ],
            'currency' => [
                new Choice([
                    'choices' => ['EUR'],
                    'groups' => ['euro'],
                ]),
                new Choice([
                    'choices' => ['GBP'],
                    'groups' => ['uk'],
                ]),
            ],
            'amount' => new Range([
                'min' => 1.0,
                'max' => \PHP_INT_MAX,
                'groups' => ['euro', 'uk'],
            ]),
        ]);
    }
}
