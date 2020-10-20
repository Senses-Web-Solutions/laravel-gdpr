<?php

namespace Senses\Gdpr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Arr;

class GdprServiceProvider extends ServiceProvider 
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/gdpr.php' => config_path('gdpr.php'),
        ], 'gdpr');

        $this->mergeConfigFrom(__DIR__.'/../config/gdpr.php', 'gdpr');

        $this->app->resolving(EncryptCookies::class, function (EncryptCookies $encryptCookies) {
            $encryptCookies->disableFor(config('gdpr.cookie_name'));
        });


        Blade::if('gdpr', function($expression) {
            // If plugin is disabled, allow contents.
            return GdprFacade::allows($expression);
        });

        Blade::directive('gdprjs', function() {
            return "<?php echo view('gdpr::js')->render(); ?>";
        });

        View::addNamespace('gdpr', __DIR__.'/../resources/views');
    }

    public function register()
    {
        $this->app->bind('gdpr', function() {
            return new Gdpr();
        });
    }
}