<?php
namespace src\Framework\lib\Routing\Mapping;
use src\Framework\lib\Routing\Mapping\ClassRoutingDataInterface;

class ClassRoutingData implements ClassRoutingDataInterface {
    
    protected $collection;
    
    public function setRoutes(RouteCollectionInterface $collection) {
        
        $this->collection = $collection;
    }
    
    public function addRoute(RouteInterface $route) {
        
        if( ! $this->collection instanceof RouteCollectionInterface) {
            $this->collection = new RouteCollection();
        }
        $this->collection->add($route);
    }
}

?>