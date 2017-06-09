<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 24/4/17
 * Time: 11:52
 */

namespace Mh13\plugins\contents\infrastructure\web;


use League\Tactician\CommandBus;
use Mh13\plugins\contents\application\site\GetSiteWithSlug;


class SiteController
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
        $site = $this->bus->handle(new GetSiteWithSlug($slug));

        return $this->templating->render(
            'plugins/contents/sites/view.twig',
            [
                'site' => $site,
            ]

        );
    }
}
