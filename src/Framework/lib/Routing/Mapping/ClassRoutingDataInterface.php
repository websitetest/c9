<?php
namespace src\Framework\lib\Routing\Mapping;
use src\Framework\lib\Routing\RouteInterface;
use src\Framework\lib\Routing\RouteCollectionInterface;

interface ClassRoutingDataInterface {
    
    public function setRoutes(RouteCollectionInterface $collection);
    public function addRoute(RouteInterface $route);
}