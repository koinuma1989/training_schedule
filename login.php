<?php
	require_once "init.php";
	if(isset($_GET["logout"]) && $_GET["logout"] == true){
		logout();
	}

	//ログイン済みリダイレクト
	if(isset($_SESSION["loggedin_id"])){
		header("location:" . ROLES[$_SESSION['role']]['url']);
		exit;
	}
	
	// ログイン処理
	if(isset($_POST['name']) && isset($_POST['password'])){
		$errors = loginValidation($_POST['name'], $_POST['password']);
		
		if(empty($errors)){
			$mysql_connect = db_connect();
			$sql = "SELECT id,name,role FROM users WHERE name = :name and pass = :pass";
	        $stmt = $mysql_connect->prepare($sql);
	        $stmt->bindValue('name',$_POST['name'],PDO::PARAM_STR);
	        $stmt->bindValue('pass',$_POST['password'],PDO::PARAM_STR);
	        $stmt->execute();
	        
	        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	        	$_SESSION['loggedin_id'] = $row['id'];
				$_SESSION['role'] = $row['role'];
				header('location:' . ROLES[$row['role']]['url']);
				exit();
	        }else{
		        $errors['loginerr'] = true;
	        }
		}
	}

	// login時の入力値バリデーション
	function loginValidation($name, $pass){
		$errors = [];
		if(empty($name)) {
			$errors['name']['require'] = true;
		}
		if(empty($pass)){
			$errors['password']['require']  = true;
		}
		
		return $errors;
	}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>login</title>
    </head>
    <body>
        <h1>ログイン</h1>
    	<form action="<?php echo $_SERVER ['SCRIPT_NAME']; ?>" method="post">
            <p><span>ユーザー名：</span><input type="text" name="name"></p>
			<?php if(isset($errors['name']['require'])){ ?>
				<p>名前を入力してください</p>
			<?php } ?>
			
            <p><span>パスワード：</span><input type="password" name="password"></p>
            <?php if(isset($errors['password']['require'])){ ?>
				<p>パスワードを入力してください</p>
			<?php } ?>
			
			<?php if(isset($errors['loginerr'])){ ?>
				<p>ユーザー名かパスワードが間違っています</p>
			<?php } ?>
            
            <input type="submit" value="ログイン">
    	</form>
    </body>
</html>