<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 22/5/17
 * Time: 12:34
 */

namespace Mh13\plugins\contents\infrastructure\api;

use League\Tactician\CommandBus;
use Mh13\plugins\contents\application\article\GetArticleCountForRequest;
use Mh13\plugins\contents\application\article\GetArticlesByRequest;
use Mh13\plugins\contents\application\article\request\ArticleRequest;
use Mh13\plugins\contents\application\article\request\ArticleRequestBuilder;
use Mh13\plugins\contents\application\site\GetListOfBlogInSite;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;


class ArticleControllerTest extends TestCase
{
    protected $articleService;
    protected $articleController;

    protected $articleRequestBuilder;

    public function test_feed_returns_a_JsonResponse()
    {
        $controller = new ArticleController(new CommandBus([]), new ArticleRequestBuilder());
        $result = $controller->feed(new Request());
        $this->assertInstanceOf(JsonResponse::class, $result);
    }

    public function test_no_params_query_should_equally_return_articles()
    {
        $bus = $this->createMock(CommandBus::class);
        $articleRequest = new ArticleRequest();
        $bus->method('handle')
            ->withConsecutive(
                new GetArticlesByRequest($articleRequest),
                new GetArticleCountForRequest($articleRequest)
            )
            ->willReturnOnConsecutiveCalls(['articles'], 20)
        ;

        $controller = new ArticleController($bus, new ArticleRequestBuilder());
        $result = $controller->feed(new Request());

        $this->assertNotEmpty($result->getContent());
        $this->assertEquals(200, $result->getStatusCode());
    }

    public function test_no_params_query_should_equally_return_200_code()
    {
        $bus = $this->createMock(CommandBus::class);
        $articleRequest = new ArticleRequest();
        $bus->method('handle')
            ->withConsecutive(
                new GetArticlesByRequest($articleRequest),
                new GetArticleCountForRequest($articleRequest)
            )
            ->willReturnOnConsecutiveCalls(['articles'], 20)
        ;

        $controller = new ArticleController($bus, new ArticleRequestBuilder());
        $result = $controller->feed(new Request());

        $this->assertEquals(200, $result->getStatusCode());
    }

    public function test_if_valid_request_does_not_found_articles_should_return_204_code()
    {
        $bus = $this->createMock(CommandBus::class);
        $bus->method('handle')
            ->willReturn(false)
        ;

        $controller = new ArticleController($bus, new ArticleRequestBuilder());
        $result = $controller->feed(new Request());
        $this->assertEquals(json_encode([]), $result->getContent());
        $this->assertEquals(204, $result->getStatusCode());
    }

    public function test_it_site_param_is_passed_it_is_converted_to_blogs()
    {
        $articleRequestBuilder = $this->getMockBuilder(ArticleRequestBuilder::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $articleRequestBuilder->method('fromBlogs');

        $articleRequest = new ArticleRequest();

        $articleRequestBuilder->method('buildFromQueryData')->willReturn($articleRequest);

        $bus = $this->getMockBuilder(CommandBus::class)->disableOriginalConstructor()->getMock();

        $bus->method('handle')
            ->withConsecutive(
                new GetListOfBlogInSite('example'),
                new GetArticlesByRequest($articleRequest),
                new GetArticleCountForRequest($articleRequest)
            )->willReturnOnConsecutiveCalls(['blogs'], ['articles'], 20)
        ;

        $controller = new ArticleController($bus, $articleRequestBuilder);

        $request = new Request();
        $request->query = new ParameterBag(
            [
                'site' => 'example',
            ]
        );


        $result = $controller->feed($request);

        $this->assertNotEmpty($result->getContent());
        $this->assertEquals(200, $result->getStatusCode());
    }
}
