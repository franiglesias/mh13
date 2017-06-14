<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 12/6/17
 * Time: 10:14
 */

namespace Mh13\shared\CommandBus;


use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\Locator\InMemoryLocator;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;
use Mh13\shared\CommandBus\Locator\SilexHandlerLocator;
use Pimple\Container;
use Pimple\ServiceProviderInterface;


class TacticianServiceProvider implements ServiceProviderInterface
{

    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $app)
    {
        // Choose our locator
        $app['command.bus.locator'] = function ($app) {
            $locator = isset($app['tactician.locator']) ? $app['tactician.locator'] : 'default';
            switch ($locator) {
                case 'silex':
                    return new SilexHandlerLocator($app);
                case 'in_memory':
                default:
                    return new InMemoryLocator();
            }

        };

// Choose our method name
// Choose our Handler naming strategy
// Create the middleware that executes commands with Handlers
// Create the command bus, with a list of middleware

        $app['command.bus'] = function ($app) {
            $inflector = new HandleInflector();
            $nameExtractor = new ClassNameExtractor();
            $commandHandlerMiddleware = new CommandHandlerMiddleware(
                $nameExtractor,
                $app['command.bus.locator'],
                $inflector
            );

            return new CommandBus([$commandHandlerMiddleware]);
        };
    }
}
