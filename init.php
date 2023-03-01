<?php
	require_once "db_connect.php";
	require_once "common.php";
	require_once "const.php";
	
	session_start();

	//未ログインだったらlogin画面にリダイレクト
	if(!isset($_SESSION['loggedin']) && $_SERVER ['SCRIPT_NAME'] != '/training_schedule/login.php'){
		header("location: login.php");
		exit;
	}
?>