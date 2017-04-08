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

error_reporting(E_ALL ^ E_STRICT);
/**
 * Use the DS to separate the directories in other defines.
 */
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
/*
 * These defines should only be edited if you have cake installed in
 * a directory layout other than the way it is distributed.
 * When using custom settings be sure to use the DS and do not add a trailing DS.
 */

/*
 * The full path to the directory which holds "app", WITHOUT a trailing DS.
 *
 */
if (!defined('ROOT')) {
    define('ROOT', dirname(dirname(dirname(__FILE__))));
}
/*
 * The actual directory name for the "app".
 *
 */
if (!defined('APP_DIR')) {
    //define('APP_DIR', basename(dirname(dirname(__FILE__))));
    define('APP_DIR', 'mh13');
}
/*
 * The absolute path to the "cake" directory, WITHOUT a trailing DS.
 *
 */
if (!defined('CAKE_CORE_INCLUDE_PATH')) {
    define('CAKE_CORE_INCLUDE_PATH', ROOT.DS.APP_DIR.'/vendors/cakephp');
}

/*
 * Editing below this line should NOT be necessary.
 * Change at your own risk.
 *
 */
if (!defined('WEBROOT_DIR')) {
    define('WEBROOT_DIR', basename(dirname(__FILE__)));
}
if (!defined('WWW_ROOT')) {
    define('WWW_ROOT', dirname(__FILE__).DS);
}

if (!defined('CORE_PATH')) {
    if (function_exists('ini_set') && ini_set(
            'include_path',
            CAKE_CORE_INCLUDE_PATH.PATH_SEPARATOR.ROOT.DS.APP_DIR.DS.PATH_SEPARATOR.ini_get(
                'include_path'
            )
        )
    ) {
        define('APP_PATH', null);
        define('CORE_PATH', null);
    } else {
        define('APP_PATH', ROOT.DS.APP_DIR.DS);
        define('CORE_PATH', CAKE_CORE_INCLUDE_PATH.DS);
    }
}
if (!include(CORE_PATH.'cake'.DS.'bootstrap.php')) {
    trigger_error(
        'CakePHP core could not be found.  Check the value of CAKE_CORE_INCLUDE_PATH in APP/webroot/index.php.  It should point to the directory containing your '.DS.'cake core directory and your '.DS.'vendors root directory.',
        E_USER_ERROR
    );
}




require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../plugins/contents/models/item.php';

use Mh13\plugins\contents\application\service\GetArticleService;
use Mh13\plugins\contents\application\service\SlugConverter;
use Mh13\plugins\contents\infrastructure\persistence\cakephp\ArticleCakeStore;
use Mh13\plugins\contents\infrastructure\persistence\cakephp\CakeArticleMapper;
use Mh13\plugins\contents\infrastructure\persistence\cakephp\CakeArticleRepository;
use Mh13\plugins\contents\infrastructure\web\ArticleProvider;
use Mh13\shared\web\twig\Twig_Extension_Media;
use Silex\Provider\DoctrineServiceProvider;


require_once(__DIR__.'/../config/mh13.php');

$app = new Silex\Application();

$app['debug'] = true;

/* Service definitions */


$app['article.repository'] = function () {
    return new CakeArticleRepository(new ArticleCakeStore(new \Item()), new CakeArticleMapper());
};

$app['get-article-by-slug.service'] = function ($app) {
    return new GetArticleService($app['article.repository'], new SlugConverter());
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
        'db.options' => [
            'driver' => 'pdo_mysql',
            'dbname' => 'mh14',
            'host' => '127.0.0.1',
            'user' => 'root',
            'password' => 'Fi36101628',
            'charset' => 'utf8mb4',
        ],
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

$app->get(
    '/hello/{name}',
    function ($name) use ($app) {
        return 'Hello '.$app->escape($name);
    }
);


$app->get(
    '/blogs',
    function () use ($app) {
        $sql = 'select title from channels';
        $statement = $app['db']->executeQuery($sql);
        print_r(get_class($app['db']));

        while ($blog = $statement->fetch()) {
            print_r($blog['title']);
        }

        return $response = '';


    }
);

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
