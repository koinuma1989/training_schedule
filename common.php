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
	
	//ユーザー名の重複チェック　重複あり/なし:true/false idがある場合はそのidのnameであれば重複していないこととする
	function isDuplicateUserName($name, $id = false){
		$mysql_connect = db_connect();
		$sql = "SELECT id, name FROM users WHERE name = :name";
        $stmt = $mysql_connect->prepare($sql);
        $stmt->bindValue('name', $name, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($result && $result['id'] != $id){
        	return 'true';
        }
        return false;
	}
	
	// 引数で指定したpassと、idで引っ張ってきたpassを比較して、合致した/合致しない:true/false
	function passwordVerify($id, $check_pass){
		$mysql_connect = db_connect();
		$sql = "SELECT pass FROM users WHERE id = :id";
        $stmt = $mysql_connect->prepare($sql);
        $stmt->bindValue('id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($result && $result['pass'] == $check_pass){
        	return 'true';
        }
        return false;
	}

	//ログアウト
	function logout(){
		unset($_SESSION["loggedin_id"]);
	}
?>