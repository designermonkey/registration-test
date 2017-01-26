<?php

namespace Example\Application\Controller;

use Mustache_Engine;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

use Example\UserContext\Api\UserRegistrationService;
use Example\UserContext\Api\UserValidationService;

class RegisterUser
{
    use CanCapitalizeString;

    /**
     * @var UserRegistrationService
     */
    private $registrationService;

    /**
     * @var UserValidationService
     */
    private $validationService;

    /**
     * @var array
     */
    private $validationResult;

    /**
     * @var array
     */
    private $messages;

    /**
     * @var Mustache_Engine
     */
    private $templateEngine;

    /**
     * @param UserRegistrationService $registrationService
     * @param UserValidationService   $validationService
     */
    public function __construct(UserRegistrationService $registrationService, UserValidationService $validationService, Mustache_Engine $templateEngine)
    {
        $this->registrationService = $registrationService;
        $this->validationService = $validationService;
        $this->templateEngine = $templateEngine;
    }

    /**
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $request = $this->parseBody($request);
        $fields = $request->getParsedBody();
        $this->validateFields($request->getParsedBody());

        if (empty($this->validationResult)) {
            $this->registrationService->registerUser($fields);
            $this->messages[] = [
                'message' => 'User was registered.',
            ];
            // $fields = [];
        }

        $response->getBody()->write($this->templateEngine->render('templates/form', [
            'validation' => $this->validationResult,
            'messages' => $this->messages,
            'fields' => $fields,
        ]));

        return $response;
    }

    /**
     * @param  ServerRequestInterface $request
     * @return ServerRequestInterface
     */
    private function parseBody(ServerRequestInterface $request): ServerRequestInterface
    {
        $parsedBody = $request->getParsedBody();

        if (!empty($parsedBody)) {
            return $request;
        }

        $rawBody = (string) $request->getBody();

        if (empty($rawBody)) {
            return $request;
        }

        parse_str($rawBody, $parsedBody);

        return $request->withParsedBody($parsedBody);
    }

    /**
     * @param  array  $fields
     */
    private function validateFields(array $fields)
    {
        $fields = $this->prepareFields($fields);

        foreach ($fields as $field => $value) {
            $this->validateField($field, $value);
        }
    }

    /**
     * @param  string $field
     * @param  string $value
     */
    private function validateField(string $field, $value)
    {
        $method = 'validate' . $this->capitalizeString($field);

        if (method_exists($this->validationService, $method)) {
            $result = call_user_func_array([$this->validationService, $method], [$value]);

            if (!$result['valid']) {
                $this->validationResult[$field] = $result;
            }
        }
    }

    /**
     * @param  array  $fields
     * @return array
     */
    public function prepareFields(array $fields): array
    {
        // $fields['dateOfBirth'] = explode('/', $fields['dateOfBirth']);

        return $fields;
    }
}
