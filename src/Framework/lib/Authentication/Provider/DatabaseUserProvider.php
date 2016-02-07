<?php
namespace src\Framework\lib\Authentication\Provider;
use src\Framework\lib\Authentication\Provider\UserProviderInterface;
use src\Framework\lib\Authentication\Exception\OperationNotSupportedException;

class DatabaseUserProvider implements UserProviderInterface {
    
    public function loadUserByUsername($username) {
        
        throw new OperationNotSupportedException('This class should be extended and this method, loadUserByUsername(), should be overridden');
    }
}