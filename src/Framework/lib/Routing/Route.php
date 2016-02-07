<?php
namespace src\Framework\lib\Routing;
use src\Framework\lib\Routing\RouteInterface;

class Route implements RouteInterface {
    
    protected $name;
    protected $path;
    protected $controller;
    protected $action;
    protected $options;
    
    public function __construct($name, $path, $controller, $action = null, array $options = array()) {
        
        $this->name = $name;
        $this->path = $path;
        $this->controller = $controller;
        $this->action = $action;
        $this->options = $options;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getPath() {
        return $this->path;
    }
    
    public function setPath($path) {
        $this->path = $path;
    }
    
    public function getControllerName() {
        return $this->controller;
    }
    
    public function setControllerName($controller) {
        $this->controller = $controller;
    }
    
    public function getActionName() {
        return $this->action;
    }
    
    public function setActionName($action) {
        $this->action = $action;
    }
    
    public function getRequirements() {
        
        return array();
    }
}