<?php
namespace src\Framework\lib\AppCore;
use src\Framework\lib\HTTP\Request;
use src\Framework\lib\Routing\RouteCollectionInterface;
use src\Framework\lib\Routing\RouteInterface;
use src\Framework\lib\Routing\Router;
use src\Framework\lib\Routing\Matcher\RouteMatcher;
use src\Framework\lib\AppCore\Exception\MethodNotFoundException;
use src\Framework\lib\AppCore\Exception\ClassNotFoundException;

class AppCore {
    
    protected $request;
    protected $response;
    protected $routes;
    
    public function __construct() {
        
        //$this->router = new Router();
        //$matcher = new RouteMatcher();
        //$matcher->setRoutes($this->routes);
    }
    
    public function loadController(Request $request, $controllerPath, $actionName, $params) {
        
       
    }
    
    public function setRoutes(RouteCollectionInterface $collection) {
        
        $this->routes = $collection;
    }
    
    public function handleRequest(Request $request) {
        
        echo $request->pathInfo();
    }
    
    public function output() {
        
        ob_start();
        echo 'Test output from AppCore';
        ob_end_flush();
    }
    
    public function handle(Request $request, RouteInterface $route, $varValues) {
        
        $controllerName = 'src\Webshop\Controller\\' . $route->getControllerName();
        $action = $route->getActionName();
        $varArray = $varValues;
        
        $controller = new $controllerName;
        
        if( ! is_object($controller)) { // Actually this check does nothing, autoloader causes already an error if the class doesn't exist
            throw new ClassNotFoundException('Controller ' . $controllerName . ' not found.');
        }
        
        if( ! method_exists($controller, $action)) {
            throw new MethodNotFoundException('Method not found. Controller: ' . $controllerName . ' action: ' . $action);
        }
        
        call_user_func_array(array($controller, $action), $varArray);
    }
}
?>