<?php
namespace src\Webshop\Controller;
use src\Webshop\Controller\Controller;

class BasketController extends Controller {
    
    public function __construct() {
        
    }
    
    public function addProduct($product_id, $debug) {
        
        $jsonData = array(
            'product' => array(
                'id' => $product_id,
                'name' => 'TEST Productnaam van server',
                'price_integer' => 16,
                'price_decimals' => 95,
                'img_src' => '/view/img/jf-logo.jpg'
            )
        );
        
        if( ! isset($debug)) {
            echo json_encode($jsonData);
        } else {
            
            echo '<pre>' . json_encode($jsonData, JSON_PRETTY_PRINT) . '</pre>';
        }
        
        //echo 'Added product: ' . htmlentities($product_id);
    }
    
    public function removeProduct($product_id) {
        
        
    }
}
?>