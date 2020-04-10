<?php 
// connect to the database
$conn = mysqli_connect('localhost', 'Shabnam', 'test1234', 'resume_builder');

// check connection
if(!$conn){
	echo 'Connection error: '. mysqli_connect_error();
}

?>
