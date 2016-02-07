<?php
namespace src\Framework\lib\Terminal;

class Colors {
    
    protected $colors;
    protected $background_colors;
    
    public function __construct() {
        
        $this->colors = array(
            'black' => '0;30',
            'dark_gray' => '1;30',
            'blue' => '0;34',
            'light_blue' => '1;34',
            'green' => '0;32',
            'light_green' => '1;32',
            'cyan' => '0;36',
            'light_cyan' => '1;36',
            'red' => '0;31',
            'light_red' => '1;31',
            'purple' => '0;35',
            'light_purple' => '1;35',
            'brown' => '0;33',
            'yellow' => '0;33',
            'light_gray' => '0;37',
            'white' => '1;37'
        );
        
        $this->background_colors = array(
            'black' => '40',
            'red' => '41',
            'green' => '42',
            'yellow' => '43',
            'blue' => '44',
            'magenta' => '45',
            'cyan' => '46',
            'light_gray' => '47'
        );
    }
    
    public function getColor($name) {
        
        $name = strtolower($name);
        
        if(isset($this->colors[$name])) {
            return "\033[" . $this->colors[$name] . "m";
        }
        return '';
    }
    
    public function getBackgroundColor($name) {
        
        $name = strtolower($name);
        
        if(isset($this->background_colors[$name])) {
            return "\033[" . $this->background_colors[$name] . "m";
        }
        return '';
    }
    
    public function coloredString($string, $colorName = null, $bgColorName = null) {
        
        if(isset($colorName)) {
            $string = $this->getColor($colorName) . $string;
        }
        
        if(isset($bgColorName)) {
            
            $string = $this->getBackgroundColor($bgColorName) . $string;
        }
        
        $string .= "\033[0m";
        
        return $string;
    }
}
?>