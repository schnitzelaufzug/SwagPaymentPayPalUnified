<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Shopware\Components\HttpClient\RequestException;
use Shopware\Models\Shop\Repository as ShopRepository;
use Shopware\Models\Shop\Shop;
use SwagPaymentPayPalUnified\PayPalBundle\Resources\Subscription\CatalogProductResource;
use SwagPaymentPayPalUnified\PayPalBundle\Resources\Subscription\PlanResource;
use SwagPaymentPayPalUnified\PayPalBundle\Structs\Subscription\CatalogProduct;
use SwagPaymentPayPalUnified\PayPalBundle\Structs\Subscription\Plan;
use SwagPaymentPayPalUnified\PayPalBundle\Structs\Subscription\Plan\BillingCycle;
use SwagPaymentPayPalUnified\PayPalBundle\Structs\Subscription\Plan\BillingCycle\Frequency;
use SwagPaymentPayPalUnified\PayPalBundle\Structs\Subscription\Plan\BillingCycle\PricingScheme;
use SwagPaymentPayPalUnified\PayPalBundle\Structs\Subscription\Plan\BillingCycle\PricingScheme\FixedPrice;

class Shopware_Controllers_Backend_PaypalUnifiedSubscriptions extends \Shopware_Controllers_Backend_ExtJs
{
    public function createCatalogProductAction()
    {
        $this->registerShopResource();
        $productNumber = $this->Request()->get('productNumber');
        $productName = (string) $this->Request()->get('productName', '');
        $productType = (string) $this->Request()->get('productType', '');

        if (\strlen($productName) <= 1) {
            throw new RuntimeException('The product name must have at least a length of 1');
        }

        if (!\in_array($productType, CatalogProduct::TYPES, true)) {
            throw new RuntimeException('The given product type is not valid, must be one of: ' . \implode(', ', CatalogProduct::TYPES));
        }

        $catalogProduct = new CatalogProduct();
        $catalogProduct->setId($productNumber);
        $catalogProduct->setName($productName);
        $catalogProduct->setType($productType);

        $result = null;

        /** @var CatalogProductResource $catalogProductResource */
        $catalogProductResource = $this->get('paypal_unified.catalog_product_resource');
        try {
            $result = $catalogProductResource->create($catalogProduct);
        } catch (RequestException $e) {
            $error = \json_decode($e->getBody(), true);
            $throwError = true;
            if ($error['name'] === 'UNPROCESSABLE_ENTITY') {
                foreach ($error['details'] as $detail) {
                    if ($detail['field'] === '/id' && $detail['issue'] === 'DUPLICATE_RESOURCE_IDENTIFIER') {
                        $throwError = false;
                        break;
                    }
                }
            }

            if ($throwError) {
                throw $e;
            }
        }

        if ($result === null) {
            $result = $catalogProductResource->get($productNumber);
        }

        echo 'PaypalUnifiedSubscriptions.php Zeile: 28';
        echo '<pre>';
        \print_r($result);
        echo '</pre>';
        exit();
    }

    public function createPlanAction()
    {
        $this->registerShopResource();

        $fixedPrice = new FixedPrice();
        $fixedPrice->setCurrencyCode('EUR');
        $fixedPrice->setValue('100');

        $pricingScheme = new PricingScheme();
        $pricingScheme->setFixedPrice($fixedPrice);

        $frequency = new Frequency();
        $frequency->setIntervalUnit(Frequency::INTERVAL_UNIT_MONTH);

        $billingCycle = new BillingCycle();
        $billingCycle->setPricingScheme($pricingScheme);
        $billingCycle->setFrequency($frequency);
        $billingCycle->setSequence(1);
        $billingCycle->setTotalCycles(23);

        $paymentReferences = new Plan\PaymentPreferences();

        $plan = new Plan();
        $plan->setProductId('SW12345');
        $plan->setName('TestName');
        $plan->setBillingCycles([$billingCycle]);
        $plan->setPaymentPreferences($paymentReferences);

        /** @var PlanResource $planResource */
        $planResource = $this->get('paypal_unified.plan_resource');

        try {
            $result = $planResource->create($plan);
        } catch (RequestException $e) {
            $error = \json_decode($e->getBody(), true);

            echo 'PaypalUnifiedSubscriptions.php Zeile: 83';
            echo '<pre>';
            \print_r($error);
            echo '</pre>';
            exit();
//            echo 'PaypalUnifiedSubscriptions.php Zeile: 79';
//            echo '<pre>';
//            \Doctrine\Common\Util\Debug::dump($e);
//            echo '</pre>';
//            exit();
        }

        echo 'PaypalUnifiedSubscriptions.php Zeile: 78';
        echo '<pre>';
        \print_r($result);
        echo '</pre>';
        exit();
    }

    private function registerShopResource()
    {
        $shopId = (int) $this->Request()->getParam('shopId');
        /** @var ShopRepository $shopRepository */
        $shopRepository = $this->get('models')->getRepository(Shop::class);

        $shop = $shopRepository->getActiveById($shopId);
        if ($shop === null) {
            $shop = $shopRepository->getActiveDefault();
        }

        if ($this->container->has('shopware.components.shop_registration_service')) {
            $this->get('shopware.components.shop_registration_service')->registerResources($shop);
        } else {
            $shop->registerResources();
        }

        $this->get('paypal_unified.settings_service')->refreshDependencies();
    }
}
