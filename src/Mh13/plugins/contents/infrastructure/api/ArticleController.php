<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 7/4/17
 * Time: 12:46
 */

namespace Mh13\plugins\contents\infrastructure\api;


use Doctrine\DBAL\Exception\ConnectionException;
use League\Tactician\CommandBus;
use Mh13\plugins\contents\application\article\GetArticleCountForRequest;
use Mh13\plugins\contents\application\article\GetArticlesByRequest;
use Mh13\plugins\contents\application\article\request\ArticleRequestBuilder;
use Mh13\plugins\contents\application\service\SiteService;
use Mh13\plugins\contents\application\site\GetListOfBlogInSite;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ArticleController
{

    /**
     * @var ArticleRequestBuilder
     */
    private $articleRequestBuilder;
    /**
     * @var CommandBus
     */
    private $bus;


    public function __construct(
        CommandBus $bus,
        ArticleRequestBuilder $articleRequestBuilder
    )
    {
        $this->articleRequestBuilder = $articleRequestBuilder;
        $this->bus = $bus;
    }

    public function feed(Request $request): JsonResponse
    {
        try {
            if ($site = $request->query->getAlnum('site')) {
                $this->articleRequestBuilder->fromBlogs($this->bus->handle(new GetListOfBlogInSite($site)));
            }
            $articleRequest = $this->articleRequestBuilder->buildFromQueryData($request->query);

            $articles = $this->bus->handle(new GetArticlesByRequest($articleRequest));

            if (!$articles) {
                return new JsonResponse(
                    [],
                    Response::HTTP_NO_CONTENT
                );
            }

            $currentPage = $articleRequest->getPage();
            $maxPages = $articleRequest->maxPages($this->bus->handle(new GetArticleCountForRequest($articleRequest)));

            return new JsonResponse(
                $articles, Response::HTTP_OK, [
                             'X-Max-Pages'    => $maxPages,
                             'X-Current-Page' => $currentPage,
                             'Link'           => $this->computeLinks($request, $currentPage, $maxPages),
                         ]
            );
        } catch (ConnectionException $exception) {
            return new JsonResponse(
                ['code'    => 502,
                 'message' => 'Estamos teniendo un problema con nuestro servidor de contenidos. Sentimos las molestias.',
                ],
                Response::HTTP_BAD_GATEWAY
            );
        } catch (\Exception $e) {
            return new JsonResponse(
                ['code' => 500, 'message' => $e->getMessage().' '.get_class($e)],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @param Request $request
     * @param         $currentPage
     * @param         $maxPages
     *
     * @return array
     */
    protected function computeLinks(Request $request, $currentPage, $maxPages): array
    {
        $url = $this->prepareTemplateURL($request);


        $links = [
            ['name' => 'first', 'page' => 1],
            ['name' => 'prev', 'page' => $currentPage > 1 ? $currentPage - 1 : 1],
            ['name' => 'next', 'page' => $currentPage < $maxPages ? $currentPage + 1 : $maxPages],
        ];

        return array_map(
            function ($link) use ($url) {
                return sprintf('<%s&page=%s>; rel=%s', $url, $link['page'], $link['name']);
            },
            $links
        );
    }

    /**
     * @param Request $request
     *
     * @return mixed|string
     */
    protected function prepareTemplateURL(Request $request)
    {
        $url = str_replace(['&url=articles', '%2F'], '', $request->getUri());

        return preg_replace('/[&]?page=\d+/', '', $url);
    }

}
