<?php

namespace Framework;

class Router {
    // This will be an associative array to the routes given 
    protected $routes = [];

    public function registerRoute($method, $uri, $controller){
        // Adds to the array
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller
        ];
    }
    /**
     * Add a GET route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function get($uri, $controller){
        $this->registerRoute('GET', $uri, $controller);
    }
    /**
     * Add a POST route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function post($uri, $controller){
        $this->registerRoute('POST', $uri, $controller);
    }
    /**
     * Add a PUT route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function put($uri, $controller){
        $this->registerRoute('PUT', $uri, $controller);
    }
    /**
     * Add a DELETE route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function delete($uri, $controller){
        $this->registerRoute('DELETE', $uri, $controller);
    }

     /**
     * Load error page
     * 
     * @param int $httpCode
     * 
     * @return void
     */
    public function error($httpCode = 404){
        http_response_code($httpCode);
        loadView("error/{$httpCode}");
        exit;
    }

    /**
     * Route the request
     * 
     * @param string $uri
     * @param string $method
     * @return void
     */
    public function route($uri, $method){
        foreach($this->routes as $route){
            if($route['uri']== $uri && $route['method'] == $method){
                require basePath('App/' . $route['controller']);
                return;
            }
        }

        $this->error();
    }
}