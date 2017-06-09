<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 24/4/17
 * Time: 12:55
 */

namespace Mh13\plugins\contents\infrastructure\web;


class PageController
{
    private $templating;

    public function __construct($templating)
    {

        $this->templating = $templating;
    }

    public function view($page)
    {
        return $this->templating->render('pages/'.$page.'.twig');
    }
}
