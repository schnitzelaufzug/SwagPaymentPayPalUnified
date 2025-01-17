<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagPaymentPayPalUnified\Tests\Unit\Controllers\Frontend;

use SwagPaymentPayPalUnified\Components\ErrorCodes;
use SwagPaymentPayPalUnified\Controllers\Frontend\AbstractPaypalPaymentController;
use SwagPaymentPayPalUnified\PayPalBundle\PaymentType;
use SwagPaymentPayPalUnified\PayPalBundle\V2\Api\Order;
use SwagPaymentPayPalUnified\Tests\Unit\PaypalPaymentControllerTestCase;

class AbstractPaypalPaymentControllerTest extends PaypalPaymentControllerTestCase
{
    /**
     * @param string $paypalErrorCode
     * @param string $shopwareErrorCode
     *
     * @dataProvider cancelActionErrorCodeProvider
     *
     * @return void
     */
    public function testCancelActionUsesExpectedErrorCodes($paypalErrorCode, $shopwareErrorCode)
    {
        $this->prepareRedirectDataBuilderFactory($this->redirectDataBuilder);

        $this->givenThePaypalErrorCodeEquals($paypalErrorCode);
        $this->expectTheShopwareErrorCodeToBe($shopwareErrorCode);

        $this->getController(TestPaypalPaymentController::class)->cancelAction();
    }

    /**
     * @param string $checkoutType
     * @param string $paymentType
     *
     * @dataProvider getPaymentTypeCheckoutTypeProvider
     *
     * @return void
     */
    public function testGetPaymentTypeReturnsEarlyForCertainCheckoutTypes($checkoutType, $paymentType)
    {
        $this->givenTheCheckoutTypeEquals($checkoutType);

        static::assertSame(
            $paymentType,
            $this->getController(TestPaypalPaymentController::class)->getPaymentType(new Order())
        );
    }

    /**
     * @return array<string,array<string|int>>
     */
    public function cancelActionErrorCodeProvider()
    {
        return [
            'Unknown error code' => [
                'badcd139-2df3-4a12-89e0-0e0ec176843f',
                ErrorCodes::CANCELED_BY_USER,
            ],
            'Processing error' => [
                'processing_error',
                ErrorCodes::COMMUNICATION_FAILURE,
            ],
        ];
    }

    /**
     * @return array<string,array<string>>
     */
    public function getPaymentTypeCheckoutTypeProvider()
    {
        return [
            '"SEPA" checkout' => [
                'sepaCheckout',
                PaymentType::PAYPAL_SEPA,
            ],
            '"ACDC" checkout' => [
                'acdcCheckout',
                PaymentType::PAYPAL_ADVANCED_CREDIT_DEBIT_CARD,
            ],
            '"Smart Payment Buttons" checkout' => [
                'spbCheckout',
                PaymentType::PAYPAL_SMART_PAYMENT_BUTTONS_V2,
            ],
            '"In Context" checkout' => [
                'inContextCheckout',
                PaymentType::PAYPAL_CLASSIC_V2,
            ],
        ];
    }

    /**
     * @param string $errorCode
     *
     * @return void
     */
    protected function expectTheShopwareErrorCodeToBe($errorCode)
    {
        $this->redirectDataBuilder->expects(static::once())
            ->method('setCode')
            ->with($errorCode);
    }

    /**
     * @param string $errorCode
     *
     * @return void
     */
    protected function givenThePaypalErrorCodeEquals($errorCode)
    {
        $this->request->method('getParam')
            ->with('errorcode')
            ->willReturn($errorCode);
    }

    /**
     * @param string $checkoutType
     *
     * @return void
     */
    protected function givenTheCheckoutTypeEquals($checkoutType)
    {
        $this->request->method('getParam')
            ->will(static::returnValueMap([
                [$checkoutType, false, true],
                [static::anything(), false, false],
            ]));
    }
}

class TestPaypalPaymentController extends AbstractPaypalPaymentController
{
    /**
     * @return int|string
     */
    public function getPaymentType(Order $order)
    {
        return parent::getPaymentType($order);
    }
}
