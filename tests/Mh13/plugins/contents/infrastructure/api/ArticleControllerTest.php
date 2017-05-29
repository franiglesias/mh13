<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 22/5/17
 * Time: 12:34
 */

namespace Mh13\plugins\contents\infrastructure\api;

use Mh13\plugins\contents\application\service\article\ArticleRequest;
use Mh13\plugins\contents\application\service\article\ArticleRequestBuilder;
use Mh13\plugins\contents\application\service\ArticleService;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ArticleControllerTest extends TestCase
{
    protected $articleService;
    protected $articleController;

    protected $articleRequestBuilder;

    public function setUp()
    {
        $articleRequest = $this->prophesize(ArticleRequest::class);
        $articleRequest->getPage()->willReturn(1);
        $articleRequest->maxPages(Argument::any())->willReturn(1);

        $articleRequestBuilder = $this->prophesize(ArticleRequestBuilder::class);
        $articleRequestBuilder->buildFromQueryData(Argument::any())->willReturn($articleRequest);

        $this->articleService = $this->prophesize(ArticleService::class);

        $this->articleController = new ArticleController(
            $articleRequestBuilder->reveal(),
            $this->articleService->reveal()
        );
    }

    public function test_it_returns_an_empty_list_of_articles_as_json_response()
    {
        $request = $this->getRequestDouble();

        /** @var JsonResponse $response */
        $response = $this->articleController->feed($request->reveal());

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    /**
     * @return \Prophecy\Prophecy\ObjectProphecy
     */
    protected function getRequestDouble(): \Prophecy\Prophecy\ObjectProphecy
    {
        $parameters = $this->prophesize(ParameterBag::class);
        $request = $this->prophesize(Request::class);
        $request->query = $parameters->reveal();

        return $request;
    }

    public function test_it_returns_a_list_of_articles_as_json_response()
    {
        $request = $this->getRequestDouble();

        $this->articleService->getArticlesFromRequest(Argument::type(ArticleRequest::class))->willReturn(
            ['article1', 'article2']
        )
        ;
        $this->articleService->getArticlesCountForRequest(Argument::type(ArticleRequest::class))->willReturn(2);

        /** @var JsonResponse $response */
        $response = $this->articleController->feed($request->reveal());

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function test_it_should_return_500_error_if_article_service_fails()
    {
        $request = $this->getRequestDouble();

        $this->articleService->getArticlesFromRequest(Argument::type(ArticleRequest::class))->willThrow(
            \Exception::class
        )
        ;

        /** @var JsonResponse $response */
        $response = $this->articleController->feed($request->reveal());
        $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }

}
