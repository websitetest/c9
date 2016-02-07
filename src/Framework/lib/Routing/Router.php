<?php
namespace src\Framework\lib\Routing;
use src\Framework\lib\Routing\RouteCollectionInterface;
use src\Framework\lib\Routing\Matcher\RouteMatcherInterface;
use src\Framework\lib\Routing\Exception\LogicException;
use src\Framework\lib\HTTP\Request;

class Router {
    
    protected $routes = null;
    protected $matcher = null;
    
    public function __construct(RouteMatcherInterface $matcher = null, RouteCollectionInterface $routes = null) {
        
        $this->routes = $routes;
    }
    
    public function setMatcher(RouteMatcherInterface $matcher) {
        
        $this->matcher = $matcher;
    }
    
    public function getMatcher() {
        
        return $this->matcher;
    }
    
    public function setRoutes(RouteCollectionInterface $routes) {
        
        $this->routes = $routes;
    }
    
    public function getRoutes() {
        
        return $this->routes;
    }
    
    public function addRoute(RouteInterface $route) {
        
        if($this->routes instanceof RouteCollectionInterface) {
            $this->routes->add($route);
        } else {
            $this->routes = $route;
        }
    }
    
    public function addRouteCollection(RouteCollectionInterface $routes) {
        
        if($this->routes instanceof RouteCollectionInterface) {
            $this->routes->addCollection($routes);
        } else {
            $this->routes = $routes;
        }
    }
    
    public function matchRequest(Request $request) {
        
        if( ! $this->matcher instanceof RouteMatcherInterface) {
            
            throw new LogicException('The Router has no route matcher, Router needs a RouteMatcherInterface instance');
        }
        
        return $this->matcher->match($request->pathInfo());
    }
    
    public function match($path) {
        
        if( ! $this->matcher instanceof RouteMatcherInterface) {
            
            throw new LogicException('The Router has no route matcher, Router needs a RouteMatcherInterface instance');
        }
        
        return $this->matcher->match($path);
    }
    
    public function generate($name) {
        
        $this->generator->generate($name);
    }
}
?>