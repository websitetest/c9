<?php
namespace src\Framework\lib\Routing\Mapping;
use src\Framework\lib\Routing\Mapping\ClassRoutingDataInterface;

interface RouteLoadableInterface {
    
    public function loadRouteData(ClassRoutingDataInterface $routeDataClass);
}
?>