<?php
	require_once "init.php";
	
	
	
	
	// 削除対象の入力フォーム
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>ユーザー情報削除画面</title>
    </head>
    <body>
		<button type="button" onclick="location.href='/admin.php'">ユーザー名簿一覧へ</button>
        <h1>ユーザー情報削除</h1>
        
		<form action="delete_user_confirm.php" method="post">
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