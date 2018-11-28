<?php
namespace Skype;

use Illuminate\Support\ServiceProvider;

class SkypeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     * @return void
     */
    public function boot()
    {
//        if (is_dir(base_path().'/resources/views/box/Translates')) {
//            $this->loadViewsFrom(base_path().'/resources/views/box/Translates', 'Translates');
//        } else {
//            $this->loadViewsFrom(__DIR__.'/views', 'Translates');
//        }
//        $this->publishes([
//            __DIR__.'/views' => base_path('/resources/views/box/Translates'),
//        ]);
    }
    /**
     * Register services.
     * @return void
     */
    public function register()
    {

    }
}
