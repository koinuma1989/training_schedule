<?php
	require_once "init.php";

	if(isset($_POST['token']) && isset($_SESSION['token']) && $_SESSION['token'] == $_POST['token']){
		if(isset($_POST['name']) && isset($_POST['password']) && isset($_POST['role'])){
			$sql = "INSERT INTO users(id, name, pass, role) VALUE(null, :name, :password, :role)";
	        $stmt = $mysql_connect->prepare($sql);
	        $stmt->bindValue('name', $_POST['name'], PDO::PARAM_STR);
	        $stmt->bindValue('password', $_POST['password'], PDO::PARAM_STR);
	        $stmt->bindValue('role', $_POST['role'], PDO::PARAM_INT);
	        
	        $r = $stmt->execute();
	        
	        if($r){
	        	$result_text = 'ユーザー追加が完了しました。';
	        }else{
	        	$result_text = 'ユーザー追加に失敗しました。';
	        }
		}else{
			$result_text = '不正な画面遷移です。';
		}
	}else{
		$result_text = '不正な画面遷移です。';
	}
	
	unset($_SESSION['token']);
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>ユーザー追加完了画面</title>
    </head>
    <body>
        <h1>ユーザー追加確認</h1>
		<p><?php echo $result_text ?></p>
		<button type="button" onclick="location.href = 'admin.php'">ユーザー一覧画面へ</button>
    </body>
</html>