<?php

include 'config/config.php';
include 'vendor/autoload.php';

use src\Framework\lib\Routing\RouteCollection;
use src\Framework\lib\Routing\Route;
use src\Framework\lib\AppCore\AppCore;
use src\Framework\lib\HTTP\Request;
use src\Framework\lib\Routing\Router;
use src\Framework\lib\Routing\Matcher\RouteMatcher;

$request = Request::createFromGlobals();

$routes = new RouteCollection();

$routes->add(new Route('default', '', 'DefaultController', 'defaultAction'));
$routes->add(new Route('login', 'login', 'LoginController', 'defaultAction'));
$routes->add(new Route('basket_add', 'basket/add/:id/:debug', 'BasketController', 'addProduct'));
$routes->add(new Route('basket_remove', 'basket/remove/:id', 'BasketController', 'removeProduct'));


$router = new Router();
$matcher = new RouteMatcher();
$matcher->setRoutes($routes);
$router->setMatcher($matcher);

$app = new AppCore();
//$app->setRoutes($routes);
//$app->handleRequest($request);
//$app->output();

try {
    $r = $router->match($_GET['r']);
    //var_dump($r);
    $app->handle($request, $r[0], $r[1]);
    
} catch(\Exception $e) {
    echo $e->getMessage();
}

/*

*/
?>