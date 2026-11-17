@props(['inCheckout' => false])

<graphql-mutation
    query="mutation startCvbCheckout($cart_id: String!, $action_identifier: Int) { startCvbCheckout(cart_id: $cart_id, action_identifier: $action_identifier) }"
    :variables="{ cart_id: mask, action_identifier: {{ $inCheckout ? 2 : 1 }} }"
    :callback="(variables, response) => window.location.href = response.data.startCvbCheckout"
    v-if="!$root.loggedIn && $root.hasCart"
    v-slot="{ mutate, running }"
    v-cloak
>
    {{ $slot }}
</graphql-mutation>
