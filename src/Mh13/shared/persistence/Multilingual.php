<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 2/6/17
 * Time: 12:58
 */

namespace Mh13\shared\persistence;


/**
 * Trait Multilingual
 *
 * Helps to build queries that get mutilingual data from db
 *
 * @package Mh13\shared\persistence
 */
trait Multilingual
{
    private $subQueryTemplate = '(select content from %5$s where %5$s.foreign_key = %3$s.id and locale="%2$s" and field="%1$s" and model="%4$s") as %1$s';

    private $table;
    private $model;
    private $translations;

    protected function configureTranslations($table, $model, $translations)
    {
        $this->table = $table;
        $this->model = $model;
        $this->translations = $translations;
    }

    /**-
     * @param $field
     *
     * @param $locale
     *
     * @return string
     */
    protected function selectFieldFromTranslation($field, $locale): string
    {
        return sprintf($this->subQueryTemplate, $field, $locale, $this->table, $this->model, $this->translations);
    }
}
