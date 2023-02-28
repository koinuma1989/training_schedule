<?php
	require_once "init.php";
	
	if(isset($_POST['name']) && isset($_POST['password']) && isset($_POST['role'])){
		$errors = addUserValidation($_POST['name'], $_POST['password'], $_POST['role'], $mysql_connect);
		
		if(empty($errors)){
			//通常処理
		}else{
			$_SESSION['errors'] = $errors;
			header("location: add_user.php");
    		exit;
		}
	}else{
		echo '入力値が不正です';
		exit;
	}

	// 入力値バリデーション
	function addUserValidation($name, $pass, $role, $mysql_connect){
		$errors = [];
		if(empty($name)) {
			$errors['name'] .= 'ユーザー名は必須項目です' . PHP_EOL;
		}elseif(isDuplicateUserName($name, $mysql_connect)){//ユーザー名重複確認
			$errors['name'] .= '既に登録されているユーザー名です' . PHP_EOL;
		}

		if(empty($pass)){
			$errors['password']  .= 'パスワードが入力されていません' . PHP_EOL;
		}

		if(empty($role)){
			$errors['role']  .= '権限が選択されていません' . PHP_EOL;
		}elseif(!isset(ROLES[$role])){
			$errors['role']  .= '存在しない権限です' . PHP_EOL;
		}
		
		return $errors;
	}

	$_SESSION['token'] = uniqid(bin2hex(random_bytes(1))); //post用トークン生成

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>ユーザー追加確認画面</title>
    </head>
    <body>
        <h1>ユーザー追加確認</h1>  
		<form action="add_user_complete.php" method="post">
            <p><span>ユーザー名：</span><?php echo htmlspecialchars($_POST['name']) ?></p>
            <p><span>権限：</span><?php echo ROLES[$_POST['role']]['role'] ?></p>
            
			<input type="hidden" name="name" value=<?php echo $_POST['name'] ?>>
			<input type="hidden" name="password" value=<?php echo $_POST['password'] ?>>
			<input type="hidden" name="role" value=<?php echo $_POST['role'] ?>>
			<input type="hidden" name="token" value=<?php echo $_SESSION['token'] ?>>
			<input type="submit" value="追加">
		</form>
		<form action="add_user.php" method="post">
			<input type="hidden" name="name" value=<?php echo $_POST['name'] ?>>
			<input type="hidden" name="role" value=<?php echo $_POST['role'] ?>>
			<input type="submit" value="戻る">
		</form>
    </body>
</html>