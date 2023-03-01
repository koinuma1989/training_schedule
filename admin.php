<?php
	require_once "init.php";
	$mysql_connect = db_connect();

	// 全ユーザー情報の取得
	$sql = "SELECT id, name, role FROM users WHERE delete_flg = 0";
    $stmt = $mysql_connect->prepare($sql);
    $stmt->execute();
    $user_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    

	// ログイン中ユーザー情報の取得
	$sql = "SELECT name FROM users WHERE id = :id";
    $stmt = $mysql_connect->prepare($sql);
	$stmt->bindValue('id', $_SESSION['loggedin_id'], PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);


?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>管理者画面</title>
    </head>
    <body>
		<form action="login.php" method="get">
			<input type="hidden" name="logout" value="true">
			<input type="submit" value="ログアウト">
		</form>
		<p><?php echo $user['name'] ?>　でログイン中</p>
        <h1>管理者画面</h1>
    	<button type="button" onclick="location.href = 'add_user.php'">ユーザー新規追加</button>
		<table border=1>
		    <tr>
		      <th>ID</th>
		      <th>ユーザー名</th>
		      <th>権限</th>
		      <th>操作</th>
		    </tr>
			<?php foreach($user_list as $user){
				if($user['id'] == $_SESSION['loggedin_id']){
					$loggedin = ' ※ログイン中';
				}else{
					$loggedin = '';
				}
			?>
		        <tr>
		            <td><?php echo $user['id'] ?></td>
		            <td><?php echo htmlspecialchars($user['name']) . $loggedin ?></td>
		            <td><?php echo ROLES[$user['role']]['role'] ?></td>
		            <td>
	            		<form action="edit_user.php" method="get">
		            		<input type="hidden" name="id" value=<?php echo $user['id'] ?>>
		            		<input type="submit" value="編集">
		            	</form>
		            	<?php if(!$loggedin){ ?>
			            	<form action="dalete_user_confirm.php" method="get">
			            		<input type="hidden" name="id" value=<?php echo $user['id'] ?>>
			            		<input type="submit" value="削除">
			            	</form>
			            	閲覧
		            	<?php } ?>
		            </td>
		        </tr>
		    <?php } ?>
		</table>
    </body>
</html>