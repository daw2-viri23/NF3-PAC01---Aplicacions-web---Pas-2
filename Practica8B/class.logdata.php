<?php
require("abstract.databoundobject.php");
require("class.fileLoggerBackend.php");
require("class.postgresLoggerBackend.php");
require("class.pdofactory.php");
class logData extends DataBoundObject{

    protected $messaje;
    protected $loglevel;
    protected $logdate;
    protected $module;

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
    

    
}

    $strDSN =   "pgsql:dbname=film;host=localhost;port=5432";
    $objPDO = PDOFactory::GetPDO($strDSN, "postgres", "root", array());
    $objPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $logger = new Logger($objPDO);

    echo "<br>" . $logger->logLevel;
   
    echo "<br>Nombre del fichero " . $logger->logFile;

    echo $logger->tiempo;


?>