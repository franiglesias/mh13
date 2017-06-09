<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 25/4/17
 * Time: 12:17
 */

namespace Mh13\plugins\contents\infrastructure\web;


use League\Tactician\CommandBus;
use Mh13\plugins\contents\application\staticpage\GetPageByAlias;


class StaticPageController
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

    public function view($slug)
    {
        $page = $this->bus->handle(new GetPageByAlias($slug));

        return $this->templating->render(
            'plugins/contents/static_pages/view.twig',
            [
                'page'        => $page['page'],
                'tag'         => false,
                'level_id'    => false,
                'preview'     => false,
                'parents'     => $page['parents'],
                'siblings'    => $page['siblings'],
                'descendants' => $page['descendants'],
            ]
        );
    }
}
