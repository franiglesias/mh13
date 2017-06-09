<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 9/6/17
 * Time: 11:04
 */

namespace Mh13\plugins\contents\infrastructure\web;


use Mh13\plugins\contents\application\staticpage\GetPageByAlias;
use Mh13\plugins\contents\application\staticpage\GetPageByAliasHandler;
use Mh13\plugins\contents\infrastructure\persistence\dbal\staticpage\DbalStaticPageReadModel;
use Mh13\plugins\contents\infrastructure\persistence\dbal\staticpage\DbalStaticPageRelatedFinderFactory;
use Mh13\plugins\contents\infrastructure\persistence\dbal\staticpage\DbalStaticPageSpecificationFactory;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;


class StaticPageProvider implements ControllerProviderInterface
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
        $app['staticpage.readmodel'] = function ($app) {
            return new DbalStaticPageReadModel($app['db']);
        };

        $app['staticpage.specification.factory'] = function ($app) {
            return new DbalStaticPageSpecificationFactory($app['db']);
        };

        $app['staticpage.relatedquery.factory'] = function ($app) {
            return new DbalStaticPageRelatedFinderFactory($app['db']);
        };

        $app[GetPageByAliasHandler::class] = function ($app) {
            return new GetPageByAliasHandler(
                $app['staticpage.readmodel'],
                $app['staticpage.specification.factory'],
                $app['staticpage.relatedquery.factory']
            );
        };

        $app['staticpage.controller'] = function ($app) {
            return new StaticPageController($app['command.bus'], $app['twig']);
        };

        $app['command.bus.locator']->addHandler($app[GetPageByAliasHandler::class], GetPageByAlias::class);


        $statics = $app['controllers_factory'];
        $statics->get('/{slug}', 'staticpage.controller:view');

        return $statics;
    }
}
