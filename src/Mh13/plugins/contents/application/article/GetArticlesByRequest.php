<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 12/6/17
 * Time: 12:26
 */

namespace Mh13\plugins\contents\application\article;


use Mh13\plugins\contents\application\article\request\ArticleRequest;


class GetArticlesByRequest
{
    /**
     * @var ArticleRequest
     */
    private $request;

    public function __construct(ArticleRequest $request)
    {

        $this->request = $request;
    }

    /**
     * @return ArticleRequest
     */
    public function getRequest(): ArticleRequest
    {
        return $this->request;
    }

}
