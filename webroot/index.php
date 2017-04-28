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

use Mh13\plugins\contents\application\service\ArticleService;
use Mh13\plugins\contents\application\service\BlogService;
use Mh13\plugins\contents\application\service\StaticPageService;
use Mh13\plugins\contents\application\service\UploadService;
use Mh13\plugins\contents\application\utility\mapper\ArticleMapper;
use Mh13\plugins\contents\exceptions\ContentException;
use Mh13\plugins\contents\infrastructure\persistence\dbal\DBalArticleReadModel;
use Mh13\plugins\contents\infrastructure\persistence\dbal\DbalArticleRepository;
use Mh13\plugins\contents\infrastructure\persistence\dbal\DBalArticleSpecificationFactory;
use Mh13\plugins\contents\infrastructure\persistence\dbal\DbalBlogReadModel;
use Mh13\plugins\contents\infrastructure\persistence\dbal\DbalBlogSpecificationFactory;
use Mh13\plugins\contents\infrastructure\persistence\dbal\DbalStaticPageReadModel;
use Mh13\plugins\contents\infrastructure\persistence\dbal\DBalStaticPageSpecificationFactory;
use Mh13\plugins\contents\infrastructure\persistence\dbal\DbalUploadReadModel;
use Mh13\plugins\contents\infrastructure\persistence\dbal\DbalUploadSpecificationFactory;
use Mh13\plugins\contents\infrastructure\persistence\filesystem\FSSiteReadModel;
use Mh13\plugins\contents\infrastructure\web\ArticleController;
use Mh13\plugins\contents\infrastructure\web\ArticleProvider;
use Mh13\plugins\contents\infrastructure\web\BlogController;
use Mh13\plugins\contents\infrastructure\web\PageController;
use Mh13\plugins\contents\infrastructure\web\SiteController;
use Mh13\plugins\contents\infrastructure\web\StaticPageController;
use Mh13\plugins\contents\infrastructure\web\UiProvider;
use Mh13\plugins\contents\infrastructure\web\UploadController;
use Mh13\shared\web\menus\MenuBarLoader;
use Mh13\shared\web\menus\MenuLoader;
use Mh13\shared\web\twig\Twig_Extension_Media;
use Silex\Provider\DoctrineServiceProvider;
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

/* Service definitions */

$app['menu.loader'] = function ($app) {
    return new MenuLoader(dirname(__DIR__).'/config/menus.yml');
};

$app['bar.loader'] = function ($app) {
    return new MenuBarLoader(dirname(__DIR__).'/config/menus.yml');
};

$app['site.service'] = function ($app) {
    return new FSSiteReadModel(dirname(__DIR__).'/config/config.yml');
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

$app['article.mapper'] = function ($app) {
    return new ArticleMapper();
};

$app['article.service'] = function ($app) {
    return new ArticleService($app['article.readmodel'], $app['article.specification.factory'], $app['article.mapper']);
};

$app['staticpage.readmodel'] = function ($app) {
    return new DbalStaticPageReadModel();
};

$app['staticpage.specification.factory'] = function ($app) {
    return new DBalStaticPageSpecificationFactory($app['db']);
};

$app['staticpage.service'] = function ($app) {
    return new StaticPageService($app['staticpage.readmodel'], $app['staticpage.specification.factory']);
};

$app['upload.readmodel'] = function ($app) {
    return new DbalUploadReadModel($app['db']);
};

$app['upload.specification.factory'] = function ($app) {
    return new DbalUploadSpecificationFactory($app['db']);
};

$app['upload.service'] = function ($app) {
    return new UploadService($app['upload.readmodel'], $app['upload.specification.factory']);
};

$app['blog.specification.factory'] = function ($app) {
    return new DBalBlogSpecificationFactory($app['db']);
};

$app['blog.readmodel'] = function ($app) {
    return new DbalBlogReadModel($app['db']);
};

$app['blog.service'] = function ($app) {
    return new BlogService($app['blog.readmodel'], $app['blog.specification.factory']);
};


/* End of service definitions */

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
        'db.options' => $config['doctrine']['dbal']['connections']['default'],
    ]
);

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

$app->mount("/articles", new ArticleProvider());
$app->mount("/ui", new UiProvider());
$app->get('/uploads/{model}/gallery/{type}/{slug}', UploadController::class.'::gallery');
$app->get('/uploads/collection/{type}/{collection}', UploadController::class.'::collection');
$app->get('/uploads/downloads/{slug}', UploadController::class.'::downloads');

// Compatibility with old route scheme

$app->get('/static/{slug}', StaticPageController::class.'::view');
$app->get('/page/{page}', PageController::class.'::view');
$app->get('/site/{slug}', SiteController::class.'::view');
$app->get('/blog/{slug}', BlogController::class.'::view');
$app->get('/{slug}', ArticleController::class.'::view');

// Default rout render home page
$app->get(
    '/',
    function () use ($app) {
        return $app['twig']->render('pages/home.twig');
    }
);

$app->run();
