<?php
namespace src\Webshop\Controller;
use src\Webshop\Controller\Controller;

class DefaultController extends Controller {
    
    public function __construct() {
        
    }
    
    public function defaultAction() {
        
        $this->loadView('view/index.php', array('subview' => 'product-overview.php'));
    }
}
?>