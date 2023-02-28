<?php
	//CSRF
	function checkToken(){
	    if(empty($_SESSION['token']) || ($_SESSION['token'] != $_POST['token'])){
	        echo '?g?[?N?????s?????', PHP_EOL;
	        exit;
	    }
	}
	
	//v_d
	function v_d($v){
		echo('<pre>');
		var_dump($v);
		echo('</pre>');
	}
	
	//ユーザー名の重複チェック　重複あり/なし:true/false
	function isDuplicateUserName($name, $mysql_connect){
		$sql = "SELECT name FROM users WHERE name = :name";
        $stmt = $mysql_connect->prepare($sql);
        $stmt->bindValue('name', $name, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result){
        	return 'true';
        }
        return false;
	}

	//ログアウト
	function logout(){
		unset($_SESSION["loggedin"]);
	}
?>