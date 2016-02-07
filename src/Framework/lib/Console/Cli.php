<?php
namespace src\Framework\lib\Terminal;
use src\Framework\lib\Terminal\Colors;

class Cli {
    
    protected $colorer;
    
    public function __construct() {
        
        $this->colorer = new Colors();
    }
    
    public function output($text) {
        
        echo $text;
    }
    
    public function coloredOutput($string, $colorName, $bgColorName) {
        
        echo $this->colorer->coloredString($string, $colorName, $bgColorName);
    }
    
    public function drawLine($length = 30) {
        
        echo PHP_EOL . str_repeat('-', $length) . PHP_EOL;
    }
}
?>