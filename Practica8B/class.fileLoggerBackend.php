<?php
require ("class.Config.php");

class Logger extends DataBoundObject{

  public $logFile;
  public $logLevel;
  public $mensaje;
  public $tiempo;
  public $module;

  

  //Log Levels.  The higher the number, the less severe the message
  //Gaps are left in the numbering to allow for other levels
  //to be added later
  const DEBUG     = 100;
  const INFO      = 75;
  const NOTICE    = 50;
  const WARNING   = 25;
  const ERROR     = 10;
  const CRITICAL  = 5;
  public function DefineTableName() {
    return("logdata");
}

public function DefineRelationMap(){
    return(array(
      
        "message" => "message",
        "loglevel" => "loglevel",
        "logdate" => "logdate",
        "module"=> "module"
    ));
}
  //Note: private constructor.  Class uses the singleton pattern
   public function __construct() {
    
    //This is pseudo code that fetches a hash of configuration information
    //Implementation of this is left to the reader, but should hopefully
    //be quite straight-forward.
    $cfg = new Config();
	  

    /* If the config establishes a level, use that level,
       otherwise, default to INFO
    */
    $this->logLevel = $cfg->getConfigLevel();
	$this->logFile = $cfg->getConfigFile();
	echo "file: ".$this->logFile;

    //We must specify a log file in the config
    if(! ( isset($this->logFile) && strlen($this->logFile)) ) {
      throw new Exception('No log file path was specified ' .
                          'in the system configuration.');
    }
 
    //Open a handle to the log file.  Suppress PHP error messages.
    //We'll deal with those ourselves by throwing an exception.
    $this->confile = @fopen($this->logFile, 'a+');
    
    if(! is_resource($this->confile)) {
      throw new Exception("The specified log file $logFilePath " .
                   'could not be opened or created for ' .
                   'writing.  Check file permissions.');
    }
    
  }
  
  public function __destruct() {
    if(is_resource($this->confile)) {
      fclose($this->confile);
    }
  }

  public static function getInstance() {
  
    static $objLog;
    
    if(!isset($objLog)) {
      $objLog = new Logger();
      $tiempo = $time;
    }
    
    return $objLog;
  }

  

  public function logMessage($msg, $logLevel = Logger::INFO, $module = null) {
    
    if($logLevel > $this->logLevel) {
      return $this;
      
      
    }

  
    
    
    /* If you haven't specifed your timezone using the 
       date.timezone value in php.ini, be sure to include
       a line like the following.  This can be omitted otherwise.
    */
    date_default_timezone_set('America/New_York');

	
    $formatterDate = DateTimeImmutable::createFromFormat('U', time());
    $time = $formatterDate->format('Y-m-d H:i:s');
 
    

    

  

    //$time = strftime('%x %X', time());  deprecated ver. 8.1
    $msg = str_replace("\t", '    ', $msg);
    $msg = str_replace("\n", ' ', $msg);

    $strLogLevel = $this->levelToString($logLevel);
    
    if(isset($module)) {
      $module = str_replace("\t", '    ', $module);
      $module = str_replace("\n", ' ', $module);
    }
    
    //logs: date/time loglevel message modulename
    //separated by tabs, new line delimited
    $logLine = "$time\t$strLogLevel\t$msg\t$module\n";
    fwrite($this->confile, $logLine);

    
  }
  
  public static function levelToString($logLevel) {
    switch ($logLevel) {
      case Logger::DEBUG:
        return 'Logger::DEBUG';
        break;
      case Logger::INFO:
        return 'Logger::INFO';
        break;
      case Logger::NOTICE:
        return 'Logger::NOTICE';
        break;
      case Logger::WARNING:
        return 'Logger::WARNING';
        break;
      case Logger::ERROR:
        return 'Logger::ERROR';
        break;
      case Logger::CRITICAL:
        return 'Logger::CRITICAL';
        break;
      default:
        return '[unknown]';
    }
  }
  
    
  
}
?>