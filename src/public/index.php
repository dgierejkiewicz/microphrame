<?php

require_once '../Core/Router.php';
echo 'hello from microphrame v. 0.0.1';
echo PHP_EOL;

$router = new \Core\Router();

//echo get_class($router);

// Add routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('admin/{controller}/{action}');

echo '<pre>';
echo htmlspecialchars(print_r($router->getRoutes(), true));
echo '</pre>';

// Match the requested route
$url = $_SERVER['QUERY_STRING'];

if ($router->match($url)) {
    echo '<pre>';
    var_dump($router->getParams());
    echo '</pre>';
} else {
    echo "No route found for URL '$url'";
}