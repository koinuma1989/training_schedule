<?php
	function db_connect(){
		// DBРЏС±ПоХс
		$dsn = 'mysql:dbname=schedule;host=localhost';
		$user = 'root';
		$password = '';

		try{
			return new PDO($dsn, $user, $password);
		}catch (PDOException $e){
			var_dump($e);
			exit;
		}
	}
?>