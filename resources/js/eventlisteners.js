import { cart } from 'Vendor/rapidez/core/resources/js/stores/useCart';
import { addAfterPlaceOrderHandler } from 'Vendor/rapidez/core/resources/js/stores/usePaymentHandlers';

addAfterPlaceOrderHandler(async function (response, mutationComponent) {
    if (cart.value?.selected_payment_method?.code !== 'cvb') {
        return;
    }

    const redirectUrl = response?.data?.placeOrder?.orderV2?.cvb_redirect_url;

    if (!redirectUrl) {
        throw new Error('No bol.checkout redirect url returned for order ' + response?.data?.placeOrder?.orderV2?.number);
    }

    mutationComponent.redirect = redirectUrl;
    mutationComponent.redirectUrl = redirectUrl;
});
