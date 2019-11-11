<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'test_db';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
if(! $conn ){
	echo 'Connected failure<br>';
}
echo 'Connected successfully\n';
$sql = "DROP DATABASE IF EXISTS test_db";
mysqli_query($conn, $sql);

$sql = "CREATE DATABASE IF NOT EXISTS test_db CHARACTER SET utf8";
if (mysqli_query($conn, $sql)) {
	mysqli_close($conn);
	
	$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	mysqli_set_charset($conn, "utf8");
	echo "Database created successfully";
	$sql = "CREATE TABLE IF NOT EXISTS test_table(
				id INT AUTO_INCREMENT,
				name VARCHAR(40) NOT NULL,
				surname VARCHAR(40) NOT NULL,
				numberr INT NOT NULL,
				PRIMARY KEY (id)
			)";
	mysqli_query($conn, $sql);
	mysqli_close($conn);
} 
else {
	echo "Error creating database: " . mysqli_error($conn);
}
mysqli_close($conn);
?>