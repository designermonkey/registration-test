<?php

namespace Example\Application\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;

use Example\UserContext\Api\UserValidationService;

class ValidateFields
{
    use CanCapitalizeString;

    /**
     * @var UserValidationService
     */
    private $validationService;

    public function __construct(UserValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    /**
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @param  array                  $args
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $method = 'validate' . $this->capitalizeString($args['field']);
        $value = $request->getQueryParams()['value'];
        $result = call_user_func_array([$this->validationService, $method], [$value]);

        return new JsonResponse($result);
    }
}
