<?php
	// DB�ڑ����
	$dsn = 'mysql:dbname=schedule;host=localhost';
	$user = 'root';
	$password = '';

	try{
		$mysql_connect = new PDO($dsn, $user, $password);
	}catch (PDOException $e){
		var_dump($e);
		exit;
	}
?>