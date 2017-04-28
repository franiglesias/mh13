<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 28/4/17
 * Time: 16:18
 */

namespace Mh13\plugins\contents\application\service\upload;


class AttachedFilesContext
{
    protected $alias = 'file';
    protected $model = 'Uploads';
    protected $table = 'uploads';

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }
}
