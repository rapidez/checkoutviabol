<div class="flex gap-10 max-xl:flex-col">
    <div class="flex w-full flex-col gap-5 xl:w-3/4">
        @include('rapidez::checkout.steps.shipping-method')

        <x-rapidez::button.conversion type="submit" class="self-start" loader>
            @lang('Pay with Bol')
        </x-rapidez::button.conversion>
    </div>
    <div class="w-full xl:w-1/4">
        @include('rapidez::checkout.partials.sidebar')
    </div>
</div>
