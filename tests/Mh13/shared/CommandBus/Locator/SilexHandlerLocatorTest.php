<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 14/6/17
 * Time: 9:03
 */

namespace Mh13\shared\CommandBus\Locator;

use League\Tactician\Exception\MissingHandlerException;
use League\Tactician\Handler\Locator\HandlerLocator;
use PHPUnit\Framework\TestCase;
use Pimple\Container;


include('DummyCommand.php');
include('DummyCommandHandler.php');


class SilexHandlerLocatorTest extends TestCase
{
    /**
     * @var HandlerLocator
     * @var SilexHandlerLocator
     */
    private $locator;

    public function setUp()
    {
        $expected = new DummyCommandHandler();
        $container = new Container();
        $container[DummyCommandHandler::class] = $expected;
        $this->locator = new SilexHandlerLocator($container);
    }

    public function test_it_initializes()
    {
        $this->assertInstanceOf(HandlerLocator::class, $this->locator);
        $this->assertInstanceOf(SilexHandlerLocator::class, $this->locator);
    }

    public function test_it_returns_CommandHandler_for_Command()
    {
        $command = new DummyCommand();

        $handler = $this->locator->getHandlerForCommand(get_class($command));
        $this->assertInstanceOf(DummyCommandHandler::class, $handler);
    }

    public function test_it_throws_exception_if_a_handler_is_not_found()
    {
        $command = new DummyCommand();
        $container = new Container();
        $this->locator = new SilexHandlerLocator($container);
        $this->expectException(MissingHandlerException::class);
        $this->locator->getHandlerForCommand(get_class($command));
    }

}
