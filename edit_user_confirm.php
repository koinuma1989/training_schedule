<?php
	require_once "init.php";
	
	if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['password'])){
		$errors = editUserValidation($_POST['name'], $_POST['password'], $mysql_connect);
		
		if(empty($errors)){
			//通常処理
		}else{
			$_SESSION['errors'] = $errors;
			header("location: edit_user.php?id=" . $_POST['id']);
    		exit;
		}
	}else{
		echo '入力値が不正です';
		exit;
	}

	// 入力値バリデーション
	function editUserValidation($name, $pass, $mysql_connect){
		$errors = [];
		if(empty($name)) {
			$errors['name'] .= 'ユーザー名は必須項目です' . PHP_EOL;
		}elseif(isDuplicateUserName($name, $mysql_connect)){//ユーザー名重複確認
			$errors['name'] .= '既に登録されているユーザー名です' . PHP_EOL;
		}

		if(empty($pass)){
			$errors['password']  .= 'パスワードが入力されていません' . PHP_EOL;
        }
		
		return $errors;
	}

	$_SESSION['token'] = uniqid(bin2hex(random_bytes(1))); //post用トークン生成

?>


<html>
    <head>
        <meta charset="UTF-8">
        <title>編集確認画面</title>
    </head>
    <body>
        <h1>編集確認画面</h1>
		<form action="edit_user_complete.php" method="post">
            <p><span>ユーザー名：</span><?php echo htmlspecialchars($_POST['name']) ?></p>
            
			<input type="hidden" name="id" value=<?php echo $_POST['id'] ?>>
			<input type="hidden" name="name" value=<?php echo $_POST['name'] ?>>
			<input type="hidden" name="password" value=<?php echo $_POST['password'] ?>>
			<input type="hidden" name="token" value=<?php echo $_SESSION['token'] ?>>
			<input type="submit" value="編集実行">
		</form>
		<form action="edit_user.php" method="post">
			<input type="hidden" name="id" value=<?php echo $_POST['id'] ?>>
			<input type="hidden" name="name" value=<?php echo $_POST['name'] ?>>
			<input type="submit" value="戻る">
		</form>
    </body>
</html>