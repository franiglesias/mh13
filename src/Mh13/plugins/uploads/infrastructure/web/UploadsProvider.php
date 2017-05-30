<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 30/5/17
 * Time: 12:15
 */

namespace Mh13\plugins\uploads\infrastructure\web;


use Mh13\plugins\contents\infrastructure\web\UploadController;
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
        $uploads = $app['controllers_factory'];
        $uploads->get('/{model}/gallery/{type}/{slug}', UploadController::class.'::gallery');
        $uploads->get('/collection/{type}/{collection}', UploadController::class.'::collection');
        $uploads->get('/downloads/{slug}', UploadController::class.'::downloads');

        return $uploads;
    }
}
