<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 12/6/17
 * Time: 12:34
 */

namespace Mh13\plugins\contents\application\article;


use Mh13\plugins\contents\application\article\request\ArticleRequest;


class GetArticleCountForRequest
{
    /**
     * @var \Mh13\plugins\contents\application\service\article\request\ArticleRequest
     */
    private $request;

    public function __construct(ArticleRequest $request)
    {

        $this->request = $request;
    }

    /**
     * @return ArticleRequest
     */
    public function getRequest(): request\ArticleRequest
    {
        return $this->request;
    }

}
