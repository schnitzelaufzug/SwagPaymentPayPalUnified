;(function($, window) {
    'use strict';

    $.plugin('swagPayPalUnifiedInContextCheckout', {
        defaults: {
            /**
             * label of the button
             * possible values:
             *  - buynow
             *  - checkout
             *  - credit
             *  - pay
             *
             * @type string
             */
            label: 'buynow',

            /**
             * show text under the button
             *
             * @type boolean
             */
            tagline: false,

            /**
             * size of the button
             * possible values:
             *  - small
             *  - medium
             *  - large
             *  - responsive
             *
             * @type string
             */
            size: 'medium',

            /**
             * shape of the button
             * possible values:
             *  - pill
             *  - rect
             *
             * @type string
             */
            shape: 'rect',

            /**
             * color of the button
             * possible values:
             *  - gold
             *  - blue
             *  - silver
             *  - black
             *
             * @type string
             */
            color: 'gold',

            /**
             * The language ISO (ISO_639) locale of the button.
             *
             * for possible values see: https://developer.paypal.com/api/rest/reference/locale-codes/
             *
             * @type string
             */
            locale: '',

            /**
             *  @type string
             */
            layout: 'vertical',

            /**
             * selector for the checkout confirm form element
             *
             * @type string
             */
            confirmFormSelector: '#confirm--form',

            /**
             * selector for the submit button of the checkout confirm form
             *
             * @type string
             */
            confirmFormSubmitButtonSelector: ':submit[form="confirm--form"]',

            /**
             * The selector for the indicator whether the PayPal javascript is already loaded or not
             *
             * @type string
             */
            paypalScriptLoadedSelector: 'paypal-checkout-js-loaded',

            /**
             * This page will be opened when the payment creation fails.
             *
             * @type string
             */
            paypalErrorPage: '',

            /**
             * This page will be opened when the payment creation fails.
             *
             * @type string
             */
            currency: 'EUR',

            /**
             * The PayPal clientId
             *
             * @type string|null
             */
            clientId: null,

            /**
             * @type string
             */
            sdkUrl: 'https://www.paypal.com/sdk/js',

            /**
             * @type string
             */
            createOrderUrl: '',

            /**
             * @type string
             */
            confirmUrl: '',

            /**
             * @type string
             */
            finishUrl: '',

            /**
             * Use PayPal debug mode
             *
             * @type boolean
             */
            useDebugMode: false,

            /**
             * Commit the order number to PayPal
             *
             * @type boolean
             */
            commitOrdernumber: false,

            /**
             * @type string
             */
            paypalIntent: 'capture',

            /**
             * PayPal button height small
             *
             * @type number
             */
            smallHeight: 25,

            /**
             * PayPal button height medium
             *
             * @type number
             */
            mediumHeight: 35,

            /**
             * PayPal button height large
             *
             * @type number
             */
            largeHeight: 45,

            /**
             * PayPal button height responsive
             *
             * @type number
             */
            responsiveHeight: 55,

            /**
             * PayPal button width small
             *
             * @type string
             */
            smallWidthClass: 'paypal-button-width--small',

            /**
             * PayPal button width medium
             *
             * @type string
             */
            mediumWidthClass: 'paypal-button-width--medium',

            /**
             * PayPal button width large
             *
             * @type string
             */
            largeWidthClass: 'paypal-button-width--large',

            /**
             * PayPal button width responsive
             *
             * @type string
             */
            responsiveWidthClass: 'paypal-button-width--responsive',

            /**
             * For possible values see: https://developer.paypal.com/sdk/js/configuration/#disable-funding
             *
             * @type string
             */
            disabledFundings: 'card,bancontact,blik,eps,giropay,ideal,mercadopago,mybank,p24,sepa,sofort,venmo',

            /**
             * For possible values see: https://developer.paypal.com/sdk/js/configuration/#enable-funding
             *
             * @type string
             */
            enabledFundings: 'paylater'
        },

        /**
         * @type { Object }
         */
        inContextCheckoutButton: null,

        init: function() {
            this.applyDataAttributes();

            this.$form = $(this.opts.confirmFormSelector);
            this.hideConfirmButton();
            this.disableConfirmButton();

            this.createButtonSizeObject();

            this.$el.addClass(this.buttonSize[this.opts.size].widthClass);

            this.createButton();

            $.publish('plugin/swagPayPalUnifiedInContextCheckout/init', this);
        },

        createButtonSizeObject: function () {
            this.buttonSize = {
                small: {
                    height: this.opts.smallHeight,
                    widthClass: this.opts.smallWidthClass
                },
                medium: {
                    height: this.opts.mediumHeight,
                    widthClass: this.opts.mediumWidthClass
                },
                large: {
                    height: this.opts.largeHeight,
                    widthClass: this.opts.largeWidthClass
                },
                responsive: {
                    height: this.opts.responsiveHeight,
                    widthClass: this.opts.responsiveWidthClass
                }
            };
        },

        /**
         * Hides the confirm button
         * It should not be removed completely from the DOM, because is used to trigger HTML5 form validation
         */
        hideConfirmButton: function() {
            var me = this;

            me.$confirmButton = $(me.opts.confirmFormSubmitButtonSelector);
            me.$confirmButton.addClass('is--hidden');

            $.publish('plugin/swagPayPalUnifiedInContextCheckout/hideConfirmButton', [me, me.$confirmButton]);
        },

        /**
         * Disables the submit function, because in some browsers the submit event is triggered,
         * even though the form is not valid
         */
        disableConfirmButton: function() {
            var me = this;

            me._on(me.$form, 'submit', $.proxy(me.onConfirmCheckout, me));
        },

        /**
         * @param { Event } event
         */
        onConfirmCheckout: function(event) {
            event.preventDefault();
        },

        /**
         * Creates the PayPal in-context button with the loaded PayPal javascript
         */
        createButton: function() {
            var me = this,
                $head = $('head');

            if (!$head.hasClass(this.opts.paypalScriptLoadedSelector)) {
                $.ajax({
                    url: this.renderSdkUrl(),
                    dataType: 'script',
                    cache: true,
                    success: function() {
                        $head.addClass(me.opts.paypalScriptLoadedSelector);
                        me.paypal = window.paypal;
                        me.renderButton();
                    }
                });
            } else {
                this.paypal = window.paypal;
                this.renderButton();
            }
        },

        renderSdkUrl: function() {
            var params = {
                'client-id': this.opts.clientId,
                'disable-funding': this.opts.disabledFundings,
                'enable-funding': this.opts.enabledFundings,
                intent: this.opts.paypalIntent.toLowerCase()
            };

            if (this.opts.locale.length > 0) {
                params.locale = this.opts.locale;
            }

            if (this.opts.useDebugMode) {
                params.debug = true;
            }

            if (this.opts.currency) {
                params.currency = this.opts.currency;
            }

            return [this.opts.sdkUrl, '?', $.param(params, true)].join('');
        },

        /**
         * Renders the ECS button
         */
        renderButton: function() {
            var me = this,
                buttonConfig = me.getButtonConfig(),
                el = me.$el.get(0);

            me.paypal.Buttons(buttonConfig).render(el);
        },

        /**
         * Creates the configuration for the button
         *
         * @return { Object }
         */
        getButtonConfig: function() {
            var buttonConfig = {
                style: {
                    label: this.opts.label,
                    color: this.opts.color,
                    shape: this.opts.shape,
                    layout: this.opts.layout,
                    tagline: this.opts.tagline,
                    height: this.buttonSize[this.opts.size].height
                },

                /**
                 * Will be called after payment button is clicked
                 */
                createOrder: this.createOrder.bind(this),

                /**
                 * Will be called if the payment process is approved by PayPal
                 */
                onApprove: this.onApprove.bind(this),

                /**
                 * Will be called if the payment process is cancelled by the customer
                 */
                onCancel: this.onCancel.bind(this),

                /**
                 * Will be called if any api error occurred
                 */
                onError: this.onPayPalAPIError.bind(this)
            };

            $.publish('plugin/swagPayPalUnifiedInContextCheckout/createConfig', [this, buttonConfig]);

            return buttonConfig;
        },

        /**
         * @return { Promise }
         */
        createOrder: function() {
            var me = this;

            return $.ajax({
                method: 'get',
                url: me.opts.createOrderUrl
            }).then(function(response) {
                me.opts.basketId = response.basketId;

                return response.paypalOrderId;
            }, function() {
            }).promise();
        },

        /**
         * @return { Promise }
         */
        onApprove: function(data, actions) {
            var me = this;

            $.loadingIndicator.open({
                openOverlay: true,
                closeOnClick: false,
                theme: 'light'
            });

            return actions.redirect(me.renderConfirmUrl(data));
        },

        /**
         * @param data { Object }
         *
         * @return { string }
         */
        renderConfirmUrl: function(data) {
            var params = $.param({
                paypalOrderId: data.orderID,
                payerId: data.payerID,
                basketId: this.opts.basketId
            }, true);

            return [this.opts.confirmUrl, '?', params].join('');
        },

        onCancel: function() {
            $.loadingIndicator.close();
        },

        /**
         * validates the checkout confirm form
         *
         * @return { boolean }
         */
        checkFormValidity: function() {
            var me = this,
                form = me.$form.get(0),
                isFormValid = form.checkValidity();

            $.publish('plugin/swagPayPalUnifiedInContextCheckout/checkFormValidity', [me, isFormValid, me.$form]);

            return isFormValid;
        },

        onPayPalAPIError: function() {
            window.location.replace(this.opts.paypalErrorPage);
        }
    });

    window.StateManager.addPlugin('*[data-paypalUnifiedNormalCheckoutButtonInContext="true"]', 'swagPayPalUnifiedInContextCheckout');
})(jQuery, window);
