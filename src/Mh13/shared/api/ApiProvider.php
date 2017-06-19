<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 13/6/17
 * Time: 12:19
 */

namespace Mh13\shared\api;


use Mh13\plugins\circulars\infrastructure\api\CircularController;
use Mh13\plugins\circulars\infrastructure\api\EventController;
use Mh13\plugins\contents\infrastructure\api\ArticleController;
use Mh13\plugins\contents\infrastructure\api\BlogController;
use Mh13\plugins\uploads\infrastructure\api\UploadController;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;


class ApiProvider implements ControllerProviderInterface
{

    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {

        $app['api.circular.controller'] = function ($app) {
            return new CircularController($app['command.bus']);
        };

        $app['api.article.controller'] = function () use ($app) {
            return new ArticleController($app['command.bus'], $app['article.request.builder'], $app['article.service']);
        };

        $app['api.event.controller'] = function () use ($app) {
            return new EventController($app['command.bus']);
        };

        $app['api.blog.controller'] = function () use ($app) {
            return new BlogController($app['command.bus']);
        };

        $app['api.upload.controller'] = function () use ($app) {
            return new UploadController($app['command.bus']);
        };

        $api = $app['controllers_factory'];

        $api->get('/articles', "api.article.controller:feed")->when(
            "request.headers.get('Accept') matches '/application\\\\/json/'"
        )
        ;
        $api->get('/events', "api.event.controller:last")->when(
            "request.headers.get('Accept') matches '/application\\\\/json/'"
        )
        ;
        $api->get('/circulars', "api.circular.controller:last");
        $api->get('/blogs', 'api.blog.controller:public');
        $api->get('/downloads', 'api.upload.controller:downloads');
        $api->get('/images', 'api.upload.controller:images');
        return $api;
    }
}
