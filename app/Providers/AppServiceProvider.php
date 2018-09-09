<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Blade directive to dump template variables. Accepts single parameter
         * but also could be invoked without parameters to dump all defined variables.
         * It does not stop script execution.
         * @example @d
         * @example @d(auth()->user())
         */
        Blade::directive('d', function ($data) {
            return sprintf("<?php (new Illuminate\Support\Debug\Dumper)->dump(%s); ?>",
                null !== $data ? $data : "get_defined_vars()['__data']"
            );
        });
        /**
         * Blade directive to dump template variables. Accepts single parameter
         * but also could be invoked without parameters to dump all defined variables.
         * It works similar to dd() function and does stop script execution.
         * @example @dd
         * @example @dd(auth()->user())
         */
        Blade::directive('dd', function ($data) {
            return sprintf("<?php (new Illuminate\Support\Debug\Dumper)->dump(%s); exit; ?>",
                null !== $data ? $data : "get_defined_vars()['__data']"
            );
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
