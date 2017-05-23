<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 24/4/17
 * Time: 16:29
 */

namespace Mh13\plugins\contents\application\utility\mapper;


use Mh13\plugins\contents\infrastructure\persistence\dbal\article\model\FullArticleView;


class ArticleMapperTest extends \PHPUnit_Framework_TestCase
{
    private $mapper;

    public function setUp()
    {
        $this->mapper = new ArticleMapper();
    }

    public function test_it_maps_from_database_result_to_Article_View()
    {
        $source = [
            'id' => '123',
            'title' => 'The Title',
            'content' => 'This is the content',
            'featured' => true,
            'stick' => false,
            'pubDate' => '2017/03/01',
            'expiration' => null,
            'slug' => 'the_title',
        ];
        $expected = new FullArticleView();
        $expected->setId('123');
        $expected->setTitle('The Title');
        $expected->setContent('This is the content');
        $expected->setFeatured(true);
        $expected->setStick(false);
        $expected->setPubDate('2017/03/01');
        $expected->setExpiration(null);
        $expected->setSlug('the_title');

        $this->assertEquals($expected, $this->mapper->mapToViewModel($source, new FullArticleView()));

    }


}
