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
    const ALIAS = 'file';
    const MODEL = 'Uploads';
    const TABLE = 'uploads';

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return static::ALIAS;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return static::MODEL;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return static::TABLE;
    }
}