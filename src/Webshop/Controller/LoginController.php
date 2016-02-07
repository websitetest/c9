<?php
namespace src\Webshop\Controller;
use src\Webshop\Controller\Controller;

class LoginController extends Controller {
    
    public function __construct() {
        
    }
    
    public function defaultAction() {
        
        $data = array(
            'subview' => 'view-product.php'
        );
        $this->loadView('view/index.php', $data);
    }
}
?>