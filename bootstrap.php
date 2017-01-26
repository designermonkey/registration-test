<?php

require __DIR__.'/vendor/autoload.php';

define('APPLICATION_ROOT', __DIR__);

$injector = new Auryn\Injector;
$injector->share(Auryn\Injector::class);

$injector->delegate(Mustache_Engine::class, function () {
    return new Mustache_Engine([
        'loader' => new Mustache_Loader_FilesystemLoader(APPLICATION_ROOT . '/app/views', [
            'extension' => '.html'
        ]),
        'pragmas' => [
            Mustache_Engine::PRAGMA_BLOCKS,
            Mustache_Engine::PRAGMA_FILTERS,
        ],
        'helpers' => [],
        'charset' => 'UTF-8',
    ]);
});

$injector->alias(FastRoute\RouteParser::class, FastRoute\RouteParser\Std::class);
$injector->alias(FastRoute\DataGenerator::class, FastRoute\DataGenerator\GroupCountBased::class);

$injector->share(Mustache_Engine::class);
$injector->share(FastRoute\RouteCollector::class);


// Context related definition

$injector->define(Example\UserContext\Api\UserValidationService::class, [
    'passwordSpecification' => Example\UserContext\Model\PasswordIsNotBlockedSpecification::class
]);

$injector->define(Example\Application\Model\FileBasedUserRepository::class, [
    ':storageDirectory' => dir(APPLICATION_ROOT.'/app/data/users'),
    'userPorter' => Example\Application\Model\JsonUserPorter::class
]);
$injector->share(Example\Application\Model\FileBasedUserRepository::class);

$injector->define(Example\UserContext\Api\UserRegistrationService::class, [
    'userRepository' => Example\Application\Model\FileBasedUserRepository::class
]);

$injector->define(Example\UserContext\Model\PasswordIsNotBlockedSpecification::class, [
    ':fileLocation' => dir(APPLICATION_ROOT.'/app/data'),
    ':blockedPasswordsFileName' => 'password-blacklist.txt'
]);
