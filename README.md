# Deezer Test Tech Application

Deezer Test Tech Application Notification Center

## Run Application
In the root directory of the project, download and install dependencies with composer:
    ```shell
    composer -v install
    
To run the application in development, you can run these commands 

```bash
composer start
```
After that, open `http://localhost:8787` in your browser.

#### API ENDPOINTS

When the application is running in development, you can check the endpoints with all the notifications.

### Requirements
* PHP
* MySQL
* Composer

#### Framework and libraries
Composer is used for Dependency management
- Config file: [composer.json]()
- Docs: [https://getcomposer.org/doc/01-basic-usage.md]()

Libraries inside PHP application:
- Slim framework for API request handling: [https://www.slimframework.com/docs/v3/]()
- PDO for database access: [https://phpdelusions.net/pdo]()
- Monolog for logging: [https://github.com/Seldaek/monolog]()

