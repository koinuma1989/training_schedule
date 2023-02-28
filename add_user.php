<?php
	require_once "init.php";
	
	// 確認画面から戻るで戻ってきた用の値
	$old_name = '';
	$old_role = '';
	if(isset($_POST['name'])){
		$old_name = $_POST['name'];
	}
	if(isset($_POST['role'])){
		$old_role = $_POST['role'];
	}	
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>ユーザー追加画面</title>
    </head>
    <body>
        <button type="button" onclick="location.href='/admin.php'">ユーザー一覧へ</button>
    	
        <h1>ユーザー追加</h1>
        
		<form action="add_user_confirm.php" method="post">
            <p><span>ユーザー名：</span>
            	<input type="text" name="name" value=<?php echo $old_name ?>>
            </p>
			<?php if(isset($_SESSION['errors']['name'])){ ?>
				<p><?php echo $_SESSION['errors']['name'];?></p>
			<?php } ?>
			<?php if(isset($_SESSION['errors']['duplicate_user_name'])){ ?>
				<p><?php echo $_SESSION['errors']['duplicate_user_name'];?></p>
			<?php } ?>
			<p>
				<span>権限：</span>
				<select name="role">
					<?php
						foreach(ROLES as $key => $role){ 
							if($old_role == $key){
								$selected = 'selected';
							}else{
								$selected = '';
							}
					?>
						<option value=<?php echo $key ?> <?php echo $selected ?>><?php echo $role['role'] ?></option>
					<?php } ?>
				</select>
			</p>
			<?php if(isset($_SESSION['errors']['role'])){ ?>
					<p><?php echo $_SESSION['errors']['role'];?></p>
			<?php } ?>
            <p><span>パスワード：</span><input type="password" name="password" value=""></p>
			<?php if(isset($_SESSION['errors']['password'])){ ?>
				<p><?php echo $_SESSION['errors']['password'];?></p>
			<?php } ?>
			<input type="submit" value="確認画面へ">
		</form>
    </body>
</html>


<?php
	//エラー管理sessionの削除
	if(isset($_SESSION['errors'])){
		unset($_SESSION['errors']);
	}
?>