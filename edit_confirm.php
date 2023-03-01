<?php
	require_once "init.php";
	
	if(isset($_POST['name']) && isset($_POST['password'])){
		$error_list = namePassValidation($_POST['name'], $_POST['password']);
	}
	
	if(empty($error_list)){
		//ユーザー名重複確認
		if(isDuplicateUserName($_POST['name'], $mysql_connect)){
			$_SESSION['error_list']['duplicate_user_name'] = true;
			header("location: edit_user.php");
			exit;
		}
	}else{
		$_SESSION['error_list'] = $error_list;
		header("location: add_user.php");
		exit;
	}
?>


<html>
    <head>
        <meta charset="UTF-8">
        <title>編集確認画面</title>
    </head>
    <body>
        <h1>編集確認画面</h1>
        <h3>下記の内容で編集します</h3>
        <form action="" method="post">
            <p>ユーザー名</p>
            <p><?php echo htmlspecialchars($_SESSION['edit_user_name'],ENT_QUOTES,'UTF-8'); ?></p>
            <p>パスワード</p>
            <p><?php echo htmlspecialchars($_SESSION['edit_pw'],ENT_QUOTES,'UTF-8'); ?></p>
            <br>
            <input type="submit" name="edit_ok" value="OK">
        </form>
        <button type="button" onclick="location.href='/edit.php'">戻る</button>
    </body>
</html>