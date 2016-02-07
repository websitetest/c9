<?php
namespace src\Framework\lib\Authentication\Provider;

interface UserProvider {
    
    public function loadUserByUsername($username);
}
?>