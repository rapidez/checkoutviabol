@extends('rapidez::layouts.app')

@section('title', __('Checkout'))

@section('robots', 'NOINDEX,NOFOLLOW')

@section('content')
    <div class="container">
        <checkout-via-bol-return cart-url="{{ route('cart') }}" v-slot="{ applying }">
            <div>
                <template v-if="applying">
                    @include('checkoutviabol::return.applying')
                </template>
                <graphql-mutation
                    v-else-if="hasCart"
                    :query="config.queries.placeOrder"
                    :variables="{ cart_id: mask }"
                    :before-request="handleBeforePlaceOrderHandlers"
                    :callback="handlePlaceOrder"
                    redirect="{{ route('checkout.success') }}"
                    v-slot="{ mutate }"
                >
                    <form v-cloak v-on:submit.prevent="(e) => submitPartials(e.target).then(mutate).catch()">
                        @include('checkoutviabol::return.content')
                    </form>
                </graphql-mutation>
            </div>
        </checkout-via-bol-return>
    </div>
@endsection
