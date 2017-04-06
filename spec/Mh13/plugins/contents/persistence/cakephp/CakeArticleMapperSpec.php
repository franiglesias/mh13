<?php

namespace spec\Mh13\plugins\contents\persistence\cakephp;

use Mh13\plugins\contents\domain\Article;
use Mh13\plugins\contents\domain\ArticleContent;
use Mh13\plugins\contents\domain\ArticleId;
use Mh13\plugins\contents\domain\Author;
use Mh13\plugins\contents\persistence\cakephp\CakeArticleMapper;
use PhpSpec\ObjectBehavior;


class CakeArticleMapperSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CakeArticleMapper::class);
    }

    public function it_maps_from_array_to_object()
    {
        $dataArray = [
            'Item' => [
                'id' => '588d0d9d-9fb8-46ee-abf9-466bac100002',
                'pubDate' => '2017-01-28 00:00:00',
                'expiration' => '',
                'created' => '2017-01-28 22:31:09',
                'modified' => '2017-04-05 11:18:00',
                'status' => '2',
                'license_id' => '4cbd546b-d3b8-483f-89fe-11a6c695dee1',
                'channel_id' => '561cd468-e7a8-4733-9b54-587fac100002',
                'featured' => '0',
                'remarks' => '',
                'live' => '0',
                'allow_comments' => '0',
                'search_if_expired' => '0',
                'readings' => '94',
                'stick' => '0',
                'home' => '0',
                'level_id' => '0',
                'subject_id' => '',
                'gallery' => 'lightbox',
                'guest' => '',
                'guestpwd' => '',
                'show_main_image' => '',
                'title' => 'Vaya animalada',
                'content' => 'Contenido',
                'slug' => 'vaya_animalada_1',
                'real_status' => '2',
            ],
            'Authors' => [
                [
                    'User' => [
                        'id' => '4eba6cea-5fb8-4062-aa2d-4ddcac100002',
                        'realname' => 'Fran Iglesias',
                        'email' => 'frankie@miralba.org',
                    ],
                    'Owner' => [
                        'access' => '23',
                    ],
                ],
            ],
        ];
        $article = new Article(
            new ArticleId('588d0d9d-9fb8-46ee-abf9-466bac100002'),
            new ArticleContent('Vaya animalada', 'Contenido'),
            new Author('4eba6cea-5fb8-4062-aa2d-4ddcac100002', 'Fran Iglesias', 'frankie@miralba.org', 23)
        );
        $this->toArticle($dataArray)->shouldBeLike($article);
    }

}
