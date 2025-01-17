describe('Express checkout button tests', function() {
    it('isProductExcluded with productNumber null', function() {
        var $testElement, data, html;

        html = '<div data-paypalUnifiedEcButton="true"></div>';

        $testElement = jQuery(html).appendTo(jQuery('body')).swagPayPalUnifiedExpressCheckoutButton();
        data = $testElement.data('plugin_swagPayPalUnifiedExpressCheckoutButton');

        expect(data._name).toMatch('swagPayPalUnifiedExpressCheckoutButton');

        expect(data.isProductExcluded()).toBeFalsy();
    });

    it('isProductExcluded with productNumber empty string', function() {
        var $testElement, data, html;

        html = '<div data-paypalUnifiedEcButton="true"' +
                ' data-productNumber' +
            '></div>';

        $testElement = jQuery(html).appendTo(jQuery('body')).swagPayPalUnifiedExpressCheckoutButton();
        data = $testElement.data('plugin_swagPayPalUnifiedExpressCheckoutButton');

        expect(data._name).toMatch('swagPayPalUnifiedExpressCheckoutButton');

        expect(data.isProductExcluded()).toBeFalsy();
    });

    it('isProductExcluded with productNumber and with riskManagementMatchedProducts null and with esdProducts null', function() {
        var $testElement, data, html;

        html = '<div data-paypalUnifiedEcButton="true"' +
            ' data-productNumber="SW100"' +
            '></div>';

        $testElement = jQuery(html).appendTo(jQuery('body')).swagPayPalUnifiedExpressCheckoutButton();
        data = $testElement.data('plugin_swagPayPalUnifiedExpressCheckoutButton');

        expect(data._name).toMatch('swagPayPalUnifiedExpressCheckoutButton');

        expect(data.isProductExcluded()).toBeFalsy();
    });

    it('isProductExcluded with productNumber and with riskManagementMatchedProducts empty string', function() {
        var $testElement, data, html;

        html = '<div data-paypalUnifiedEcButton="true"' +
            ' data-productNumber="SW100"' +
            ' data-riskManagementMatchedProducts' +
            '></div>';

        $testElement = jQuery(html).appendTo(jQuery('body')).swagPayPalUnifiedExpressCheckoutButton();
        data = $testElement.data('plugin_swagPayPalUnifiedExpressCheckoutButton');

        expect(data._name).toMatch('swagPayPalUnifiedExpressCheckoutButton');

        expect(data.isProductExcluded()).toBeFalsy();
    });

    it('isProductExcluded with productNumber and with riskManagementMatchedProducts', function() {
        var $testElement, data, html;

        html = '<div data-paypalUnifiedEcButton="true"' +
            ' data-productNumber="SW100"' +
            " data-riskManagementMatchedProducts='[\"SW100\"]'" +
            '></div>';

        $testElement = jQuery(html).appendTo(jQuery('body')).swagPayPalUnifiedExpressCheckoutButton();
        data = $testElement.data('plugin_swagPayPalUnifiedExpressCheckoutButton');

        expect(data._name).toMatch('swagPayPalUnifiedExpressCheckoutButton');

        expect(data.isProductExcluded()).toBeTruthy();
    });

    it('isProductExcluded with productNumber and with esdProducts empty string', function() {
        var $testElement, data, html;

        html = '<div data-paypalUnifiedEcButton="true"' +
            ' data-productNumber="SW100"' +
            ' data-esdProducts' +
            '></div>';

        $testElement = jQuery(html).appendTo(jQuery('body')).swagPayPalUnifiedExpressCheckoutButton();
        data = $testElement.data('plugin_swagPayPalUnifiedExpressCheckoutButton');

        expect(data._name).toMatch('swagPayPalUnifiedExpressCheckoutButton');

        expect(data.isProductExcluded()).toBeFalsy();
    });

    it('isProductExcluded with productNumber and with esdProducts', function() {
        var $testElement, data, html;

        html = '<div data-paypalUnifiedEcButton="true"' +
            ' data-productNumber="SW100"' +
            " data-esdProducts='[\"SW100\"]'" +
            '></div>';

        $testElement = jQuery(html).appendTo(jQuery('body')).swagPayPalUnifiedExpressCheckoutButton();
        data = $testElement.data('plugin_swagPayPalUnifiedExpressCheckoutButton');

        expect(data._name).toMatch('swagPayPalUnifiedExpressCheckoutButton');

        expect(data.isProductExcluded()).toBeTruthy();
    });

    it('isProductExcluded with productNumber and with matching riskManagementMatchedProducts and with esdProducts', function() {
        var $testElement, data, html;

        html = '<div data-paypalUnifiedEcButton="true"' +
            ' data-productNumber="SW100"' +
            " data-esdProducts='[\"SW101\"]'" +
            " data-riskManagementMatchedProducts='[\"SW100\"]'" +
            '></div>';

        $testElement = jQuery(html).appendTo(jQuery('body')).swagPayPalUnifiedExpressCheckoutButton();
        data = $testElement.data('plugin_swagPayPalUnifiedExpressCheckoutButton');

        expect(data._name).toMatch('swagPayPalUnifiedExpressCheckoutButton');

        expect(data.isProductExcluded()).toBeTruthy();
    });

    it('isProductExcluded with productNumber and with riskManagementMatchedProducts and with matching esdProducts', function() {
        var $testElement, data, html;

        html = '<div data-paypalUnifiedEcButton="true"' +
            ' data-productNumber="SW100"' +
            " data-esdProducts='[\"SW100\"]'" +
            " data-riskManagementMatchedProducts='[\"SW101\"]'" +
            '></div>';

        $testElement = jQuery(html).appendTo(jQuery('body')).swagPayPalUnifiedExpressCheckoutButton();
        data = $testElement.data('plugin_swagPayPalUnifiedExpressCheckoutButton');

        expect(data._name).toMatch('swagPayPalUnifiedExpressCheckoutButton');

        expect(data.isProductExcluded()).toBeTruthy();
    });
});
