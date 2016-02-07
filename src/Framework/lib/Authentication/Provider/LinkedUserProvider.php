<?php
namespace src\Framework\lib\Authentication\Provider;
use src\Framework\lib\Authentication\Provider\UserProviderInterface;
use src\Framework\lib\Authentication\Exception\OperationNotSupportedException;

class LinkedUserProvider implements UserProviderInterface {
    
    protected $providers = array();
    
    public function __construct(array $providers = array()) {
        
        $this->providers = $providers;
    }
    
    public function addProvider(UserProviderInterface $provider) {
        
        $this->providers[] = $provider;
    }
    
    public function getProviders() {
        
        return $this->providers;
    }
    
    public function loadUserByUsername($username) {
        
        $user = $this->getUser($username);
        if($user !== null) {
            return $user;
        }
        return null;
    }
    
    protected function getUser($username) {
        
        foreach($this->providers as $provider) {
            
            $user = $provider->loadUserByUsername($username);
            if($user !== null) {
                
                return $user;
            }
        }
        return null;
    }
}