<?php
namespace src\Framework\lib\Form;
use src\Framework\lib\Form\FormInterface;


/*
* @see https://github.com/symfony/form/blob/master/FormInterface.php
*/
interface FormIntrface {
    
    public function setParent(FormIntrface $parent = null);
    public function getParent();
    public function add($child, $type = null, array $options = array());
    public function get($name);
    public function has($name);
    public function remove($name);
    
    /* return all children in this group */
    public function all();
    
    public function getErrors();
    
    public function isRoot();
}
?>