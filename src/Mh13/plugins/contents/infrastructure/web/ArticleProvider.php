<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 7/4/17
 * Time: 12:44
 */

namespace Mh13\plugins\contents\infrastructure\web;


use Mh13\plugins\contents\application\article\GetArticleByAliasHandler;
use Mh13\plugins\contents\application\article\GetArticleCountForRequestHandler;
use Mh13\plugins\contents\application\article\GetArticlesByRequestHandler;
use Mh13\plugins\contents\application\article\request\ArticleRequestBuilder;
use Mh13\plugins\contents\infrastructure\persistence\dbal\article\DBalArticleReadModel;
use Mh13\plugins\contents\infrastructure\persistence\dbal\article\DbalArticleRepository;
use Mh13\plugins\contents\infrastructure\persistence\dbal\article\DBalArticleSpecificationFactory;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;


class ArticleProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $app['article.request.builder'] = function ($app) {
            return new ArticleRequestBuilder();
        };

        $app['article.specification.factory'] = function ($app) {
            return new DBalArticleSpecificationFactory($app['db']);
        };

        $app['article.repository'] = function ($app) {
            return new DbalArticleRepository($app['db']);
        };

        $app['article.readmodel'] = function ($app) {
            return new DBalArticleReadModel($app['db']);
        };

        $app['article.service'] = function ($app) {
            return new GetArticleCountForRequestHandler(
                $app['article.readmodel'], $app['article.specification.factory']
            );
        };

        $app['article.controller'] = function ($app) {
            return new ArticleController($app['command.bus'], $app['twig']);
        };

        $app[GetArticleByAliasHandler::class] = function ($app) {
            return new GetArticleByAliasHandler($app['article.readmodel'], $app['article.specification.factory']);
        };

        $app[GetArticlesByRequestHandler::class] = function ($app) {
            return new GetArticlesByRequestHandler($app['article.readmodel'], $app['article.specification.factory']);
        };

        $app[GetArticleCountForRequestHandler::class] = function ($app) {
            return new GetArticleCountForRequestHandler(
                $app['article.readmodel'], $app['article.specification.factory']
            );
        };

        $articles = $app['controllers_factory'];
        $articles->get('/catalog', "article.controller:catalog");
        $articles->get('/{slug}', "article.controller:view");

        return $articles;
    }
}
