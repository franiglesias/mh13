<?php
/**
 * Index.
 *
 * The Front Controller for handling every request
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         CakePHP(tm) v 0.2.9
 *
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

use Mh13\plugins\cantine\infrastructure\web\CantineProvider;
use Mh13\plugins\circulars\infrastructure\api\CircularController as ApiCircularController;
use Mh13\plugins\circulars\infrastructure\api\EventController as ApiEventController;
use Mh13\plugins\circulars\infrastructure\web\CircularProvider;
use Mh13\plugins\circulars\infrastructure\web\EventProvider;
use Mh13\plugins\contents\exceptions\ContentException;
use Mh13\plugins\contents\infrastructure\api\ArticleController as ApiArticleController;
use Mh13\plugins\contents\infrastructure\api\BlogController as ApiBlogController;
use Mh13\plugins\contents\infrastructure\web\ArticleProvider;
use Mh13\plugins\contents\infrastructure\web\BlogProvider;
use Mh13\plugins\contents\infrastructure\web\PageProvider;
use Mh13\plugins\contents\infrastructure\web\SiteProvider;
use Mh13\plugins\contents\infrastructure\web\StaticPageProvider;
use Mh13\plugins\contents\infrastructure\web\UiProvider;
use Mh13\plugins\uploads\infrastructure\web\UploadsProvider;
use Mh13\shared\CommandBus\TacticianServiceProvider;
use Mh13\shared\web\menus\MenuBarLoader;
use Mh13\shared\web\menus\MenuLoader;
use Mh13\shared\web\twig\Twig_Extension_Media;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;


error_reporting(E_ALL ^ E_STRICT ^ E_WARNING);

require_once(dirname(__DIR__).'/vendor/autoload.php');


/** @var $app */
$app = new \Silex\Application();

$app['debug'] = true;
$app['config.path'] = dirname(__DIR__).'/config/config.yml';

$config = Yaml::parse(file_get_contents(dirname(__DIR__).'/config/config.yml'));

/* Register service providers */

$app->register(new ServiceControllerServiceProvider());

$app->register(new TacticianServiceProvider());

$app->register(
    new Silex\Provider\TwigServiceProvider(),
    [
        'twig.path'    => __DIR__.'/../views',
        'twig.options' => [
            'auto_reload' => true,
            'cache'       => false,
            'debug'       => true,
        ],
    ]
);

$app->register(
    new DoctrineServiceProvider(),
    [
        'db.options' => $config['doctrine']['dbal']['connections'][$config['doctrine']['dbal']['default_connection']],
    ]
);


/* End of register service providers */

/* Service definitions */

$app['menu.loader'] = function ($app) {
    return new MenuLoader(dirname(__DIR__).'/config/menus.yml');
};

$app['bar.loader'] = function ($app) {
    return new MenuBarLoader(dirname(__DIR__).'/config/menus.yml');
};


$app['api.circular.controller'] = function ($app) {
    return new ApiCircularController($app['command.bus']);
};

$app['api.article.controller'] = function () use ($app) {
    return new ApiArticleController($app['command.bus'], $app['article.request.builder'], $app['article.service']);
};

$app['api.event.controller'] = function () use ($app) {
    return new ApiEventController($app['command.bus']);
};

$app['api.blog.controller'] = function () use ($app) {
    return new ApiBlogController($app['command.bus']);
};

$app->extend(
    'twig',
    function ($twig, $app) use ($config) {
        foreach ($config as $key => $value) {
            $twig->addGlobal($key, $config[$key]);
        }
        $twig->addGlobal('title_for_layout', 'Página principal');
        $twig->addGlobal('BaseUrl', '/');
        $twig->addExtension(new Twig_Extension_Debug());
        $twig->addExtension(new Twig_Extension_Media());

        return $twig;
    }
);

/* Error Handlers */

$app->error(
    function (ContentException $exception, Request $request, $code) use ($app) {

        return new Response(
            $app['twig']->render(
                'errors/404.twig',
                [
                    'url'     => $request->get('url'),
                    'message' => $exception->getMessage(),
                ]
            ), 404
        );
    }
);


/* Routes */

# API

$app->get('/api/articles', "api.article.controller:feed")->when(
    "request.headers.get('Accept') matches '/application\\\\/json/'"
)
;

$app->get('/api/events', "api.event.controller:last")->when(
    "request.headers.get('Accept') matches '/application\\\\/json/'"
)
;

$app->get('/api/circulars', "api.circular.controller:last");


$app->get('/api/blogs', 'api.blog.controller:public');

# /API

$app->mount('/site', new SiteProvider());
$app->mount('/static', new StaticPageProvider());
$app->mount('/circulars', new CircularProvider());
$app->mount('/uploads', new UploadsProvider());
$app->mount('/cantine', new CantineProvider());
$app->mount("/articles", new ArticleProvider());
$app->mount('/events', new EventProvider());
$app->mount('/page', new PageProvider());
$app->mount("/ui", new UiProvider());
$app->mount('/blog', new BlogProvider());

// Compatibility with old route scheme


$app->get('/{slug}', 'article.controller:view')->assert('slug', '\b(?!articles\b).*?\b');

// Default route renders home page
$app->get(
    '/',
    function () use ($app) {
        return $app['twig']->render('pages/home.twig');
    }
);

$app->run();
