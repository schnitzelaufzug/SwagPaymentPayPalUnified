<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagPaymentPayPalUnified\Components;

final class ErrorCodes
{
    public const CANCELED_BY_USER = 1;
    public const COMMUNICATION_FAILURE = 2;
    public const NO_ORDER_TO_PROCESS = 3;
    public const UNKNOWN = 4;
    public const COMMUNICATION_FAILURE_FINISH = 5;
    public const BASKET_VALIDATION_ERROR = 6;
    public const ADDRESS_VALIDATION_ERROR = 7;
    public const NO_DISPATCH_FOR_ORDER = 8;

    private function __construct()
    {
    }
}
