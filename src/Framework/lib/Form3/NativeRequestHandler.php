<?php
namespace src\Framework\lib\Form2;
use src\Framework\lib\Form2\RequestHandlerInterface;
use src\Framework\lib\Form2\FormInterface;
use src\Framework\lib\Form2\Exception\UnexpectedTypeException;

/**
 * @link https://github.com/symfony/form/blob/master/NativeRequestHandler.php
 */
 
class NativerequestHandler implements RequestHandlerInterface {
    
    public function handleRequest(FormInterface $form, $request = null) {
        
        if($request !== null) { // $request should be null
            
            throw new UnexpectedTypeException($request, 'null');
        }
        
        
        $name = $form->getName();
        $method = $form->getConfig()->getMethod();
        
        if($method !== self::getRequestMethod()) {
            
            return;
        }
        
        $data = $_POST;
        
        // don't auto-submit the form unless at least one field is present.
        if ('' === $name && count(array_intersect_key($data, $form->all())) <= 0) {
            return;
        }
        
        $form->submit($data, false);
    }
    
    private static function getRequestMethod() {
        
        $method = isset($_SERVER['REQUEST_METHOD'])
            ? strtoupper($_SERVER['REQUEST_METHOD'])
            : 'GET';
            
        if ('POST' === $method && isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])) {
            $method = strtoupper($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']);
        }
        
        return $method;
    }
}
?>