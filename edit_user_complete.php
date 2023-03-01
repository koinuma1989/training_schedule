<?php
	require_once "init.php";

	if(isset($_POST['token']) && isset($_SESSION['token']) && $_SESSION['token'] == $_POST['token']){
		if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['password'])){
			$sql = "UPDATE users SET name = :name, pass = :password WHERE id = :id";
	        $stmt = $mysql_connect->prepare($sql);
	        $stmt->bindValue('name', $_POST['name'], PDO::PARAM_STR);
	        $stmt->bindValue('password', $_POST['password'], PDO::PARAM_STR);
	        $stmt->bindValue('id', $_POST['id'], PDO::PARAM_INT);
	        
	        $r = $stmt->execute();
	        
	        if($r){
	        	$result_text = 'ユーザー情報変更が完了しました。';
	        }else{
	        	$result_text = 'ユーザー情報変更に失敗しました。';
	        }
		}else{
			unset($_SESSION['token']);
			header("location: admin.php");
    		exit;
        }
	}else{
		unset($_SESSION['token']);
		header("location: admin.php");
		exit;
	}
	
	unset($_SESSION['token']);
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>ユーザー情報編集完了画面</title>
    </head>
    <body>
		<p><?php echo $result_text ?></p>
		<button type="button" onclick="location.href = 'admin.php'">ユーザー一覧画面へ</button>
    </body>
</html>