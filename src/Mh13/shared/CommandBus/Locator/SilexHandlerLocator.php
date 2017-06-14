<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 14/6/17
 * Time: 9:05
 */

namespace Mh13\shared\CommandBus\Locator;


use League\Tactician\Exception\MissingHandlerException;
use League\Tactician\Handler\Locator\HandlerLocator;
use Pimple\Container;


/**
 * Class SilexHandlerLocator
 *
 * Locator for Tactician wrapping the Pimple DIC
 *
 * Handlers are located using a simple convention, Command Handler name is composer with Command name + Handler
 *
 * Examples:
 *
 * Command (handled by) CommandHandler
 * GetPost (handled by) GetPostHandler
 *
 *
 * @package Mh13\shared\CommandBus\Locator
 */
class SilexHandlerLocator implements HandlerLocator
{
    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {

        $this->container = $container;
    }

    /**
     * Retrieves the handler for a specified command
     *
     * @param string $commandName
     *
     * @return object
     *
     * @throws MissingHandlerException
     */
    public function getHandlerForCommand($commandName)
    {
        try {
            $handlerName = $commandName.'Handler';

            return $this->container[$handlerName];
        } catch (\InvalidArgumentException $exception) {
            throw MissingHandlerException::forCommand($commandName);
        }
    }


}
