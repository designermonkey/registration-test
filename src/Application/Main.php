<?php

namespace Example\Application;

use Auryn\Injector;
use FastRoute\RouteCollector;
use FastRoute\Dispatcher;
use Example\Application\Http\RouteDispatcher;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class Main
{
    /**
     * @var Injector
     */
    private $injector;

    /**
     * @var RouteCollector
     */
    private $collector;

    /**
     * @var RouteDispatcher
     */
    private $dispatcher;

    /**
     * @param RouteCollector  $collector
     * @param RouteDispatcher $dispatcher
     */
    public function __construct(Injector $injector, RouteCollector $collector, RouteDispatcher $dispatcher)
    {
        $this->injector = $injector;
        $this->collector = $collector;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param string|string[] $httpMethod
     * @param string $route
     * @param mixed  $handler
     */
    public function addRoute($httpMethod, $route, $handler)
    {
        $this->collector->addRoute($httpMethod, $route, $handler);
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $httpMethod = $request->getMethod();
        $uri = $request->getUri()->getPath();
        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);

        return $this->isRouteNotFound($routeInfo)
            ? $this->routeNotFound($response)
            : $this->isMethodNotAllowed($routeInfo)
                ? $this->methodNotAllowed($response)
                : $this->routeFound($request, $response, $routeInfo);
    }

    /**
     * @param  array  $routeInfo
     * @return bool
     */
    private function isRouteNotFound(array $routeInfo): bool
    {
        return Dispatcher::NOT_FOUND === $routeInfo[0];
    }

    /**
     * @param  array  $routeInfo
     * @return bool
     */
    private function isMethodNotAllowed(array $routeInfo): bool
    {
        return Dispatcher::METHOD_NOT_ALLOWED === $routeInfo[0];
    }

    /**
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    private function routeNotFound(ResponseInterface $response): ResponseInterface
    {
        return $response->withStatus(404);
    }

    /**
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    private function methodNotAllowed(ResponseInterface $response): ResponseInterface
    {
        return $response->withStatus(405);
    }

    /**
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @param  array                  $routeInfo
     * @return ResponseInterface
     */
    private function routeFound(ServerRequestInterface $request, ResponseInterface $response, array $routeInfo): ResponseInterface
    {
        $handler = $this->injector->make($routeInfo[1]);
        $args = $routeInfo[2];

        return $handler($request, $response, $args);
    }
}
