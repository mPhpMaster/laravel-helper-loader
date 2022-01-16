<?php

namespace MPhpMaster\LaravelHelperLoader;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use MPhpMaster\LaravelHelperLoader\HelperLoader;

class HelperLoaderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @param Router $router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $configPath = __DIR__ . '/../config/helper-loader.php';
        if (function_exists('config_path')) {
            $publishPath = config_path('helper-loader.php');
        } else {
            $publishPath = base_path('config/helper-loader.php');
        }
        $this->publishes([$configPath => $publishPath], 'mphpmaster-configs');

//        $helpers_dir = __DIR__ . DIRECTORY_SEPARATOR . 'Helpers' . DIRECTORY_SEPARATOR;
//        HelperLoader::autoLoad($helpers_dir . 'src');
//        HelperLoader::autoLoad($helpers_dir . 'macro');
//        HelperLoader::autoLoad($helpers_dir . 'src-interfaces');
//        HelperLoader::autoLoad($helpers_dir . 'src-traits');
//        HelperLoader::autoLoad($helpers_dir . 'src-class');
        HelperLoader::autoLoad();
    }
}
