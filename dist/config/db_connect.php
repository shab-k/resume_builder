<?php 

$config = parse_ini_file('../../../../private/config.ini'); 
// Set DSN

$dsn = 'mysql:host='. $config['host'] .';dbname='. $config['dbname'];

// Create a PDO instance
$pdo = new PDO($dsn, $config['user'], $config['password']);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

?>
