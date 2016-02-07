<?php

function autoloader($class) {
    
    $namespace = str_replace('\\', DIRSEP, $class);
    $path = BASE_PATH . DIRSEP . $namespace . ".php";
	
    if(file_exists($path)) {
        require_once($path);
    } else {
        
        echo "Er kon een bestand niet gevonden worden: " . $path;
		//echo '<pre>';
		//print_r(debug_backtrace(null, 3));
		//echo '</pre>';
    }
}

spl_autoload_register("autoloader");

?>