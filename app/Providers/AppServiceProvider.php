<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        Blade::directive("colorAprobado", function ($value){
                return "<?php if($value < 4): ?>
                            <span class='text-danger bg-white p-1'><?php echo $value ?></span>
                        <?php else: ?>
                            <span class='text-success bg-white p-1'><?php echo $value ?></span>
                        <?php endif; ?>";
                     });
        Blade::directive("classAprobado", function ($value){
                return "<?php if($value < 4): ?>
                            text-danger
                        <?php else: ?>
                            text-success
                        <?php endif; ?>";
                     });
    }
}
