<?PHP

namespace src\Framework\lib\Database;
use src\Framework\lib\Database\DatabaseEngine;
use \PDO;

class MysqlDatabasePDO implements DatabaseEngine {
	
	private $_host;
	private $_dbname;
	private $_user;
	private $_pass;
	
	private $_db;
	private $_stmt;
	private $_error;
	
	private static $queryCount = 0;
	
	public function __construct() {
		
		$this->_host = DB_HOST;
		$this->_dbname = DB_NAME;
		$this->_user = DB_USER;
		$this->_pass = DB_PWD;
		
		try {
            
			$dsn = 'mysql:host=' . $this->_host . ';dbname=' . $this->_dbname;
			
			// Options
			$options = array(
				PDO::ATTR_PERSISTENT	=> true,
				PDO::ATTR_ERRMODE		=> PDO::ERRMODE_EXCEPTION
			);
			
			$this->_db = new PDO($dsn, $this->_user, $this->_pass, $options);
			
		} catch(PDOException $e) {
			
			$this->_error = $e->getMessage();
            echo $e->getMessage();
		}
	}
    
    public function connect($host, $dbname, $username, $password) {
        
        $this->__construct();
    }
	
	public function query($query) {
		
		$this->_stmt = $this->_db->prepare($query);
		
		self::$queryCount++;
	}
	
	public function bind($param, $value, $type = null) {
		
		if(is_null($type)) {
			
			switch (true) {
				case is_int($value):
					$type = PDO::PARAM_INT;
				break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
				break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
				break;
				default:
					$type = PDO::PARAM_STR;
			}
		}
		
		$this->_stmt->bindValue($param, $value, $type);
	}
	
	// PDO::execute() is not similar to PDO::exec()
	public function execute($inputParams = null) {
		
		if(is_null($inputParams)) {
			
			return $this->_stmt->execute();
		} else {
			
			return $this->_stmt->execute($inputParams);
		}
	}
	
	public function resultset() {
		
		$this->execute();
		return $this->_stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function single() {
		
		$this->execute();
		return $this->_stmt->fetch(PDO::FETCH_ASSOC);
	}
	
	// Returns the number if effected rows
	public function rowCount() {
		
		return $this->_stmt->rowCount();
	}
	
	// Returns the last insert id
	public function lastInsertId() {
		
		return $this->_db->lastInsertId();
	}
	
	public function beginTransaction() {
		
		return $this->_db->beginTransaction();
	}
	
	// Transaction commit
	public function endTransaction() {
		
		return $this->_db->commit();
	}
	
	// Cancel transaction
	public function cancelTransaction() {
		
		return $this->_db->rollBack();
	}
	
	// Only for debugging!
	public function debugDumpParams() {
		
		return $this->_stmt->debugDumpParams();
	}
    
    public function errorInfo() {
        
        return $this->_db->errorInfo();
    }
}
?>