<?php
	require_once "init.php";
	
	
	
	
	// �폜�Ώۂ̓��̓t�H�[��
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>���[�U�[���폜���</title>
    </head>
    <body>
		<button type="button" onclick="location.href='/admin.php'">���[�U�[����ꗗ��</button>
        <h1>���[�U�[���폜</h1>
        
		<form action="delete_user_confirm.php" method="post">
			<p><span>���[�U�[���F</span><input type="text" name="name" value=<?php echo $name ?>></p>
			<?php if(isset($_SESSION['errors']['name'])){ ?>
				<p><?php echo $_SESSION['errors']['name'];?></p>
			<?php } ?>
			<?php if(isset($_SESSION['errors']['duplicate_user_name'])){ ?>
				<p><?php echo $_SESSION['errors']['duplicate_user_name'];?></p>
			<?php } ?>
			<p>
			
            <p><span>�p�X���[�h�F</span><input type="password" name="password" value=""></p>
			<?php if(isset($_SESSION['errors']['password'])){ ?>
				<p><?php echo $_SESSION['errors']['password'];?></p>
			<?php } ?>
		
			<input type="hidden" name="id" value=<?php echo $user['id'] ?>>
			<input type="submit" value="���s">
		</form>
    </body>
</html>