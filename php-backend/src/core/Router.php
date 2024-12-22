<?php

require_once $globals['routes'].'/routes.php';

class Router {
    public static function handleRequest(){

        global $routes;
        
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = trim($uri, '/');
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $uri, $matches)) {
                array_shift(array: $matches); // Remove the full match
                call_user_func_array($route['handler'], args: $matches);
                return;
            }
        }

        // If no route matches
        API_Response("Page Not Found", false, 404);
    }
}


// Handle the routes
Router::handleRequest();
