<?php
namespace src\Framework\lib\Form2\Exception\UnexpectedTypeException;
use \Exception;

class UnexpectedTypeException extends Exception {
    
    public function __construct($value, $expectedType) {
        
        parent::__construct('Unexpected argument type, passed: ' . $value . ', expected: ' . $expectedType);
    }
}