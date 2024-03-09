<?php 
require '../helpers.php';
require basePath('Router.php');
require basePath('Database.php');

// Instatiate the router
$router = new Router();
// Get the routes
$routes = require basePath('routes.php');
// Get the current URI and HTTP method
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
// Routes the request
$router->route($uri, $method);