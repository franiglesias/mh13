<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 7/4/17
 * Time: 12:44
 */

namespace Mh13\plugins\contents\infrastructure\web;


use Silex\Api\ControllerProviderInterface;
use Silex\Application;


class ArticleProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $articles = $app['controllers_factory'];
        $articles->get('/catalog', ArticleController::class."::catalog");
        $articles->get(
            '/',
            ArticleController::class."::feed"
        ); //->when("request.headers.get('Accept') matches '/application\\\\/json/'");
        $articles->get('/{slug}', ArticleController::class."::view");
        return $articles;
    }
}
