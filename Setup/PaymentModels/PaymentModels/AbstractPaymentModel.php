<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagPaymentPayPalUnified\Setup\PaymentModels\PaymentModels;

use Shopware\Models\Payment\Payment;
use Shopware\Models\Plugin\Plugin;

abstract class AbstractPaymentModel
{
    const POSITION_PAYPAL_CLASSIC = -100;
    const POSITION_PAY_UPON_INVOICE = -99;
    const POSITION_BANCONTACT = -98;
    const POSITION_BLIK = -97;
    const POSITION_EPS = -96;
    const POSITION_GIROPAY = -95;
    const POSITION_IDEAL = -94;
    const POSITION_MULTIBANCO = -93;
    const POSITION_MY_BANK = -92;
    const POSITION_OXXO = -91;
    const POSITION_P24 = -90;
    const POSITION_SOFORT = -89;
    const POSITION_TRUSTLY = -88;
    const POSITION_ADVANCED_CEDIT_DEBIT_CARD = -87;
    const POSITION_SEPA = -86;

    const ACTION_PAYPAL_CLASSIC = 'PaypalUnifiedV2';
    const ACTION_PAYPAL_PAY_UPON_INVOICE = 'PaypalUnifiedV2PayUponInvoice';
    const ACTION_PAYPAL_APM = 'PaypalUnifiedApm';
    const ACTION_PAYPAL_ADVANCED_CREDIT_DEBIT_CARD = 'PaypalUnifiedV2AdvancedCreditDebitCard';

    /**
     * @var Plugin
     */
    protected $plugin;

    public function __construct(Plugin $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @return Payment
     */
    abstract public function create();
}
