<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagPaymentPayPalUnified\PayPalBundle\V2;

final class PaymentStatusV2
{
    const ORDER_CREATED = 'CREATED';
    const ORDER_SAVED = 'SAVED';
    const ORDER_APPROVED = 'APPROVED';
    const ORDER_VOIDED = 'VOIDED';
    const ORDER_COMPLETED = 'COMPLETED';
    const ORDER_PAYER_ACTION_REQUIRED = 'PAYER_ACTION_REQUIRED';

    const ORDER_CAPTURE_COMPLETED = 'COMPLETED';
    const ORDER_CAPTURE_DECLINED = 'DECLINED';
    const ORDER_CAPTURE_PARTIALLY_REFUNDED = 'PARTIALLY_REFUNDED';
    const ORDER_CAPTURE_PENDING = 'PENDING';
    const ORDER_CAPTURE_REFUNDED = 'REFUNDED';

    const ORDER_AUTHORIZATION_CREATED = 'CREATED';
    const ORDER_AUTHORIZATION_CAPTURED = 'CAPTURED';
    const ORDER_AUTHORIZATION_DENIED = 'DENIED';
    const ORDER_AUTHORIZATION_EXPIRED = 'EXPIRED';
    const ORDER_AUTHORIZATION_PARTIALLY_CAPTURED = 'PARTIALLY_CAPTURED';
    const ORDER_AUTHORIZATION_VOIDED = 'VOIDED';
    const ORDER_AUTHORIZATION_PENDING = 'PENDING';

    const ORDER_REFUND_CANCELLED = 'CANCELLED';
    const ORDER_REFUND_PENDING = 'PENDING';
    const ORDER_REFUND_COMPLETED = 'COMPLETED';

    private function __construct()
    {
    }
}
