<?php
namespace src\Framework\lib\Form;
use src\Framework\lib\Form\FormInterface;

interface RequestHandlerInterface {
    
    public function handleRequest(FormInterface $form, $request);
}
?>