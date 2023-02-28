<?php
	require_once "init.php";

	if(!empty($_GET['id'])){
		$id = $_GET['id'];
	}elseif(!empty($_POST['id'])){ //確認画面から戻るで戻ってきたときはPOST
		$id = $_POST['id'];
	}else{
		echo 'IDが指定されていません';
		exit;
	}
	
	$sql = "SELECT id,name FROM users WHERE id = :id";
	$stmt = $mysql_connect->prepare($sql);
	$stmt->bindValue('id', $id, PDO::PARAM_INT);
	$stmt->execute();
	$user = $stmt->fetch(PDO::FETCH_ASSOC);

	if(!$user){
		echo '指定したIDのユーザーが存在しません';
		exit;
	}
	
	// 初期表示 確認画面から「戻る」で戻ってきた時は入力してた値が優先
	$name = $user['name'];
	if(isset($_POST['name'])){
		$name = $_POST['name'];
	}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>ユーザー情報編集画面</title>
    </head>
    <body>
		<button type="button" onclick="location.href='/admin.php'">ユーザー名簿一覧へ</button>
        <h1>ユーザー情報編集</h1>
        
		<form action="edit_user_confirm.php" method="post">
			<p><span>ユーザー名：</span><input type="text" name="name" value=<?php echo $name ?>></p>
			<?php if(isset($_SESSION['errors']['name'])){ ?>
				<p><?php echo $_SESSION['errors']['name'];?></p>
			<?php } ?>
			<?php if(isset($_SESSION['errors']['duplicate_user_name'])){ ?>
				<p><?php echo $_SESSION['errors']['duplicate_user_name'];?></p>
			<?php } ?>
			<p>
			
            <p><span>パスワード：</span><input type="password" name="password" value=""></p>
			<?php if(isset($_SESSION['errors']['password'])){ ?>
				<p><?php echo $_SESSION['errors']['password'];?></p>
			<?php } ?>
		
			<input type="hidden" name="id" value=<?php echo $user['id'] ?>>
			<input type="submit" value="実行">
		</form>
    </body>
</html>

<?php
	//エラー管理sessionの削除
	if(isset($_SESSION['errors'])){
		unset($_SESSION['errors']);
	}
?>