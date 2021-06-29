<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagPaymentPayPalUnified\PayPalBundle;

class RequestUri
{
    public const PAYMENT_RESOURCE = 'payments/payment';
    public const WEBHOOK_RESOURCE = 'notifications/webhooks';
    public const TOKEN_RESOURCE = 'oauth2/token';
    public const SALE_RESOURCE = 'payments/sale';
    public const REFUND_RESOURCE = 'payments/refund';
    public const AUTHORIZATION_RESOURCE = 'payments/authorization';
    public const CAPTURE_RESOURCE = 'payments/capture';
    public const ORDER_RESOURCE = 'payments/orders';
}
