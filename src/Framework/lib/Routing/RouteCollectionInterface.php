<?php
namespace src\Framework\lib\Routing;

interface RouteCollectionInterface {
    
    public function add(RouteInterface $route);
    
    public function getRoute($name);
    
    public function addCollection(RouteCollectionInterface $collection);
    
    public function getRoutes();
}