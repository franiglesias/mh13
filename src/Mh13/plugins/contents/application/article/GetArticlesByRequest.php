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
     * @var \Mh13\plugins\contents\application\service\article\request\ArticleRequest
     */
    private $request;

    public function __construct(request\ArticleRequest $request)
    {

        $this->request = $request;
    }

    /**
     * @return \Mh13\plugins\contents\application\service\article\request\\Mh13\plugins\contents\application\article\request\ArticleRequest
     */
    public function getRequest(): request\ArticleRequest
    {
        return $this->request;
    }

}
