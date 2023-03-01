<?php
	require_once "init.php";	
	
	// 削除対象の情報を取得
	if(!empty($_GET['id'])){
		$mysql_connect = db_connect();
		$sql = "SELECT id,name,role FROM users WHERE id = :id";
		$stmt = $mysql_connect->prepare($sql);
		$stmt->bindValue('id', $_GET['id'], PDO::PARAM_INT);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!$user){
			header("location: admin.php");
    		exit;
		}
		if($user['id'] == $_SESSION['loggedin_id']){// 削除対象がログイン中のユーザーだった場合はリダイレクト
			header("location: admin.php");
    		exit;
    	}
		
	}else{
		header("location: admin.php");
		exit;
	}

	$_SESSION['token'] = uniqid(bin2hex(random_bytes(1))); //post用トークン生成
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>ユーザー情報削除確認画面</title>
    </head>
    <body>
		<button type="button" onclick="location.href='/admin.php'">ユーザー名簿一覧へ</button>
        <h1>ユーザー情報削除確認</h1>
        
		<form action="dalete_user_complete.php" method="post">
            <p><span>ユーザー名：</span><?php echo htmlspecialchars($user['name']) ?></p>
            <p><span>権限：</span><?php echo ROLES[$user['role']]['role'] ?></p>
            
			<input type="hidden" name="id" value=<?php echo $user['id'] ?>>
			<input type="hidden" name="token" value=<?php echo $_SESSION['token'] ?>>
			<input type="submit" value="削除実行">
		</form>
		<button type="button" onclick="location.href='/admin.php'">ユーザー名簿一覧へ</button>
    </body>
</html>
