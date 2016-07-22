<?php

class cdb {
	/**
	 * The global $config object.
	 *
	 * @var object
	 * @access public
	 */
	public $config;
	
	/**
	 * The global $lang object.
	 *
	 * @var object
	 * @access public
	 */
	public $lang;
	
	/**
	 * The global $dbh object, the database connection handler.
	 *
	 * @var object
	 * @access private
	 */
	public $dbh;
	
	/**
	 * The slave database handler.
	 *
	 * @var object
	 * @access private
	 */
	public $slaveDBH;
	
	/**
	 * The root directory of log.
	 *
	 * @var string
	 * @access private
	 */
	private $logRoot;
	
	
	/**
	 * The construct function.
	 *
	 * Prepare all the paths, classes, super objects and so on.
	 * Notice:
	 * 1. You should use the createApp() method to get an instance of the router.
	 * 2. If the $appRoot is empty, the framework will comput the appRoot according the $appName
	 *
	 * @param string $appName   the name of the app
	 * @param string $appRoot   the root path of the app
	 * @access protected
	 * @return void
	 */
	public function __construct($config)
	{
		$this->logRoot = '';
		$this->config = $config;
	}
	
	
	/**
	 * Connect to database.
	 *
	 * @access public
	 * @return void
	 */
	public function connectDB()
	{
		global $dbh, $slaveDBH;
	
		if(isset($this->config->db->host))      $this->dbh      = $dbh      = $this->connectByPDO($this->config->db);
		if(isset($this->config->slaveDB->host)) $this->slaveDBH = $slaveDBH = $this->connectByPDO($this->config->slaveDB);
	}
	
	/**
	 * Connect database by PDO.
	 *
	 * @param  object    $params    the database params.
	 * @access private
	 * @return object|bool
	 */
	private function connectByPDO($params)
	{
		if(!isset($params->driver)) self::triggerError('no pdo driver defined, it should be mysql or sqlite', __FILE__, __LINE__, $exit = true);
		if(!isset($params->user)) return false;
		if($params->driver == 'mysql')
		{
			$dsn = "mysql:host={$params->host}; port={$params->port}; dbname={$params->name}";
		}
		try
		{
			$dbh = new PDO($dsn, $params->user, $params->password, array(PDO::ATTR_PERSISTENT => $params->persistant));
			$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$dbh->exec("SET NAMES {$params->encoding}");
			if(isset($params->strictMode) and $params->strictMode == false) $dbh->exec("SET @@sql_mode= ''");
			if(isset($params->checkCentOS) and $params->checkCentOS and helper::isCentOS())
			{
				$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
				$dbh->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
			}
			return $dbh;
		}
		catch (PDOException $exception)
		{
			self::triggerError($exception->getMessage(), __FILE__, __LINE__, $exit = true);
		}
	}
	
	//-------------------- Error methods.------------------//
	
	/**
	 * Trriger an error.
	 *
	 * @param string    $message    error message
	 * @param string    $file       the file error occers
	 * @param int       $line       the line error occers
	 * @param bool      $exit       exit the program or not
	 * @access public
	 * @return void
	 */
	public function triggerError($message, $file, $line, $exit = false)
	{
		/* Set the error info. */
		$log = "ERROR: $message in $file on line $line";
		if(isset($_SERVER['SCRIPT_URI'])) $log .= ", request: $_SERVER[SCRIPT_URI]";;
		$trace = debug_backtrace();
		extract($trace[0]);
		extract($trace[1]);
		$log .= ", last called by $file on line $line through function $function.\n";
	
		/* Trigger it. */
		trigger_error($log, $exit ? E_USER_ERROR : E_USER_WARNING);
	}
	
	/**
	 * Save error info.
	 *
	 * @param  int    $level
	 * @param  string $message
	 * @param  string $file
	 * @param  int    $line
	 * @access public
	 * @return void
	 */
	public function saveError($level, $message, $file, $line)
	{
		/* Skip the error: Redefining already defined constructor. */
		if(strpos($message, 'Redefining') !== false) return true;
	
		/* Set the error info. */
		$errorLog  = "\n" . date('H:i:s') . " $message in <strong>$file</strong> on line <strong>$line</strong> ";
		$errorLog .= "when visiting <strong>" . $this->getURI() . "</strong>\n";
	
		/* If the ip is pulic, hidden the full path of scripts. */
		if(RUN_MODE != 'shell' and !($this->server->server_addr == '127.0.0.1' or filter_var($this->server->server_addr, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE) === false))
		{
			$errorLog  = str_replace($this->getBasePath(), '', $errorLog);
			$errorLog  = str_replace($this->wwwRoot, '', $errorLog);
		}
	
		/* Save to log file. */
		$errorFile = $this->getLogRoot() . 'php.' . date('Ymd') . '.php';
	
		if(!file_exists($errorFile)) file_put_contents($errorFile, "<?php die();?> \n");
	
		$fh = @fopen($errorFile, 'a');
		if($fh) fwrite($fh, strip_tags($errorLog)) && fclose($fh);
	
		/* If the debug > 1, show warning, notice error. */
		if($level == E_NOTICE or $level == E_WARNING or $level == E_STRICT or $level == 8192) // 8192: E_DEPRECATED
		{
			if(!empty($this->config->debug) and $this->config->debug > 1)
			{
				$cmd  = "vim +$line $file";
				$size = strlen($cmd);
				echo "<pre class='alert alert-danger'>$message: ";
				echo "<input type='text' value='$cmd' size='$size' style='border:none; background:none;' onmouseover='this.select();' /></pre>";
			}
		}
	
		/* If error level is serious, die.  */
		if($level == E_ERROR or $level == E_PARSE or $level == E_CORE_ERROR or $level == E_COMPILE_ERROR or $level == E_USER_ERROR)
		{
			if(empty($this->config->debug)) die();
			if(PHP_SAPI == 'cli') die($errorLog);
	
			$htmlError  = "<html><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8' /></head>";
			$htmlError .= "<body>" . nl2br($errorLog) . "</body></html>";
			die($htmlError);
		}
	}
	
	/**
	 * Save the sql.
	 *
	 * @access protected
	 * @return void
	 */
	public function saveSQL()
	{
		if(!class_exists('dao')) return;
	
		$sqlLog = $this->getLogRoot() . 'sql.' . date('Ymd') . '.php';
	
		if(!file_exists($sqlLog)) file_put_contents($sqlLog, "<?php die();?> \n");
	
		$fh = @fopen($sqlLog, 'a');
		if(!$fh) return false;
		fwrite($fh, date('Ymd H:i:s') . ": " . $this->getURI() . "\n");
		foreach(dao::$querys as $query) fwrite($fh, "  $query\n");
		fwrite($fh, "\n");
		fclose($fh);
	}
	
	/**
	 * Get the $logRoot var
	 *
	 * @access public
	 * @return string
	 */
	public function getLogRoot()
	{
		return $this->logRoot;
	}
}

if(!class_exists('config')){class config{}}
$config = new config();
$config->db = new stdclass();
$config->db->persistant = false;               // Persistant connection or not.
$config->db->driver     = 'mysql';             // The driver of pdo, only mysql yet.
$config->db->encoding   = 'UTF8';              // The encoding of the database.
$config->db->strictMode = false;               // Turn off the strict mode.
$config->db->host     = '127.0.0.1';
$config->db->port     = '';
$config->db->name     = 'eastsoft';
$config->db->user     = 'root';
$config->db->password = '1q2w3e4r5t';
$config->db->prefix   = 'es_';
$config->db->domain   = 'http://112.65.161.3';
$dbh = new cdb($config);
$dbh->connectDB();
