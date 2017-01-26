# Readme

This project requires PHP v7 or later.

Please run `composer install` when downloaded to install the small number of components I have used.

I have an ansible build for vagrant in the repo. Download and install ansible, then run `vagrant up` from the command line.

For some reason, nginx never starts properly on vagrant + ansible, so it will need starting in the vm.

```
vagrant ssh
sudo systemctl start nginx
exit
```

The `/app/data` folder and `/app/data/users` folder need to be writable by PHP. The latter is where the users are saved to as I didn't want to get into a database in this project.

The project is available at `http://local.registration` which is bound to the vm IP address of `192.168.88.197`. This will need adding to your hosts file to work.

## Testing

Tests can be run using `./vendor/bin/phpunit`.

I only have tests for the value objects as I didn't want to run out of time, but I believe this will sufficiently display my knowledge of TDD and testing in general.

## Components

I decided to use the following components to make things quicker.

- Auryn Injector - A small dependency injector to make simple work of defining dependency implementations.
- Zend Framework Diactoros - A small lightweight HTTP server for a Request and Response lifecycle.
- FastRoute - A lightweight routing library for HTTP requests.
- Ramsey's UUID - Simple Unique Identifiers library.
- Mustache - A simple templating library.

## End Result

Unfortunately, I have been unable to complete this but achieved 99% of it. The JS validation for passwords has been left as it got to 2330 and I am exhausted after a 12hr work day before even working on this submission. All I can do is apologize.

- /public/index.php - the starting file
- /bootstrap.php - runs the dependency injector setup
- src - contains the PHP code

If there are any questions, please ask.

John.
