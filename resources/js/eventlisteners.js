import { cart } from 'Vendor/rapidez/core/resources/js/stores/useCart';
import { addAfterPlaceOrderHandler } from 'Vendor/rapidez/core/resources/js/stores/usePaymentHandlers';

addAfterPlaceOrderHandler(async function (response, mutationComponent) {
    console.log(cart.value.selected_payment_method);
    if (cart.value?.selected_payment_method?.code !== 'cvb') {
        return;
    }

    const redirectUrl = response?.data?.placeOrder?.orderV2?.cvb_redirect_url;

    if (!redirectUrl) {
        throw new Error('No bol.checkout redirect url returned for order ' + response?.data?.placeOrder?.orderV2?.number);
    }

    console.log('setting redirect');
    mutationComponent.redirect = redirectUrl;
    console.log('setting redirect url');
    mutationComponent.redirectUrl = redirectUrl;
});
