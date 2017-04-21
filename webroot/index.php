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

use Mh13\plugins\contents\application\service\BlogService;
use Mh13\plugins\contents\application\service\catalog\CatalogService;
use Mh13\plugins\contents\application\service\catalog\SiteService;
use Mh13\plugins\contents\application\service\GetArticleService;
use Mh13\plugins\contents\application\service\SlugConverter;
use Mh13\plugins\contents\infrastructure\persistence\dbal\DbalArticleRepository;
use Mh13\plugins\contents\infrastructure\persistence\dbal\DBalArticleSpecificationFactory;
use Mh13\plugins\contents\infrastructure\persistence\dbal\DbalBlogSpecificationFactory;
use Mh13\plugins\contents\infrastructure\persistence\SlugConverter\CakeItemSlugRepository;
use Mh13\plugins\contents\infrastructure\web\ArticleController;
use Mh13\plugins\contents\infrastructure\web\ArticleProvider;
use Mh13\plugins\contents\infrastructure\web\BlogController;
use Mh13\plugins\contents\infrastructure\web\UiProvider;
use Mh13\shared\web\menus\MenuBarLoader;
use Mh13\shared\web\menus\MenuLoader;
use Mh13\shared\web\twig\Twig_Extension_Media;
use Silex\Provider\DoctrineServiceProvider;
use Symfony\Component\Yaml\Yaml;


error_reporting(E_ALL ^ E_STRICT ^ E_WARNING);

require_once(dirname(__DIR__).'/vendor/autoload.php');

//require_once('cakeindex.php');
//require_once(dirname(__DIR__).'/plugins/contents/models/item.php');
//require_once(dirname(__DIR__).'/config/mh13.php');

$config = Yaml::parse(file_get_contents(dirname(__DIR__).'/config/config.yml'));

/** @var Application $app */
$app = new Silex\Application();

$app['debug'] = true;

/* Service definitions */

$app['menu.loader'] = function ($app) {
    return new MenuLoader(dirname(__DIR__).'/config/menus.yml');
};

$app['bar.loader'] = function ($app) {
    return new MenuBarLoader(dirname(__DIR__).'/config/menus.yml');
};

$app['site.service'] = function ($app) {
    return new SiteService(dirname(__DIR__).'/config/config.yml');
};

$app['article.specification.factory'] = function ($app) {
    return new DBalArticleSpecificationFactory($app['db']);
};

$app['article.repository'] = function ($app) {
    return new DbalArticleRepository($app['db']);
};

$app['catalog.service'] = function ($app) {
    return new CatalogService($app['article.specification.factory']);
};

$app['blog.specification.factory'] = function ($app) {
    return new DBalBlogSpecificationFactory($app['db']);
};

$app['blog.service'] = function ($app) {
    return new BlogService($app['blog.specification.factory']);
};

$app['get_article.service'] = function ($app) {
    return new GetArticleService($app['article.repository']);
};
$app['item.slug.converter'] = function ($app) {
    return new SlugConverter(new CakeItemSlugRepository($app['db']));
};

/* End of servide definitions */

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

$app->mount("/articles", new ArticleProvider());
$app->mount("/ui", new UiProvider());

// Compatibility with old route scheme

$app->get('/blog/{slug}', BlogController::class."::view");
$app->get('/{slug}', ArticleController::class."::view");

// Default rout render home page
$app->get(
    '/',
    function () use ($app) {
        return $app['twig']->render('pages/home.twig');
    }
);

$app->run();

/*if (isset($_GET['url']) && $_GET['url'] === 'favicon.ico') {
    return;
} else {
    $Dispatcher = new Dispatcher();
    $Dispatcher->dispatch();
}
if (Configure::read() > 0) {
    echo '<!-- '.round(getMicrotime() - $TIME_START, 4).'s -->';
}*/
