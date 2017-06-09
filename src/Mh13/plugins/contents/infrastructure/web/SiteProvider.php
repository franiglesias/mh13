<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 9/6/17
 * Time: 13:36
 */

namespace Mh13\plugins\contents\infrastructure\web;


use Mh13\plugins\contents\application\service\SiteService;
use Mh13\plugins\contents\application\site\GetListOfBlogInSite;
use Mh13\plugins\contents\application\site\GetListOfBlogInSiteHandler;
use Mh13\plugins\contents\application\site\GetSiteWithSlug;
use Mh13\plugins\contents\application\site\GetSiteWithSlugHandler;
use Mh13\plugins\contents\infrastructure\persistence\filesystem\FSSiteReadModel;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;


class SiteProvider implements ControllerProviderInterface
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
        $app['site.readmodel'] = function ($app) {
            return new FSSiteReadModel($app['config.path']);
        };

        $app['site.service'] = function ($app) {
            return new SiteService($app['site.readmodel']);
        };

        $app[GetSiteWithSlugHandler::class] = function ($app) {
            return new GetSiteWithSlugHandler($app['site.readmodel']);
        };

        $app[GetListOfBlogInSiteHandler::class] = function ($app) {
            return new GetListOfBlogInSiteHandler($app['site.readmodel']);
        };

        $app['site.controller'] = function ($app) {
            return new SiteController($app['command.bus'], $app['twig']);
        };

        $app['command.bus.locator']->addHandler($app[GetSiteWithSlugHandler::class], GetSiteWithSlug::class);
        $app['command.bus.locator']->addHandler($app[GetListOfBlogInSiteHandler::class], GetListOfBlogInSite::class);

        $sites = $app['controllers_factory'];
        $sites->get('/{slug}', 'site.controller:view');

        return $sites;
    }
}
