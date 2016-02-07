<?php
namespace src\Framework\lib\Encoder;

class HasherMD5 implements HasherInterface {
    
    public function createHash($string, $salt) {
        
        $hash = md5($string, $salt);
        return $hash;
    }
}