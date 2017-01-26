<?php

namespace Example\Application\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;

use Example\UserContext\Api\UserValidationService;

class ValidateFields
{
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
        $method = 'validate' . $this->camelizeString($args['field']);
        $value = $request->getQueryParams()['value'];
        $result = call_user_func_array([$this->validationService, $method], [$value]);

        return new JsonResponse($result);
    }

    /**
     * @param  string $string
     * @return string
     */
    private function camelizeString(string $string): string
    {
        $words = preg_split('/[ _-]+/', $string);

        array_walk($words, function (&$word) {
            $word = strtoupper(substr($word, 0, 1)) . substr($word, 1);
        });

        return implode('', $words);
    }
}
