<script>
import { GraphQLError } from 'Vendor/rapidez/core/resources/js/fetch'
import { mask } from 'Vendor/rapidez/core/resources/js/stores/useMask'

export default {
    props: {
        cartUrl: {
            type: String,
            required: true,
        },
    },

    data: () => ({
        applying: true,
    }),

    render() {
        return this.$scopedSlots.default({
            applying: this.applying,
        })
    },

    async mounted() {
        const params = new URLSearchParams(window.location.search)

        if (!params.has('sid')) {
            this.applying = false
            return
        }

        if (params.get('session-result') !== 'SUCCESS') {
            window.Turbo.visit(this.cartUrl)
            return
        }

        try {
            const response = await window.magentoGraphQL(
                `mutation applyCvbSession($cart_id: String!, $session_id: String!, $nonce: String!) {
                    applyCvbSession(cart_id: $cart_id, session_id: $session_id, nonce: $nonce) { ...cart }
                }

                ` + window.config.fragments.cart,
                {
                    cart_id: mask.value,
                    session_id: params.get('sid'),
                    nonce: params.get('nonce'),
                },
                { retryOnCartError: false },
            )

            if (response.errors) {
                throw new GraphQLError(response.errors)
            }

            await this.updateCart({}, response)
            window.history.replaceState(window.history.state, '', window.location.pathname)
        } catch (error) {
            ;(error.errors ?? [{ message: window.config.translations.errors.wrong }]).forEach((error) => Notify(error.message, 'error'))
            window.Turbo.visit(this.cartUrl)
            return
        }

        this.applying = false
    },
}
</script>
