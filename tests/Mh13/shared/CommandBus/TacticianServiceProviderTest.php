<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 14/6/17
 * Time: 8:53
 */

namespace Mh13\shared\CommandBus;

use League\Tactician\CommandBus;
use League\Tactician\Handler\Locator\HandlerLocator;
use Mh13\shared\CommandBus\Locator\SilexHandlerLocator;
use PHPUnit\Framework\TestCase;
use Pimple\Container;
use Pimple\ServiceProviderInterface;


class TacticianServiceProviderTest extends TestCase
{
    public function test_it_initializes()
    {
        $provider = new TacticianServiceProvider();
        $this->assertInstanceOf(ServiceProviderInterface::class, $provider);
    }

    public function test_it_defines_a_locator_key()
    {
        $pimple = new Container();
        $tacticianProvider = new TacticianServiceProvider();
        $tacticianProvider->register($pimple);
        $this->assertArrayHasKey('command.bus.locator', $pimple);
    }

    public function test_it_puts_a_locator_in_its_key()
    {
        $pimple = new Container();
        $tacticianProvider = new TacticianServiceProvider();
        $tacticianProvider->register($pimple);
        $this->assertInstanceOf(HandlerLocator::class, $pimple['command.bus.locator']);
    }

    public function test_it_defines_a_command_bus()
    {
        $pimple = new Container();
        $tacticianProvider = new TacticianServiceProvider();
        $tacticianProvider->register($pimple);
        $this->assertArrayHasKey('command.bus', $pimple);
    }


    public function test_it_puts_a_command_bus_in_its_key()
    {
        $pimple = new Container();
        $tacticianProvider = new TacticianServiceProvider();
        $tacticianProvider->register($pimple);
        $this->assertInstanceOf(CommandBus::class, $pimple['command.bus']);
    }

    public function test_it_allows_to_configure_locator()
    {
        $pimple = new Container();
        $pimple['tactician.locator'] = 'silex';
        $tacticianProvider = new TacticianServiceProvider();
        $tacticianProvider->register($pimple);
        $this->assertInstanceOf(SilexHandlerLocator::class, $pimple['command.bus.locator']);
    }
}
