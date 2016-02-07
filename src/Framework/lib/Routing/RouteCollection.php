<?php
namespace src\Framework\lib\Routing;
use src\Framework\lib\Routing\RouteCollectionInterface;
use src\Framework\lib\Routing\RouteInterface;

class RouteCollection implements RouteCollectionInterface {
    
    public function __construct() {
        
    }
    
    public function add(RouteInterface $route) {
        
        $this->routes[] = $route;
    }
    
    public function getRoute($name) {
        
        foreach($this->routes as $route) {
            
            if($route->getName() == $name) {
                return $route;
            }
        }
        return null;
    }
    
    public function addCollection(RouteCollectionInterface $collection) {
        
        $this->routes = array_merge($this->routes, $collection->getRoutes());
    }
    
    public function getRoutes() {
        
        return $this->routes;
    }
}