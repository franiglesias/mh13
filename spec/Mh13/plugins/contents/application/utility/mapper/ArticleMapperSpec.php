<?php

namespace spec\Mh13\plugins\contents\application\utility\mapper;

use Mh13\plugins\contents\application\utility\mapper\ArticleMapper;
use PhpSpec\ObjectBehavior;


class ArticleMapperSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ArticleMapper::class);
    }

    public function it_maps_single_result_array_into_view_array()
    {
        $result = [
            'article_id' => 'article01',
            'article_title' => 'This is an article',
        ];
        $view = [
            'article' => [
                'id' => 'article01',
                'title' => 'This is an article',
            ],
        ];
        $this->fromDbToView($result)->shouldBe($view);
    }

    public function it_maps_single_result_with_several_models()
    {
        $result = [
            'article_id' => 'article01',
            'article_title' => 'This is an article',
            'blog_id' => 'blog01',
            'blog_title' => 'Rumblings',
        ];
        $view = [
            'article' => [
                'id' => 'article01',
                'title' => 'This is an article',
            ],
            'blog' => [
                'id' => 'blog01',
                'title' => 'Rumblings',
            ],
        ];
        $this->fromDbToView($result)->shouldBe($view);
    }

    public function it_maps_array_of_single_results_into_view_array()
    {

        $resultSet = [
            [
                'article_id' => 'article01',
                'article_title' => 'This is an article',
            ],
            [
                'article_id' => 'article02',
                'article_title' => 'This is another article',

            ],

        ];
        $view = [
            [
                'article' => [
                    'id' => 'article01',
                    'title' => 'This is an article',
                ],

            ],
            [
                'article' => [
                    'id' => 'article02',
                    'title' => 'This is another article',
                ],

            ],
        ];
        $this->fromDbToView($resultSet)->shouldBe($view);
    }
}
