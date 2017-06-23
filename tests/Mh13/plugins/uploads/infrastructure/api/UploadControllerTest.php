<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 23/6/17
 * Time: 10:33
 */

namespace Mh13\plugins\uploads\infrastructure\api;


use League\Tactician\CommandBus;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;


class UploadControllerTest extends TestCase
{

    public function test_downloads_returns_JsonResponse()
    {
        $controller = new UploadController(new CommandBus([]));
        $request = new Request();
        $request->query = new ParameterBag(
            [
                'context' => 'article',
                'alias'   => 'article_alias',
            ]
        );
        $result = $controller->getDownloads($request);
        $this->assertInstanceOf(JsonResponse::class, $result);
    }

    public function test_downloads_returns_204_status_if_no_data_found()
    {
        $controller = new UploadController(new CommandBus([]));
        $request = new Request();
        $request->query = new ParameterBag(
            [
                'context' => 'article',
                'alias'   => 'article_alias',
            ]
        );
        $result = $controller->getDownloads($request);
        $this->assertEquals(204, $result->getStatusCode());
        $this->assertInstanceOf(JsonResponse::class, $result);
    }


    public function test_it_passes_data_to_JsonResponse_and_reports_OK()
    {
        $bus = $this->createMock(CommandBus::class);
        $bus->method('handle')->willReturn(['data', 'data2']);

        $controller = new UploadController($bus);
        $request = new Request();
        $request->query = new ParameterBag(
            [
                'context' => 'article',
                'alias'   => 'article_alias',
            ]
        );
        $result = $controller->getDownloads($request);

        $this->assertEquals(json_encode(['data', 'data2']), $result->getContent());
        $this->assertEquals(200, $result->getStatusCode());
    }

    public function test_downloads_returns_JsonResponse_even_if_request_is_incomplete()
    {
        $controller = new UploadController(new CommandBus([]));
        $request = new Request();
        $request->query = new ParameterBag(
            [
                'context' => 'article',
            ]
        );
        $result = $controller->getDownloads($request);
        $this->assertInstanceOf(JsonResponse::class, $result);
    }

    public function test_request_with_bad_parameters_returns_bad_request_status_code()
    {
        $controller = new UploadController(new CommandBus([]));
        $request = new Request();
        $request->query = new ParameterBag(
            [
                'context' => 'article',
            ]
        );
        $result = $controller->getDownloads($request);
        $this->assertEquals(400, $result->getStatusCode());
    }

    public function test_it_returns_500_on_exception()
    {
        $bus = $this->createMock(CommandBus::class);
        $bus->method('handle')->will($this->throwException(new \Exception));

        $controller = new UploadController($bus);
        $request = new Request();
        $request->query = new ParameterBag(
            [
                'context' => 'article',
                'alias'   => 'article_alias',
            ]
        );
        $result = $controller->getDownloads($request);

        $this->assertEquals(500, $result->getStatusCode());
    }

}
