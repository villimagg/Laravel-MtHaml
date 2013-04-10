<?php namespace Villimagg\LaravelMthaml;

/**
 * Based on Silex-Mthaml: https://github.com/arnaud-lb/Silex-MtHaml
 */

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;
use Villimagg\LaravelMtHaml\Lexer;
use MtHaml\Environment;
use MtHaml\Support\Twig\Extension;

class LaravelMthamlServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;
	
	public function boot()
	{
	    $this->package('villimagg/laravel-mthaml');
	}
	
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['mthaml'] = $this->app->share(function ($app) {
            return new Environment('twig', array(
                'enable_escaper' => false,
            ));
        });

        $this->app['mthaml.twig.extension'] = $this->app->share(function ($app) {
            return new Extension();
        });
        
        // This gives me error:
        // $this->app['twig'] = $this->app->share($this->app->extend('twig', function ($twig, $app) {
        //     $twig->addExtension($app['mthaml.twig.extension']);
        //     $lexer = new Lexer($app['mthaml'], $twig->getLexer());
        //     $twig->setLexer($lexer);
        //     return $twig;
        // }));
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}