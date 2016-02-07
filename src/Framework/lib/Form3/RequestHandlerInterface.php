<?php
namespace src\Framework\lib\Form2;
use src\Framework\lib\Form2\FormInterface;

/**
 * Submits forms if they were submitted
 */

interface RequestHandlerInterface {
    
    public function handleRequest(FormInterface $form, $request = null);
}
?>