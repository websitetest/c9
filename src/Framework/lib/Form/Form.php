<?php
namespace src\Framework\lib\Form;

class Form implements FormInterface {
    
    protected $children = array();
    
    public function __construct() {
        
    }
    
    public function add(FormInterface $child, $type = null, array $options = array()) {
        
        $this->children[$child->getName()];
    }
}
?>