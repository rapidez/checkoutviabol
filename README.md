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

## License

GNU General Public License v3. Please see [License File](LICENSE) for more information.
