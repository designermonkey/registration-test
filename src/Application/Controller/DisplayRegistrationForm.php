<?php

namespace Example\Application\Controller;

use Mustache_Engine;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class DisplayRegistrationForm
{
    /**
     * @var Mustache_Engine
     */
    private $templateEngine;

    public function __construct(Mustache_Engine $templateEngine)
    {
        $this->templateEngine = $templateEngine;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $response->getBody()->write($this->templateEngine->render('templates/form'));

        return $response;
    }
}
