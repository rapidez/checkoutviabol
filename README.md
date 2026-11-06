# Rapidez checkoutviabol

Adds support for the bol.checkout (`cvb`) payment method to Rapidez.

## Requirements

- The [bol.checkout Magento 2 module](https://cvb.composer.bol.com/) (`bol/magento2-module-checkoutviabol`)
- The `checkoutviabol-graphql` module here: https://github.com/justbetter/magento2-module-checkoutviabol-graphql

## Installation

```bash
composer require rapidez/checkoutviabol
```

Publish the payment icon:

```bash
php artisan vendor:publish --provider="Rapidez\Checkoutviabol\CheckoutviabolServiceProvider" --tag=payment-icons
```

## bol urls

bol only receives paths (`/cvb/...`), the domain is configured on the bol merchant account. When that domain points to your Rapidez frontend, make sure `/cvb/*` is passed to Magento in your webserver config. For example, by adding `cvb` to the regex from the [Rapidez deployment docs](https://docs.rapidez.io/0.x/deployment.html#redirecting-magento-to-rapidez).

Magento needs these urls to be reachable:

```
[your base url]/cvb/order/verify?[...]
[your base url]/cvb/order/webhook?[...]
```

When the customer cancels or the payment fails, bol returns the customer to `/bol-return/cancel` on Rapidez, which reactivates the cart and redirects to the cart page. The order itself stays pending until bol or the Magento pending payment cleanup cancels it.

## Full checkout via bol

Guests can also fill in their details at bol. Add the `graphql-mutation` component where you want the button and put your own button in the slot. Call `mutate` to start the bol.checkout session, `running` is `true` while it starts:

```blade
<x-checkoutviabol::graphql-mutation>
    <x-rapidez::button.conversion type="button" v-on:click="mutate" v-bind:disabled="running">
        @lang('Checkout via bol')
    </x-rapidez::button.conversion>
</x-checkoutviabol::graphql-mutation>
```

Add `in-checkout` when you place it in the checkout instead of the cart, so bol knows where the customer started:

```blade
<x-checkoutviabol::graphql-mutation in-checkout>
    ...
</x-checkoutviabol::graphql-mutation>
```

The slot must have one root element. The component is only rendered for guests with items in their cart.

The bol.checkout logo is available as a component. It uses the current text color, so it can be styled with classes:

```blade
<x-checkoutviabol::graphql-mutation>
    <button type="button" class="rounded bg-[#0000A4] px-5 py-3 text-white" v-on:click="mutate" v-bind:disabled="running">
        <x-checkoutviabol::logo class="h-5 w-auto" />
    </button>
</x-checkoutviabol::graphql-mutation>
```

Configure these paths in Magento, in `Stores > Configuration > Sales > Payment Methods > Bol.checkout GraphQL`:

| Field                | Value                 |
| -------------------- | --------------------- |
| Checkout return path | `checkout/bol-return` |
| Cart path            | `cart`                |

After filling in the details at bol, the customer returns to `/checkout/bol-return`. This page fills the cart with the details from bol, selects the bol.checkout payment method and shows the shipping methods. The "Pay with bol" button places the order and redirects to bol for the payment.

The page uses the layout, cards, shipping and sidebar views of the [checkout theme](https://github.com/rapidez/checkout-theme) when it is installed, and the Rapidez core views when it is not. Each has its own content view, so override the one that your shop uses. For example, to change the pay button in a shop with the checkout theme, override `checkoutviabol::return.content.checkout-theme`.

| View                                            | Contents                                                                   |
| ----------------------------------------------- | -------------------------------------------------------------------------- |
| `checkoutviabol::return.content.checkout-theme` | The shipping methods, pay button and sidebar, with the checkout theme      |
| `checkoutviabol::return.content.core`           | The shipping methods, pay button and sidebar, without the checkout theme   |
| `checkoutviabol::return.content`                | Selects the content view                                                   |
| `checkoutviabol::return.applying`               | The loader while the bol details are applied                               |
| `checkoutviabol::return`                        | The page itself, with the place order mutation                             |

Publish the views to override them:

```bash
php artisan vendor:publish --provider="Rapidez\Checkoutviabol\CheckoutviabolServiceProvider" --tag=views
```

### Checkout layout

The Rapidez layout only shows the checkout header and footer on the `checkout` route. To show them on the return page too, add the `checkoutviabol.checkout` route to each `routeIs` check in your `rapidez::layouts.app` override:

```blade
@includeWhen(request()->routeIs('checkout', 'checkoutviabol.checkout'), 'rapidez::layouts.checkout.header')
```

## License

GNU General Public License v3. Please see [License File](LICENSE) for more information.
