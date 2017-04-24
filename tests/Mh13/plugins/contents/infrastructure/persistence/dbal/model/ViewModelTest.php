<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 24/4/17
 * Time: 17:05
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\model;


class ViewModelTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_can_set_a_property()
    {
        $model = new ViewModel();

        print_r($model->field);
        $model->field = 'Value';
        $this->assertEquals('Value', $model->field);
    }
}
