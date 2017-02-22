<?php
/**
 * Shopware 5
 * Copyright (c) shopware AG
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 */

namespace SwagPaymentPayPalUnified\Tests\Functional\Components\Services;

use Doctrine\DBAL\Connection;
use SwagPaymentPayPalUnified\Components\Services\OrderDataService;
use SwagPaymentPayPalUnified\Tests\FixtureImportTestCaseTrait;
use SwagPaymentPayPalUnified\Tests\Functional\DatabaseTestCaseTrait;

class OrderDataServiceTest extends \PHPUnit_Framework_TestCase
{
    use DatabaseTestCaseTrait;
    use FixtureImportTestCaseTrait;

    const ORDER_NUMBER = 99999;
    const PAYMENT_STATUS_APPROVED = 12;
    const TEST_TRANSACTION_ID = 'FAKE-PAYPAL-TRANSACTION-ID';

    public function test_order_data_service_test_is_available()
    {
        $orderDataService = $this->getOrderDataService();

        $this->assertInstanceOf(OrderDataService::class, $orderDataService);
    }

    public function test_apply_order_status_without_existing_order_returns_false()
    {
        $orderDataService = $this->getOrderDataService();

        $this->assertFalse($orderDataService->applyPaymentStatus('WRONG_ORDER_NUMBER', self::PAYMENT_STATUS_APPROVED));
    }

    public function test_should_update_order_status()
    {
        $orderDataService = $this->getOrderDataService();

        $orderDataService->applyPaymentStatus(self::ORDER_NUMBER, self::PAYMENT_STATUS_APPROVED);

        /** @var Connection $dbalConnection */
        $dbalConnection = Shopware()->Container()->get('dbal_connection');
        $updatedOrder = $dbalConnection->executeQuery('SELECT * FROM s_order WHERE ordernumber="' . self::ORDER_NUMBER . '"')->fetchAll();

        $this->assertEquals(self::PAYMENT_STATUS_APPROVED, $updatedOrder[0]['cleared']);
    }

    public function test_apply_transaction_id_without_existing_order_returns_false()
    {
        $orderDataService = $this->getOrderDataService();

        $this->assertFalse($orderDataService->applyPaymentStatus('WRONG_ORDER_NUMBER', self::PAYMENT_STATUS_APPROVED));
    }

    public function test_should_update_transaction_id()
    {
        $orderDataService = $this->getOrderDataService();

        $orderDataService->applyTransactionId(self::ORDER_NUMBER, self::TEST_TRANSACTION_ID);

        /** @var Connection $dbalConnection */
        $dbalConnection = Shopware()->Container()->get('dbal_connection');
        $updatedOrder = $dbalConnection->executeQuery('SELECT transactionID FROM s_order WHERE ordernumber="' . self::ORDER_NUMBER . '"')->fetchAll();

        $this->assertEquals(self::TEST_TRANSACTION_ID, $updatedOrder[0]['transactionID']);
    }

    public function test_getTransactionId_returns_correct_id()
    {
        $orderDataService = $this->getOrderDataService();

        $orderDataService->applyTransactionId(self::ORDER_NUMBER, self::TEST_TRANSACTION_ID);

        $this->assertEquals(self::TEST_TRANSACTION_ID, $orderDataService->getTransactionId(self::ORDER_NUMBER));
    }

    /**
     * @return OrderDataService
     */
    private function getOrderDataService()
    {
        return Shopware()->Container()->get('paypal_unified.order_data_service');
    }
}