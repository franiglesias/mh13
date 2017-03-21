<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 20/3/17
 * Time: 8:44
 */


for ($i = 1; $i < 100; $i++) {
    $a = (rand(0, 1) ?: 2);
    if (is_null($a)) {
        echo 'Null'.PHP_EOL;
    }
    echo $a.PHP_EOL;
}