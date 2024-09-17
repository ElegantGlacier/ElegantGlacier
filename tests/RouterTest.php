<?php

use PHPUnit\Framework\TestCase;
use ElegantGlacier\Router;

class RouterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $_SERVER['REQUEST_METHOD'] = 'GET'; // Default request method
        $_SERVER['REQUEST_URI'] = '/'; // Default request URI
    }

    public function testAddRoute()
    {
        $router = new Router();
        $router->addRoute('GET', '/test', function() { return 'test'; });

        // Access protected property for testing
        $reflection = new ReflectionClass($router);
        $property = $reflection->getProperty('routes');
        $property->setAccessible(true);

        $routes = $property->getValue($router);

        $this->assertArrayHasKey('GET', $routes);
        $this->assertArrayHasKey('/test', $routes['GET']);
        $this->assertIsCallable($routes['GET']['/test']);
    }

    public function testMatchRoute()
    {
        $router = new Router();
        $router->addRoute('GET', '/test', function() { echo 'Hello, Test'; });

        $_SERVER['REQUEST_URI'] = '/test';
        
        ob_start();
        $router->matchRoute();
        $output = ob_get_clean();

        $this->assertSame('Hello, Test', $output);
    }

    public function testMatchRouteWithParameters()
    {
        $router = new Router();
        $router->addRoute('GET', '/user/:id', function($id) { echo "User ID: $id"; });

        $_SERVER['REQUEST_URI'] = '/user/42';
        
        ob_start();
        $router->matchRoute();
        $output = ob_get_clean();

        $this->assertSame('User ID: 42', $output);
    }

    public function testMatchClassRoute()
    {
        $router = new Router();
        $router->addRoute('GET', '/item', 'TestController@TestAction');
        
        // Register a TestController instance with dependency injection
        $controller = new TestController();
        $router->setController($controller);

        $_SERVER['REQUEST_URI'] = '/item';
        
        ob_start();
        $router->matchClassRoute();
        $output = ob_get_clean();

        $this->assertSame('test action executed', $output);
    }

    public function testMatchClassRouteWithParameters()
    {
        $router = new Router();
        $router->addRoute('GET', '/item/:id', 'TestController@TestParam');
        
        // Register a TestController instance with dependency injection
        $controller = new TestController();
        $router->setController($controller);

        $_SERVER['REQUEST_URI'] = '/item/42';
        
        ob_start();
        $router->matchClassRoute();
        $output = ob_get_clean();

        $this->assertSame('the id is 42', $output);
    }
}

// Example Controller for testing purposes
class TestController
{
    public function TestAction()
    {
        echo 'test action executed';
    }

    public function TestParam($id)
    {
        echo 'the id is ' . htmlspecialchars($id);
    }
}
