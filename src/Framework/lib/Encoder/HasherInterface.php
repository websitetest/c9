<?php
namespace src\Framework\lib\Encoder;

interface HasherInterface {
    
    public function createHash($string, $salt);
}