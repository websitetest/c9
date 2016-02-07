<?php

namespace src\Framework\lib\Database;
use src\Framework\lib\Database\DatabaseEngine;

class Database {
	
	private $engine;
	
	public function __construct(DatabaseEngine $engine) {
		
		$this->engine = $engine;
	}
    
    public function setEngine(DatabaseEngine $engine) {
        
        $this->engine = $engine;
    }
	
	public function connect() {
		
		$this->engine->connect();
	}
	
	public function query($queryString) {
		
		$this->engine->query($queryString);
	}
    
    public function bind($param, $value, $type = null) {
        
        $this->engine->bind($param, $value, $type);
    }
    
    public function execute($inputParams = null) {
        
        $this->engine->execute($inputParams);
    }
    
    public function single() {
		
		return $this->engine->single();
	}
    
    public function resultset() {
        
        return $this->engine->resultset();
    }
	
	// Returns the number if effected rows
	public function rowCount() {
		
		return $this->engine->rowCount();
	}
    
    public function debugDumpParams() {
        
        return $this->engine->debugDumpParams();
    }
    
    public function errorInfo() {
        
        return $this->engine->errorInfo();
    }
}

?>