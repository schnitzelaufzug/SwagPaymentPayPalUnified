<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagPaymentPayPalUnified\PayPalBundle;

class PartnerAttributionId
{
    /**
     * Shopware Partner Id for PayPal Classic
     */
    public const PAYPAL_CLASSIC = 'Shopware_Cart_EC_5native';

    /**
     * Shopware Partner Id for PayPal Plus
     */
    public const PAYPAL_PLUS = 'Shopware_Cart_Plus_5native';

    /**
     * Shopware Partner Id for PayPal Express Checkout
     */
    public const PAYPAL_EXPRESS_CHECKOUT = 'Shopware_Cart_ECS_5native';

    /**
     * Shopware Partner Id for PayPal Smart Payment Buttons
     */
    public const PAYPAL_SMART_PAYMENT_BUTTONS = 'Shopware_Cart_SPB_5native';
}
