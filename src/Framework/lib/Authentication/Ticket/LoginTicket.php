<?php
namespace src\Framework\lib\Authentication;

/**
 * LoginTicket this class contains credentials which 
 * have to be checked in the authentication.
 * If the LoginTicket data is accepted, because the
 * data exists in the database and belongs to an existing user,
 * then the authentication will return a LoginSession class
 */
class LoginTicket {
    
    protected $username;
    protected $plainPassword;
    
    /**
     * Can be username or email / phone number / firstname and/or lastname
     */
    public function setUsername($username) {
        
        $this->username = $username;
    }
    
    public function setPlainPassword($pwd) {
        
        $this->plainPassword = $pwd;
    }
    
    public function clear() {
        
        $this->username = null;
        $this->plainPassword = null;
    }
}
?>