<?php

namespace Example\Application\Http;

use FastRoute\RouteCollector;
use FastRoute\Dispatcher\GroupCountBased;

class RouteDispatcher extends GroupCountBased
{
    /**
     * @var FastRoute\RouteCollector
     */
    private $collector;

    /**
     * @param RouteCollector $collector
     */
    public function __construct(RouteCollector $collector)
    {
        $this->collector = $collector;
    }

    /**
     * @param  string $httpMethod
     * @param  string $uri
     * @return array
     */
    public function dispatch($httpMethod, $uri)
    {
        list($this->staticRouteMap, $this->variableRouteData) = $this->collector->getData();

        return parent::dispatch($httpMethod, $uri);
    }
}
