<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 27/4/17
 * Time: 11:28
 */

namespace Mh13\plugins\uploads\infrastructure\web;


use League\Tactician\CommandBus;
use Mh13\plugins\uploads\application\GetImagesForObject;
use Mh13\plugins\uploads\application\GetMediaForObject;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


class UploadController
{
    /**
     * @var CommandBus
     */
    private $bus;
    private $templating;

    public function __construct(CommandBus $bus, $templating)
    {

        $this->bus = $bus;
        $this->templating = $templating;
    }

    public function gallery(string $model, string $type, string $slug, Request $request, Application $app)
    {
        $images = $this->bus->handle(new GetImagesForObject($model, $slug));

        return $this->templating->render(
            'plugins/images/galleries/'.$type.'.twig',
            [
                'images' => $images,
            ]
        );
    }

    public function downloads(string $slug, Request $request, Application $app)
    {
        $files = $this->bus->handle(new GetMediaForObject('article', $slug));

        return $this->templating->render(
            'plugins/contents/items/widgets/downloads.twig',
            [
                'files' => $files,
            ]
        );
    }

    public function collection(string $type, string $collection, Request $request, Application $app)
    {
        $images = $this->bus->handle(new GetImagesForObject('collection', $collection));

        return $this->templating->render(
            'plugins/images/galleries/'.$type.'.twig',
            [
                'images' => $images,
            ]
        );
    }
}
