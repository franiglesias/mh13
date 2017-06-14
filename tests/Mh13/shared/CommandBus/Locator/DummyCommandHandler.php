<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 14/6/17
 * Time: 9:38
 */

namespace Mh13\shared\CommandBus\Locator;


class DummyCommandHandler
{
    public function handle(DummyCommand $command)
    {
    }
}
