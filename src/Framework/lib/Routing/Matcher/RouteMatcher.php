<?php
namespace src\Framework\lib\Routing\Matcher;
use src\Framework\lib\Routing\Matcher\RouteMatcherInterface;
use src\Framework\lib\Routing\RouteCollectionInterface;
use src\Framework\lib\Routing\RouteInterface;
use src\Framework\lib\Routing\Exception\RouteNotFoundException;


class RouteMatcher implements RouteMatcherInterface {
    
    protected $routes;
    
    public function setRoutes(RouteCollectionInterface $collection) {
        
        $this->routes = $collection;
    }
    
    public function match($pathinfo) {
        
        $routes = $this->routes->getRoutes();
        
        foreach($routes as $route) {
            
            $matchedRoute = $this->matchRoute($pathinfo, $route);
            if($matchedRoute !== false) {
                //return $route;
                //echo 'found!!!!!!';
                return $matchedRoute; //  returns array($route, array $varValues);
            }
        }
        
        throw new RouteNotFoundException('Route not found, pathinfo: "' . $pathinfo . '"');
    }
    
    public function matchRouteSingle($pathinfo, $route) {
        
        $pathinfoSegments = explode('/', $pathinfo);
        $routeSegments = $routeSegments = explode('/', trim($route->getPath(), '/'));
		
		foreach($pathinfoSegments as $index => $segment) {
			
			echo "<b>Foreach through route parts</b><br>";
			
			if( ! isset($routeSegments[$index])) {
				echo "NOT SET <br>";
				return false;
				
				
			}
			
			$pathPart = trim($segment, '/');
			$routePart = trim($routeSegments[$index], '/');
			
			
			if(count($pathinfoSegments) != count($routeSegments)) {
				echo "COUNT NOT MATCHING <br>";
				return false;
				
				
			}
			

			$isVar = (substr($routePart, 0, 1) == "{" && substr($routePart, -1) == "}");
			
			//echo "IS VAR ? ";
			//echo $isVar ? 'TRUE' : "false";
			//echo '<br>';
			
			if($isVar) {
				
				$varname = substr($routePart, 1, -1);
				$req = $route->getRequirements();
				
				if(isset($req['vars'][$varname])) {
					
					$type = $req['vars'][$varname];
					
					// check wether input var type matches route var type
					
					if($type == "number" || $type == "int") {
						
						if( ! is_numeric($pathPart)) {
							
							return false;
						}
					}
					
					if(is_callable($type)) {
						
						$res = call_user_func($type, $pathPart);
						
						if( true !== $res) {
							
							return false;
						}
					}
					
					// end of checking vars
				}
				
			} else {
				
				if($pathPart != $routePart) {
					echo "PATHPART not routepart<br>";
					return false;
					
				}
			}
		}
		
		return true;
    }
    
    public function matchRoute($pathinfo, $route) {
        
        $pathinfo = trim($pathinfo, '/');
        $rp = trim($route->getPath(), '/');
        
        $routeParts = explode('/', $rp);
        $urlParts = explode('/', $pathinfo);
        $requirements = $route->getRequirements();
        
        $varValues = array();
        
        $d = false; // debug
        
        for($i = 0; $i < count($routeParts); $i++) {
            
            $routePart = $routeParts[$i];
            
            
            if( ! isset($urlParts[$i])) {
                
                if(substr($routePart, 0, 1) == ':') {
                    
                    $varname = substr($routePart, 1);
                    
                    if(isset($requirements['vars'][$varname])) {
                        
                        $varReq = $requirements['vars'][$varname];
                        
                        if(isset($varReq['required']) && $varReq['required'] == true) {
                            
                            return false; // urlPart is missing, and it matters because the route is a required var
                        }
                        
                        if(isset($varReq['type']) && $varReq['type'] == 'number') {
                            
                            if( ! is_numeric($urlParts[$i])) {
                                
                                if($d) echo 'routepart is var and (but) not a number';
                                return false;
                            }
                        }
                        
                        $varValues[$varname] = $urlParts[$i];
                        
                    }
                    
                    $varValues[$varname] = $urlParts[$i];
                    
                } else {
                    
                    if($d) echo 'urlpart is missing, and corresponding routepart is not a var<br>';
                    return false; // urlPart is missing, and it matters because the route is NOT a var
                }
                
                
            } else {
                
                $urlPart = $urlParts[$i];
                
                if(substr($routePart, 0, 1) == ':') {
                    
                    $varname = substr($routePart, 1);
                    
                    if(isset($requirements['vars'][$varname])) {
                        
                        $varReq = $requirements['vars'][$varname];
                        
                        if(isset($varReq['type']) && $varReq['type'] == 'number') {
                            
                            if( ! is_numeric($urlPart)) {
                                
                                if($d) echo 'routepart != numeric';
                                return false;
                            }
                        }
                        if(isset($varReq['min_length'])) {
                            
                            if(strlen($urlPart) < $varReq['min_length']) {
                                
                                if($d) echo 'min_length';
                                return false;
                            }
                        }
                        
                        $varValues[$varname] = $urlPart;
                    }
                    
                    $varValues[$varname] = $urlPart;
                    
                } else {
                    
                    if($routePart != $urlPart) {
                        
                        if($d) echo 'routepart != urlpart';
                        return false;
                    }
                }
            }
        }
        
        return array($route, $varValues);
    }
}

?>