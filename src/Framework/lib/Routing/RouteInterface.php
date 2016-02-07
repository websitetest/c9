<?php
namespace src\Framework\lib\Routing;

interface RouteInterface {
    
    public function getName();
    public function getPath();
    public function getControllerName();
    public function getActionName();
}