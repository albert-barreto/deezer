# Deezer Test Tech Application

Deezer Test Tech Application Notification Center

#### API ENDPOINTS

When the application is running in development, you can check the endpoints with all the notifications.

### Requirements

#### Local Environment
* PHP
* MySQL
* Composer

#### Docker Environment
* Docker

You can also run the application, and the database using the Docker environment. In that way, it's not necessary to install the requirements on your local machine.

## Run Application
In the root directory of the project, download and install dependencies with composer:
```shell
composer -v install
```
    
To run the application in local environment, you can run these commands 

```bash
composer start
```

Or, run the application in containers, start your Docker environment and from the root directory of the project, run the command: 

```shell
docker-compose up -d
```

After that, open `http://localhost:8787` in your browser.

### Run tests
Run PHPUnit through composer alias:

```shell
composer test
```

#### Framework and libraries
Composer is used for Dependency management
- Config file: [composer.json]()
- Docs: [https://getcomposer.org/doc/01-basic-usage.md]()

Libraries inside PHP application:
- Slim framework for API request handling: [https://www.slimframework.com/docs/v3/]()
- PDO for database access: [https://phpdelusions.net/pdo]()
- Monolog for logging: [https://github.com/Seldaek/monolog]()

Docker is used to run the application inside the containers.
- Docker for containers: https://www.docker.com/
- Docker Hub to retrieve the images: https://hub.docker.com/

