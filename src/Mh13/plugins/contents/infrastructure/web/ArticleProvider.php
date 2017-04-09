<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 7/4/17
 * Time: 12:44
 */

namespace Mh13\plugins\contents\infrastructure\web;


use Mh13\plugins\contents\application\service\SlugConverter;
use Mh13\plugins\contents\infrastructure\persistence\SlugConverter\CakeItemSlugRepository;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;


class ArticleProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {

        $app['item.slug.converter'] = function ($app) {
            return new SlugConverter(new CakeItemSlugRepository($app['db']));
        };
        $articles = $app['controllers_factory'];
        $articles->get('/{slug}', ArticleController::class."::view")->convert('slug', 'item.slug.converter:mapToId');

        return $articles;
    }
}
