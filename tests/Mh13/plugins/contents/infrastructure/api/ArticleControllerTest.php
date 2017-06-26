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
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $this->assertEquals($result->getStatusCode(), 200);
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

        $this->assertEquals($result->getStatusCode(), 200);
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
        $this->assertEquals($result->getStatusCode(), 204);
    }

    public function test_it_site_param_is_passed_it_is_converted_to_blogs()
    {
        $articleRequestBuilder = $this->createMock(ArticleRequestBuilder::class)
            ->method('fromBlogs')
        ;

        $bus = $this->createMock(CommandBus::class);
        $articleRequest = new ArticleRequest();
        $bus->method('handle')
            ->withConsecutive(
                new GetArticlesByRequest($articleRequest),
                new GetArticleCountForRequest($articleRequest)
            )
            ->willReturnOnConsecutiveCalls(['articles'], 20)
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
        $this->assertEquals($result->getStatusCode(), 200);
    }
}
