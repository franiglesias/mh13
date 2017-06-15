<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 28/4/17
 * Time: 16:18
 */

namespace Mh13\plugins\uploads\infrastructure\persistence\dbal\context;


use Mh13\plugins\uploads\application\UploadContext;


class DBalUploadContext implements UploadContext
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
    public function getContext(): string
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
