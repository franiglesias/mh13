<?php

// web/index.php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = true;

$app->register(
    new Silex\Provider\TwigServiceProvider(),
    [
        'twig.path' => __DIR__.'/../views',
        'twig.options' => [
            'auto_reload' => true,
            'cache' => __DIR__.'/../tmp/cache/twig2',
        ],
    ]
);

require_once('../config/mh13.php');

$app->extend(
    'twig',
    function ($twig, $app) use ($config) {
        foreach ($config as $key => $value) {
            $twig->addGlobal($key, $config[$key]);
        }
        $twig->addGlobal('title_for_layout', 'Página principal');
        $twig->addGlobal('BaseUrl', '/');

        return $twig;
    }
);

$app->get(
    '/hello/{name}',
    function ($name) use ($app) {
        return 'Hello '.$app->escape($name);
    }
);

$app->get(
    '/',
    function () use ($app) {
        return $app['twig']->render('pages/index.twig');
    }
);

$app->run();