<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 24/4/17
 * Time: 19:46
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\model;


abstract class ViewModel
{

    static public function fromArray($source)
    {
        $model = new static();
        foreach ($source as $key => $value) {
            if (property_exists($model, $key)) {
                $model->$key = $value;
            }
        }

        return $model;
    }
}
