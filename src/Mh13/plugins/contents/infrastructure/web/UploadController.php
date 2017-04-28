<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 27/4/17
 * Time: 11:28
 */

namespace Mh13\plugins\contents\infrastructure\web;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


class UploadController
{

    public function gallery(string $model, string $type, string $slug, Request $request, Application $app)
    {
        $images = $app['upload.service']->getImagesOf($model, $slug);

        return $app['twig']->render(
            'plugins/images/galleries/'.$type.'.twig',
            [
                'images' => $images,
            ]
        );
    }

    public function collection(string $type, string $collection, Request $request, Application $app)
    {
        $images = $app['upload.service']->getImagesOfCollection($collection);

        return $app['twig']->render(
            'plugins/images/galleries/'.$type.'.twig',
            [
                'images' => $images,
            ]
        );
    }
}
