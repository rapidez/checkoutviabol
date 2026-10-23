<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    Route::get('bol-return/cancel', function (Request $request) {
        if ($mask = $request->cookie('mask')) {
            config('rapidez.models.quote')::query()
                ->withoutGlobalScopes()
                ->whereQuoteIdOrCustomerToken($mask)
                ->update(['is_active' => 1]);
        }

        return redirect('cart');
    })->name('checkoutviabol.cancel');
});
