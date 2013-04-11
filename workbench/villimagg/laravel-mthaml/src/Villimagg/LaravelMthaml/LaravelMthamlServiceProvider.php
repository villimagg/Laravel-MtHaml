<?php namespace Villimagg\LaravelMthaml;

/**
 * Based on Silex-Mthaml: https://github.com/arnaud-lb/Silex-MtHaml
 */

use Illuminate\Support\ServiceProvider;
use Villimagg\LaravelMtHaml\Lexer;
use Illuminate\Foundation\Application;
use Illuminate\View\Engines\CompilerEngine;
use MtHaml\Environment;
use MtHaml\Support\Twig\Extension;

class LaravelMthamlServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;
	
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['mthaml'] = $this->app->share(function ($app) {
            return new Environment('php');
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
	
	public function boot()
	{
		$app = $this->app;

		$app['view.engine.resolver']->register('mthaml', function() use ($app)
		// $app['view.engine.resolver']->register('twig', function() use ($app)
		{
			$cache = $app['path.storage'].'/views';

			$compiler = new HamlCompiler($app['files'], $cache);
			// $compiler->setEnvironment($app['twig']);
			$compiler->setEnvironment($app['mthaml']);

			return new CompilerEngine($compiler, $app['files']);
		});

		$app['view']->addExtension('haml.php', 'mthaml');
		// $app['view']->addExtension('twig.haml', 'twig');
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