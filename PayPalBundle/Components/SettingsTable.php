<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagPaymentPayPalUnified\PayPalBundle\Components;

/**
 * No complete table names can be declared below to avoid references to the actual plugin.
 */
class SettingsTable
{
    public const GENERAL = 'general';
    public const EXPRESS_CHECKOUT = 'express';
    public const INSTALLMENTS = 'installments';
    public const PLUS = 'plus';
}
