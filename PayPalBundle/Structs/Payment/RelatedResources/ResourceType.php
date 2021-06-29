<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagPaymentPayPalUnified\PayPalBundle\Structs\Payment\RelatedResources;

class ResourceType
{
    public const SALE = 'sale';
    public const REFUND = 'refund';
    public const AUTHORIZATION = 'authorization';
    public const ORDER = 'order';
    public const CAPTURE = 'capture';
}
