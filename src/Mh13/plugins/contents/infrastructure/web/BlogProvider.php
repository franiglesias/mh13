<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 9/6/17
 * Time: 14:23
 */

namespace Mh13\plugins\contents\infrastructure\web;


use Mh13\plugins\contents\application\blog\GetBlogByAliasHandler;
use Mh13\plugins\contents\application\blog\GetPublicBlogsHandler;
use Mh13\plugins\contents\infrastructure\persistence\dbal\blog\DbalBlogReadModel;
use Mh13\plugins\contents\infrastructure\persistence\dbal\blog\DbalBlogSpecificationFactory;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;


class BlogProvider implements ControllerProviderInterface
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

        $app['blog.specification.factory'] = function ($app) {
            return new DBalBlogSpecificationFactory();
        };

        $app['blog.readmodel'] = function ($app) {
            return new DbalBlogReadModel($app['db']);
        };


        $app[GetBlogByAliasHandler::class] = function ($app) {
            return new GetBlogByAliasHandler($app['blog.readmodel'], $app['blog.specification.factory']);
        };

        $app[GetPublicBlogsHandler::class] = function ($app) {
            return new GetPublicBlogsHandler($app['blog.readmodel'], $app['blog.specification.factory']);
        };

        $app['blog.controller'] = function ($app) {
            return new BlogController($app['command.bus'], $app['twig']);
        };

        $blogs = $app['controllers_factory'];
        $blogs->get('/{slug}', 'blog.controller:view');

        return $blogs;
    }
}
