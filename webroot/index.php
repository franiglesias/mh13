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

use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\Locator\InMemoryLocator;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;
use Mh13\plugins\cantine\application\GetMenuForDay;
use Mh13\plugins\cantine\application\GetMenuForDayHandler;
use Mh13\plugins\cantine\application\GetMenuForMonth;
use Mh13\plugins\cantine\application\GetMenuForMonthHandler;
use Mh13\plugins\cantine\application\GetMenuForWeek;
use Mh13\plugins\cantine\application\GetMenuForWeekHandler;
use Mh13\plugins\cantine\infrastructure\persistence\dbal\DBalCantineReadModel;
use Mh13\plugins\cantine\infrastructure\web\CantineController;
use Mh13\plugins\cantine\infrastructure\web\CantineProvider;
use Mh13\plugins\circulars\application\circular\GetCircular;
use Mh13\plugins\circulars\application\circular\GetCircularHandler;
use Mh13\plugins\circulars\application\circular\GetLastCirculars;
use Mh13\plugins\circulars\application\circular\GetLastCircularsHandler;
use Mh13\plugins\circulars\application\event\GetLastEvents;
use Mh13\plugins\circulars\application\event\GetLastEventsHandler;
use Mh13\plugins\circulars\infrastructure\api\CircularController as ApiCircularController;
use Mh13\plugins\circulars\infrastructure\api\EventController as ApiEventController;
use Mh13\plugins\circulars\infrastructure\persistence\dbal\DBalCircularReadModel;
use Mh13\plugins\circulars\infrastructure\persistence\dbal\DBalEventReadModel;
use Mh13\plugins\circulars\infrastructure\web\CircularController;
use Mh13\plugins\circulars\infrastructure\web\EventController;
use Mh13\plugins\contents\application\service\article\ArticleRequestBuilder;
use Mh13\plugins\contents\application\service\ArticleService;
use Mh13\plugins\contents\application\service\BlogService;
use Mh13\plugins\contents\application\service\SiteService;
use Mh13\plugins\contents\application\service\StaticPageService;
use Mh13\plugins\contents\application\service\upload\UploadContextFactory;
use Mh13\plugins\contents\application\service\UploadService;
use Mh13\plugins\contents\exceptions\ContentException;
use Mh13\plugins\contents\infrastructure\api\ArticleController as ApiArticleController;
use Mh13\plugins\contents\infrastructure\persistence\dbal\article\DBalArticleReadModel;
use Mh13\plugins\contents\infrastructure\persistence\dbal\article\DbalArticleRepository;
use Mh13\plugins\contents\infrastructure\persistence\dbal\article\DBalArticleSpecificationFactory;
use Mh13\plugins\contents\infrastructure\persistence\dbal\blog\DbalBlogReadModel;
use Mh13\plugins\contents\infrastructure\persistence\dbal\blog\DbalBlogSpecificationFactory;
use Mh13\plugins\contents\infrastructure\persistence\dbal\staticpage\DbalStaticPageReadModel;
use Mh13\plugins\contents\infrastructure\persistence\dbal\staticpage\DbalStaticPageRelatedFinderFactory;
use Mh13\plugins\contents\infrastructure\persistence\dbal\staticpage\DbalStaticPageSpecificationFactory;
use Mh13\plugins\contents\infrastructure\persistence\dbal\upload\DbalUploadReadModel;
use Mh13\plugins\contents\infrastructure\persistence\dbal\upload\DbalUploadSpecificationFactory;
use Mh13\plugins\contents\infrastructure\persistence\filesystem\FSSiteReadModel;
use Mh13\plugins\contents\infrastructure\web\ArticleController;
use Mh13\plugins\contents\infrastructure\web\ArticleProvider;
use Mh13\plugins\contents\infrastructure\web\BlogController;
use Mh13\plugins\contents\infrastructure\web\PageController;
use Mh13\plugins\contents\infrastructure\web\SiteController;
use Mh13\plugins\contents\infrastructure\web\StaticPageController;
use Mh13\plugins\contents\infrastructure\web\UiProvider;
use Mh13\plugins\uploads\infrastructure\web\UploadsProvider;
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

//require_once('cakeindex.php');
//require_once(dirname(__DIR__).'/plugins/contents/models/item.php');
//require_once(dirname(__DIR__).'/config/mh13.php');

$config = Yaml::parse(file_get_contents(dirname(__DIR__).'/config/config.yml'));

/** @var $app */
$app = new \Silex\Application();

$app['debug'] = true;

/* Register service providers */

$app->register(new ServiceControllerServiceProvider());


$app->register(
    new Silex\Provider\TwigServiceProvider(),
    [
        'twig.path' => __DIR__.'/../views',
        'twig.options' => [
            'auto_reload' => true,
            'cache' => false,
            'debug' => true,
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


$app['site.readmodel'] = function ($app) {
    return new FSSiteReadModel(dirname(__DIR__).'/config/config.yml');
};

$app['site.service'] = function ($app) {
    return new SiteService($app['site.readmodel']);
};

$app['article.request.builder'] = function ($app) {
    return new ArticleRequestBuilder($app['site.service']);
};

$app['article.specification.factory'] = function ($app) {
    return new DBalArticleSpecificationFactory($app['db']);
};

$app['article.repository'] = function ($app) {
    return new DbalArticleRepository($app['db']);
};

$app['article.readmodel'] = function ($app) {
    return new DBalArticleReadModel($app['db']);
};

$app['article.service'] = function ($app) {
    return new ArticleService($app['article.readmodel'], $app['article.specification.factory']);
};

$app['staticpage.readmodel'] = function ($app) {
    return new DbalStaticPageReadModel($app['db']);
};

$app['staticpage.specification.factory'] = function ($app) {
    return new DbalStaticPageSpecificationFactory($app['db']);
};

$app['staticpage.relatedquery.factory'] = function ($app) {
    return new DbalStaticPageRelatedFinderFactory($app['db']);
};

$app['staticpage.service'] = function ($app) {
    return new StaticPageService(
        $app['staticpage.readmodel'],
        $app['staticpage.specification.factory'],
        $app['staticpage.relatedquery.factory']
    );
};

$app['upload.readmodel'] = function ($app) {
    return new DbalUploadReadModel($app['db']);
};

$app['upload.specification.factory'] = function ($app) {
    return new DbalUploadSpecificationFactory();
};

$app['upload.context.factory'] = function ($app) {
    return new UploadContextFactory();
};

$app['upload.service'] = function ($app) {
    return new UploadService(
        $app['upload.readmodel'],
        $app['upload.specification.factory'],
        $app['upload.context.factory']
    );
};

$app['blog.specification.factory'] = function ($app) {
    return new DBalBlogSpecificationFactory();
};

$app['blog.readmodel'] = function ($app) {
    return new DbalBlogReadModel($app['db']);
};

$app['blog.service'] = function ($app) {
    return new BlogService($app['blog.readmodel'], $app['blog.specification.factory']);
};

$app['cantine.readmodel'] = function ($app) {
    return new DBalCantineReadModel($app['db']);
};

$app['cantine.controller'] = function ($app) {
    return new CantineController($app['cantine.readmodel'], $app['command.bus'], $app['twig']);
};

$app['event.readmodel'] = function ($app) {
    return new DBalEventReadModel($app['db']);
};

$app['circular.readmodel'] = function ($app) {
    return new DBalCircularReadModel($app['db']);
};



$app['circular.controller'] = function ($app) {
    return new CircularController($app['command.bus'], $app['twig']);
};


$app[GetLastCircularsHandler::class] = function ($app) {
    return new GetLastCircularsHandler($app['circular.readmodel']);
};

$app[GetCircularHandler::class] = function ($app) {
    return new GetCircularHandler($app['circular.readmodel']);
};

$app[GetLastEventsHandler::class] = function ($app) {
    return new GetLastEventsHandler($app['event.readmodel']);
};

$app['api.circular.controller'] = function ($app) {
    return new ApiCircularController($app['command.bus']);
};

# CANTINE

$app[GetMenuForDayHandler::class] = function ($app) {
    return new GetMenuForDayHandler($app['cantine.readmodel']);
};

$app[GetMenuForWeekHandler::class] = function ($app) {
    return new GetMenuForWeekHandler($app['cantine.readmodel']);
};

$app[GetMenuForMonthHandler::class] = function ($app) {
    return new GetMenuForMonthHandler($app['cantine.readmodel']);
};

/* End of service definitions */

/* Tactician Command Bus */


$app['command.bus'] = function ($app) {
    // Choose our method name
    $inflector = new HandleInflector();

// Choose our locator and register our command
    $locator = new InMemoryLocator();
    $locator->addHandler($app[GetLastCircularsHandler::class], GetLastCirculars::class);
    $locator->addHandler($app[GetCircularHandler::class], GetCircular::class);
    $locator->addHandler($app[GetLastEventsHandler::class], GetLastEvents::class);
    $locator->addHandler($app[GetMenuForDayHandler::class], GetMenuForDay::class);
    $locator->addHandler($app[GetMenuForWeekHandler::class], GetMenuForWeek::class);
    $locator->addHandler($app[GetMenuForMonthHandler::class], GetMenuForMonth::class);

// Choose our Handler naming strategy
    $nameExtractor = new ClassNameExtractor();

// Create the middleware that executes commands with Handlers
    $commandHandlerMiddleware = new CommandHandlerMiddleware($nameExtractor, $locator, $inflector);

// Create the command bus, with a list of middleware
    return new CommandBus([$commandHandlerMiddleware]);
};

/*  */
$app['api.article.controller'] = function () use ($app) {
    return new ApiArticleController($app['article.request.builder'], $app['article.service']);
};

$app['event.controller'] = function () use ($app) {
    return new EventController($app['command.bus'], $app['twig']);
};

$app['api.event.controller'] = function () use ($app) {
    return new ApiEventController($app['command.bus']);
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
                    'url' => $request->get('url'),
                    'message' => $exception->getMessage(),
                ]
            ), 404
        );

    }
);


/* Routes */

$app->get('/circulars/last', "circular.controller:last");
$app->get('/circulars/view/{id}', "circular.controller:view");

$app->get('/api/articles', "api.article.controller:feed")->when(
    "request.headers.get('Accept') matches '/application\\\\/json/'"
)
;

$app->get('/api/events', "api.event.controller:last")->when(
    "request.headers.get('Accept') matches '/application\\\\/json/'"
)
;

$app->get('/api/circulars', "api.circular.controller:last");


$app->mount('/uploads', new UploadsProvider());
$app->mount('/cantine', new CantineProvider());
$app->mount("/articles", new ArticleProvider());
$app->mount("/ui", new UiProvider());

$app->get('/events/last', 'event.controller:last');

// Compatibility with old route scheme
$app->get('/contents/channels/external', BlogController::class.'::public');
$app->get('/static/{slug}', StaticPageController::class.'::view');
$app->get('/page/{page}', PageController::class.'::view');
$app->get('/site/{slug}', SiteController::class.'::view');
$app->get('/blog/{slug}', BlogController::class.'::view');
$app->get('/{slug}', ArticleController::class.'::view')->assert('slug', '\b(?!articles\b).*?\b');

// Default route render home page
$app->get(
    '/',
    function () use ($app) {
        return $app['twig']->render('pages/home.twig');
    }
);

$app->run();
