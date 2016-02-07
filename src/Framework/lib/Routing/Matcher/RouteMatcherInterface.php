<?php
namespace src\Framework\lib\Routing\Matcher;

interface RouteMatcherInterface {
    
    public function match($pathinfo);
}

?>