<?php
    if($_SESSION['loggedin'] !== true){
        if($_SERVER ['SCRIPT_NAME'] == 'login.php'){
            return;
        }
        header("location: login.php");
		exit;
    }
?>