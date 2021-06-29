<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagPaymentPayPalUnified\PayPalBundle;

class PaymentIntent
{
    public const SALE = 'sale';
    public const AUTHORIZE = 'authorize';
    public const ORDER = 'order';
}
