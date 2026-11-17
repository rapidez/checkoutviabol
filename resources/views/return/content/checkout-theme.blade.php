<x-rapidez-ct::layout class="lg:items-end">
    <x-rapidez-ct::title>
        @lang('Shipping method')
    </x-rapidez-ct::title>
    <x-slot:sidebar class="max-lg:hidden">
        <a href="{{ url('/') }}" aria-label="@lang('Home')" class="*:h-auto *:max-h-20 *:w-full *:object-contain">
            <x-rapidez-ct::logo />
        </a>
    </x-slot:sidebar>
</x-rapidez-ct::layout>
<x-rapidez-ct::layout class="mt-5">
    <x-rapidez-ct::sections>
        <x-rapidez-ct::card.inactive>
            @include('rapidez-ct::checkout.partials.sections.shipping')
        </x-rapidez-ct::card.inactive>
    </x-rapidez-ct::sections>

    <x-rapidez-ct::toolbar>
        <x-rapidez::button.conversion type="submit" loader>
            @lang('Pay with Bol')
        </x-rapidez::button.conversion>
    </x-rapidez-ct::toolbar>
    <x-slot:sidebar>
        @include('rapidez-ct::checkout.partials.sidebar.sidebar')
    </x-slot:sidebar>
</x-rapidez-ct::layout>
