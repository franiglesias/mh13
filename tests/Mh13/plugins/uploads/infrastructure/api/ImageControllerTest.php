<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 23/6/17
 * Time: 11:14
 */

namespace Mh13\plugins\uploads\infrastructure\api;

use League\Tactician\CommandBus;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;


class ImageControllerTest extends TestCase
{
    public function test_getImages_returns_JsonResponse()
    {
        $controller = new ImageController(new CommandBus([]));
        $request = new Request();
        $request->query = new ParameterBag(
            [
                'context' => 'article',
                'alias'   => 'article_alias',
            ]
        );
        $result = $controller->getImages($request);
        $this->assertInstanceOf(JsonResponse::class, $result);
    }

    public function test_getImages_returns_204_status_if_no_data_found()
    {
        $controller = new ImageController(new CommandBus([]));
        $request = new Request();
        $request->query = new ParameterBag(
            [
                'context' => 'article',
                'alias'   => 'article_alias',
            ]
        );
        $result = $controller->getImages($request);
        $this->assertInstanceOf(JsonResponse::class, $result);
    }


    public function test_it_passes_data_to_JsonResponse_and_reports_OK()
    {
        $bus = $this->createMock(CommandBus::class);
        $bus->method('handle')->willReturn(['data', 'data2']);

        $controller = new ImageController($bus);
        $request = new Request();
        $request->query = new ParameterBag(
            [
                'context' => 'article',
                'alias'   => 'article_alias',
            ]
        );
        $result = $controller->getImages($request);

        $this->assertEquals(json_encode(['data', 'data2']), $result->getContent());
        $this->assertEquals(200, $result->getStatusCode());
    }

    public function test_getImages_returns_JsonResponse_even_if_request_is_incomplete()
    {
        $controller = new ImageController(new CommandBus([]));
        $request = new Request();
        $request->query = new ParameterBag(
            [
                'context' => 'article',
            ]
        );
        $result = $controller->getImages($request);
        $this->assertInstanceOf(JsonResponse::class, $result);
    }

    public function test_request_with_bad_parameters_returns_bad_request_status_code()
    {
        $controller = new ImageController(new CommandBus([]));
        $request = new Request();
        $request->query = new ParameterBag(
            [
                'context' => 'article',
            ]
        );
        $result = $controller->getImages($request);
        $this->assertEquals(400, $result->getStatusCode());
    }

    public function test_it_returns_500_on_exception()
    {
        $bus = $this->createMock(CommandBus::class);
        $bus->method('handle')->will($this->throwException(new \Exception));

        $controller = new ImageController($bus);
        $request = new Request();
        $request->query = new ParameterBag(
            [
                'context' => 'article',
                'alias'   => 'article_alias',
            ]
        );
        $result = $controller->getImages($request);

        $this->assertEquals(500, $result->getStatusCode());
    }
}
