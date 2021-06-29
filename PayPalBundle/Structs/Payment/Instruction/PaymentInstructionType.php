<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagPaymentPayPalUnified\PayPalBundle\Structs\Payment\Instruction;

class PaymentInstructionType
{
    public const INVOICE = 'PAY_UPON_INVOICE';
    public const BANK_TRANSFER = 'MANUAL_BANK_TRANSFER';
}
