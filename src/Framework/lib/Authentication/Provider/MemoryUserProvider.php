<?php
namespace src\Framework\lib\Authentication\Provider;
use src\Framework\lib\Authentication\Provider\UserProviderInterface;
use src\Framework\lib\Authentication\Exception\UserNotFoundException;

class MemoryUserProvider implements UserProviderInterface {
    
    protected $users = array();
    
    public function __construct(array $users = array()) {
        
        $this->users = $users;
    }
    
    public function loadUserByUsername($username) {
        
        $user = $this->getUser($username);
        
        if($user !== null) {
            return new User();
        }
        
        throw new UserNotFoundException('User with username ' . $username . ' not found');
    }
    
    protected function getUser($username) {
        
        foreach($this->users as $user) {
            
            if($user['username'] == $username) {
                return $user;
            }
        }
        return null;
    }
}
?>