<?php
namespace src\Webshop\Controller;
use src\Webshop\Controller\Controller;

class ProductViewController extends Controller {
    
    public function __construct() {
        
    }
    
    public function viewProduct() {
        
        $data = array(
            'subview' => 'view-product.php',
            'product_id' => $product['id'],
            'product_name' => $product['name'],
            'product_price' => $product['price']
        );
        
        $this->loadView('view/index.php', $data);
    }
}
?>