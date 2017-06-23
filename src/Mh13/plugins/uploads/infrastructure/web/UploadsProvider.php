<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 30/5/17
 * Time: 12:15
 */

namespace Mh13\plugins\uploads\infrastructure\web;


use Mh13\plugins\uploads\application\GetDownloadsForObjectHandler;
use Mh13\plugins\uploads\application\GetImagesForObjectHandler;
use Mh13\plugins\uploads\application\GetMediaForObjectHandler;
use Mh13\plugins\uploads\infrastructure\persistence\dbal\context\DBalUploadContextFactory;
use Mh13\plugins\uploads\infrastructure\persistence\dbal\DbalUploadReadModel;
use Mh13\plugins\uploads\infrastructure\persistence\dbal\DbalUploadSpecificationFactory;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;


class UploadsProvider implements ControllerProviderInterface
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
        $app['upload.readmodel'] = function ($app) {
            return new DbalUploadReadModel($app['db']);
        };

        $app['upload.specification.factory'] = function ($app) {
            return new DbalUploadSpecificationFactory();
        };

        $app['upload.context.factory'] = function ($app) {
            return new DBalUploadContextFactory();
        };

        $app['upload.service'] = function ($app) {
            return new GetMediaForObjectHandler(
                $app['upload.readmodel'],
                $app['upload.specification.factory'],
                $app['upload.context.factory']
            );
        };

        $app['upload.controller'] = function ($app) {
            return new UploadController($app['command.bus'], $app['twig']);
        };

        $app[GetImagesForObjectHandler::class] = function ($app) {
            return new GetImagesForObjectHandler(
                $app['upload.readmodel'],
                $app['upload.specification.factory'],
                $app['upload.context.factory']
            );
        };

        $app[GetDownloadsForObjectHandler::class] = function ($app) {
            return new GetDownloadsForObjectHandler(
                $app['upload.readmodel'],
                $app['upload.specification.factory'],
                $app['upload.context.factory']
            );
        };

        $app[GetMediaForObjectHandler::class] = function ($app) {
            return new GetMediaForObjectHandler(
                $app['upload.readmodel'],
                $app['upload.specification.factory'],
                $app['upload.context.factory']
            );
        };

        $uploads = $app['controllers_factory'];
        $uploads->get('/{model}/gallery/{type}/{slug}', 'upload.controller:gallery');
        $uploads->get('/collection/{type}/{collection}', 'upload.controller:collection');
        $uploads->get('/getDownloads/{slug}', 'upload.controller:getDownloads');

        return $uploads;
    }
}
