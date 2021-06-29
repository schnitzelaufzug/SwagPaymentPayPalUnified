<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagPaymentPayPalUnified\PayPalBundle;

class PaymentType
{
    public const PAYPAL_CLASSIC = 'PayPalClassic';
    public const PAYPAL_PLUS = 'PayPalPlus';
    public const PAYPAL_INVOICE = 'PayPalPlusInvoice';
    public const PAYPAL_EXPRESS = 'PayPalExpress';
    public const PAYPAL_SMART_PAYMENT_BUTTONS = 'PayPalSmartPaymentButtons';
}
