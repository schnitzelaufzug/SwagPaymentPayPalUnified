{block name='frontend_checkout_confirm_paypal_unified_ec_inputs'}
    {block name='frontend_checkout_confirm_paypal_unified_spb_inputs_is_spb_checkout'}
        <input type="hidden" value="{$paypalUnifiedSpbCheckout}" name="spbCheckout">
        <input type="hidden" value="{$paypalUnifiedAdvancedCreditDebitCardCheckout}" name="acdcCheckout">
        <input type="hidden" value="{$paypalUnifiedAdvancedSepaCheckout}" name="sepaCheckout">
    {/block}

    {block name='frontend_checkout_confirm_paypal_unified_spb_inputs_order_id'}
        <input type="hidden" value="{$paypalUnifiedSpbOrderId}" name="paypalOrderId">
    {/block}

    {block name='frontend_checkout_confirm_paypal_unified_spb_inputs_payer_id'}
        <input type="hidden" value="{$paypalUnifiedSpbPayerId}" name="payerId">
    {/block}

    {block name='frontend_checkout_confirm_paypal_unified_spb_inputs_basket_id'}
        <input type="hidden" value="{$paypalUnifiedSpbBasketId}" name="basketId">
    {/block}
{/block}
