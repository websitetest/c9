<?php

namespace src\Framework\lib\Database;

interface DatabaseEngine {
	
	public function connect($host, $dbname, $username, $password);
    public function query($queryString);
    public function bind($param, $value, $type);
    public function execute($inputParams);
    public function single();
    public function rowCount();
}
?>