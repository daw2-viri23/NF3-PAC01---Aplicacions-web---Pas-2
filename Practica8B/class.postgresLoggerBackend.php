<?php





$connectionString = "file:c:/Users/Administrator/Desktop/pruebaphp.txt";

//$connectionString = "pgsql:dbname=film;host=localhost;port=5432";


$urlData = parse_url($connectionString);

var_dump($urlData);

if (!isset($urlData['scheme'])) {
  throw new Exception("Conexion Invalida.\n");
}

$fileName = 'class.' . $urlData['scheme'] . 'LoggerBackend.php';

include_once($fileName);
return $fileName;
$className = 'Logger';

print "Class Name: " . $className . "\n";

if (!class_exists($className)) {
  throw new Exception("No loggind bakend available for " . $urlData['scheme']);
}

$objBack = new $className($urlData);

print "Logger " . $urlData['scheme'] . " created.";

$objBack->logMessage("Mensaje 1 de advertencia");
$objBack->logMessage("Mensaje 2 de advertencia");
$objBack->logMessage("Mensaje 3 de advertencia");


?>