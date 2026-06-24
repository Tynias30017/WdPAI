<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Core\Router;

class DummyController
{
    public static bool $called = false;

    public function dummyAction()
    {
        self::$called = true;
    }
}

class RouterTest extends TestCase
{
    public function testRouteDispatchCallsAction(): void
    {
        $router = new Router();
        $router->add('GET', '/dummy-test', [DummyController::class, 'dummyAction']);
        
        DummyController::$called = false;
        $router->dispatch('/dummy-test', 'GET');
        
        $this->assertTrue(DummyController::$called);
    }

    public function testRouteNotFoundThrowsException(): void
    {
        $router = new Router();
        
        $this->expectException(\Exception::class);
        $this->expectExceptionCode(404);
        
        $router->dispatch('/non-existent-route-path', 'GET');
    }
}
