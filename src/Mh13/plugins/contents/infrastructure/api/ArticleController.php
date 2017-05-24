<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 7/4/17
 * Time: 12:46
 */

namespace Mh13\plugins\contents\infrastructure\api;


use Doctrine\DBAL\Exception\ConnectionException;
use Mh13\plugins\contents\application\service\article\ArticleRequestBuilder;
use Mh13\plugins\contents\application\service\ArticleService;
use Mh13\plugins\contents\application\service\SiteService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ArticleController
{
    /**
     * @var SiteService
     */
    private $siteService;
    /**
     * @var ArticleService
     */
    private $articleService;
    /**
     * @var ArticleRequestBuilder
     */
    private $articleRequestBuilder;

    public function __construct(ArticleRequestBuilder $articleRequestBuilder, ArticleService $articleService)
    {
        $this->articleService = $articleService;
        $this->articleRequestBuilder = $articleRequestBuilder;
    }

    public function feed(Request $request): JsonResponse
    {
        try {
            $articleRequest = $this->articleRequestBuilder->buildFromQueryData($request->query);
            $articles = $this->articleService->getArticlesFromRequest($articleRequest);
            if (!$articles) {
                return new JsonResponse(
                    ['code' => 204, 'message' => 'No articles found for this query.'],
                    Response::HTTP_NO_CONTENT
                );
            }

            $currentPage = $articleRequest->getPage();
            $maxPages = $articleRequest->maxPages($this->articleService->getArticlesCountForRequest($articleRequest));

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
