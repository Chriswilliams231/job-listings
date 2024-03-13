<?php 
require '../helpers.php';

// Creating a autoloader
spl_autoload_register(function($class) {
    $path = basePath('Framework/' . $class . '.php');
    if(file_exists($path)){
        require $path;
    }
});


// Instatiate the router
$router = new Router();
// Get the routes
$routes = require basePath('routes.php');
// Get the current URI and HTTP method
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
// Routes the request
$router->route($uri, $method);