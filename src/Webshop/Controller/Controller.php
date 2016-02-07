<?php
namespace src\Webshop\Controller;
use src\Framework\lib\HTTP\Request;

class Controller {
    
    protected $container;
    
    public function __construct(Request $request) {
        
        
    }
    
    protected function loadView($fileName, $data = array()) {
        
        extract($data);
        include $fileName;
    }
    
    protected function createForm() {
        
    }
    
    protected function redirect($routeName) {
        
    }
    
    protected function isCsrfTokenValid() {
        
        
    }
    
    protected function getUser() {
        
    }
    
    protected function isGranted() {
        
    }
}
?>