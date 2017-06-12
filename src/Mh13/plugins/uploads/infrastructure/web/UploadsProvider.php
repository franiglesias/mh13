<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 30/5/17
 * Time: 12:15
 */

namespace Mh13\plugins\uploads\infrastructure\web;


use Mh13\plugins\contents\application\service\upload\UploadContextFactory;
use Mh13\plugins\contents\application\service\UploadService;
use Mh13\plugins\contents\infrastructure\persistence\dbal\upload\DbalUploadReadModel;
use Mh13\plugins\contents\infrastructure\persistence\dbal\upload\DbalUploadSpecificationFactory;
use Mh13\plugins\uploads\application\GetImagesForObject;
use Mh13\plugins\uploads\application\GetImagesForObjectHandler;
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
            return new UploadContextFactory();
        };

        $app['upload.service'] = function ($app) {
            return new UploadService(
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
                $app['upload.specification.handler'],
                $app['upload.context.factory']
            );
        };

        $app['command.bus.locator']->addHandler($app[GetImagesForObjectHandler::class], GetImagesForObject::class);


        $uploads = $app['controllers_factory'];
        $uploads->get('/{model}/gallery/{type}/{slug}', UploadController::class.'::gallery');
        $uploads->get('/collection/{type}/{collection}', UploadController::class.'::collection');
        $uploads->get('/downloads/{slug}', UploadController::class.'::downloads');

        return $uploads;
    }
}
