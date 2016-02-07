<?php
namespace src\Framework\lib\Form2;
use src\Framework\lib\Form2\FormInterface;

class Form implements FormInterface {
    
    protected $children = array();
    protected $errors = array();
    protected $submitted = false;
    protected $clickedButton = null;
    
    public function __construct() {
        
    }
    
    public function add($child, $type, array $options = array()) {
        
    }
    
    public function remove($name) {
        
        if($this->has($name)) {
            unset($this->children[$name]);
            return true;
        }
        return false;
    }
    
    public function has($name) {
        
        return isset($this->children[$name]);
    }
    
    public function isSubmitted() {
        
        return $this->submitted;
    }
    
    public function submit($submittedData) {
        
        if($this->submitted) {
            
            throw new \Exception('This form is already submitted');
        }
        
        $this->errors = array();
        
        foreach($this->children as $name => $child) {
            
            $child->submit($submittedData[$name]);
            
            if($this->clickedButton !== null) {
                continue;
            }
            
            if($child instanceof ClickableInterface && $child->isClicked()) {
                
                $this->clickedButton = $child;
                continue;
            }
            
            if (method_exists($child, 'getClickedButton') && $child->getClickedButton() !== null) {
                $this->clickedButton = $child->getClickedButton();
            }
        }
    }
    
    public function getErrors() {
        
    }
    
    public function handleRequest($request) {
        
        $this->getConfig()->getRequestHandler()->handleRequest($this, $request);
        return $this;
    }
    
    public function getClickedButton() {
        
        if($this->clickedButton) {
            
            return $this->clickedButton;
        }
        
        if ($this->parent && method_exists($this->parent, 'getClickedButton')) {
            return $this->parent->getClickedButton();
        }
    }
}
?>