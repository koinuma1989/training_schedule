<?php
	require_once "init.php";
	
	if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['old_password']) && isset($_POST['new_password'])){
		$errors = editUserValidation($_POST['id'], $_POST['name'], $_POST['old_password'], $_POST['new_password']);
		
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
	function editUserValidation($id, $name, $old_pass, $new_pass){
		$errors = [];
		if(empty($name)) {
			$errors['name'] .= 'ユーザー名は必須項目です' . PHP_EOL;
		}else if(isDuplicateUserName($name, $id)){//ユーザー名重複確認
			$errors['name'] .= $name . '　は既に登録されているユーザー名です' . PHP_EOL;
		}

		if(empty($old_pass)){
			$errors['old_password']  .= '現在のパスワードは必須項目です' . PHP_EOL;
        }else if(passwordVerify($id, $old_pass)){
			$errors['old_password']  .= '現在のパスワードが違います' . PHP_EOL;
        }

		if(empty($new_pass)){
			$errors['new_password']  .= '変更後パスワードは必須項目です' . PHP_EOL;
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
			<input type="hidden" name="password" value=<?php echo $_POST['new_password'] ?>>
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