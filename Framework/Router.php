<?php

namespace Framework;
use App\Controllers\ErrorController;

class Router {
    // This will be an associative array to the routes given 
    protected $routes = [];
    /**
     * Add a new route
     * @param string $method
     * @param string $uri
     * @param string $action
     * @return void
     */
    public function registerRoute($method, $uri, $action){
        list($controller, $controllerMethod) = explode('@', $action);

        // Adds to the array
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod
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
     * Route the request
     * 
     * @param string $uri
     * @param string $method
     * @return void
     */
    public function route($uri){
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        foreach($this->routes as $route){
            // Spliting the current URI into segments
            $uriSegments = explode('/', trim($uri, '/'));
            // Spliting the route URI into segments
            $routeSegments = explode('/', trim($route['uri'], '/'));
            

            $match = true;

            // Check if the number of segments matches
            if(count($uriSegments) === count($routeSegments) && strtoupper($route['method'] === $requestMethod)){
                $params = [];

                $match = true;

                for($i = 0; $i < count($uriSegments); $i++){
                    if($routeSegments[$i] !== $uriSegments[$i] && !preg_match('/\{(.+?)\}/', $routeSegments[$i])){
                        $match = false;
                        break;
                    }
                    // Check for params and add to the $params array
                    if(preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches )){
                        $params[$matches[1]] = $uriSegments[$i];
                    }
                }
                
                if($match){
                    //  Extracts the controller and controller method
                $controller = 'App\\Controllers\\' . $route['controller'];
                $controllerMethod = $route['controllerMethod'];

                // Instatiate the controller and call method
                $controllerInstance = new $controller();
                $controllerInstance->$controllerMethod($params);
                return;
                }

            }

            
        }
        ErrorController::notFound();
        
    }
}