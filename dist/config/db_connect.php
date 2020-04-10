<?php 
// // connect to the database
// $conn = mysqli_connect('localhost', 'Shabnam', 'test1234', 'resume_builder');

// // check connection
// if(!$conn){
// 	echo 'Connection error: '. mysqli_connect_error();
// }
//--------------- pdo -------------------
$host =  'localhost';
$user = 'Shabnam';
$password = 'test1234';
$dbname = 'resume_builder';

// Set DSN
$dsn = 'mysql:host='. $host .';dbname='. $dbname;

// Create a PDO instance
$pdo = new PDO($dsn, $user, $password);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
?>
