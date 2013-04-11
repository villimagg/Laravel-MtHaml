<?php namespace Villimagg\LaravelMthaml;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

use Symfony\Bridge\Twig\Extension\RoutingExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\SecurityExtension;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Bridge\Twig\Form\TwigRenderer;

/**
 * Twig integration for Silex.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class TwigServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app['twig.options'] = array();
        $this->app['twig.form.templates'] = array('form_div_layout.html.twig');
        $this->app['twig.path'] = array();
        $this->app['twig.templates'] = array();

        $this->app['twig'] = $this->app->share(function ($app) {
            $app['twig.options'] = array_replace(
                array(
                    // 'charset'          => $this->app['charset'],
                    // 'debug'            => $this->app['debug'],
                    // 'strict_variables' => $this->app['debug'],
                ), $app['twig.options']
            );

            $twig = new \Twig_Environment($this->app['twig.loader'], $this->app['twig.options']);
            $twig->addGlobal('app', $this->app);
            // $twig->addExtension(new TwigCoreExtension());

            // if ($this->app['debug']) {
            //     $twig->addExtension(new \Twig_Extension_Debug());
            // }

            // if (class_exists('Symfony\Bridge\Twig\Extension\RoutingExtension')) {
            //     if (isset($app['url_generator'])) {
            //         $twig->addExtension(new RoutingExtension($app['url_generator']));
            //     }

            //     if (isset($app['translator'])) {
            //         $twig->addExtension(new TranslationExtension($app['translator']));
            //     }

            //     if (isset($app['security'])) {
            //         $twig->addExtension(new SecurityExtension($app['security']));
            //     }

            //     if (isset($app['form.factory'])) {
            //         $app['twig.form.engine'] = $app->share(function ($app) {
            //             return new TwigRendererEngine($app['twig.form.templates']);
            //         });

            //         $app['twig.form.renderer'] = $app->share(function ($app) {
            //             return new TwigRenderer($app['twig.form.engine'], $app['form.csrf_provider']);
            //         });

            //         $twig->addExtension(new FormExtension($app['twig.form.renderer']));

            //         // add loader for Symfony built-in form templates
            //         $reflected = new \ReflectionClass('Symfony\Bridge\Twig\Extension\FormExtension');
            //         $path = dirname($reflected->getFileName()).'/../Resources/views/Form';
            //         $app['twig.loader']->addLoader(new \Twig_Loader_Filesystem($path));
            //     }
            // }

            return $twig;
        });

        $this->app['twig.loader.filesystem'] = $this->app->share(function ($app) {
            return new \Twig_Loader_Filesystem($app['twig.path']);
        });

        $this->app['twig.loader.array'] = $this->app->share(function ($app) {
            return new \Twig_Loader_Array($app['twig.templates']);
        });

        $this->app['twig.loader'] = $this->app->share(function ($app) {
            return new \Twig_Loader_Chain(array(
                $app['twig.loader.array'],
                $app['twig.loader.filesystem'],
            ));
        });
    }

    public function boot()
    {
    }
}