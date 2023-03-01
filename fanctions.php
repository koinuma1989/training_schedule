<?php	
	session_start();

	try{
		// DB接続
		$dsn = 'mysql:dbname=schedule;host=localhost';
		$user = 'root';
		$password = '';
		
		$mysql_connect = new PDO($dsn, $user, $password);
		
		// memo登録
		if(isset($_POST['year']) && isset($_POST['month']) && isset($_POST['day'])){
			if($_SESSION['token'] != $_POST['token']){
				return;
			}
			
			// 登録する日付
			$insert_date = $_POST['year'] . $_POST['month'] . $_POST['day'];
			
			$insert_query = $mysql_connect->prepare('INSERT INTO memo (id, date, memo) VALUES (null, :date, :memo)');
			$insert_query -> bindValue('date', $insert_date, PDO::PARAM_STR);
			$insert_query -> bindValue('memo', $_POST['memo'], PDO::PARAM_STR);
			$insert_query -> execute();
		
		}
		
		// memoの取得
		if(isset($_GET['year']) && isset($_GET['month'])){
			$year = $_GET['year'];
			$month = $_GET['month'];
		}else{ //getがなければ現在年月
			$year = date('Y');
			$month = date('m');
		}
		
		$year_month = $year . $month;
		
		$select_query = $mysql_connect->prepare('select memo from memo where date = :year_month');
		$select_query->bindValue('year_month', $year_month, PDO::PARAM_STR);
		$select_query->execute();
		
	
	}catch (PDOException $e){
		var_dump($e);
	}


	// 表示する年月日
	if(isset($_GET['year']) && isset($_GET['month'])){
		$view_date = $_GET['year'] . '-' . $_GET['month'] . '-' . '01';
	}else{
		$view_date = date('Y-m-d');
	}
	$month_day = date('t', strtotime($view_date));
	
	$_SESSION['token'] = uniqid(bin2hex(random_bytes(1)));
?>



<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<form action="" method="get">
			<select name="year">
				<?php
					for($i = 2000; $i <= 2100; $i++){
						if(isset($_GET['year']) && $i == $_GET['year']){
							$selected = 'selected';
						}else if($i == date('Y')){
							$selected = 'selected';
						}else{
							$selected = "";
						}
					
						echo "<option value=" . $i . " " . $selected . ">" . $i . "</option>";
					}
				?>
			</select>
			<span>年</span>
			<select name="month">
				<?php
					for($i = 1; $i <= 12; $i++){
						if(isset($_GET['month']) && $i == $_GET['month']){
							$selected = 'selected';
						}else if($i == date('m')){
							$selected = 'selected';
						}else{
							$selected = "";
						}
						echo "<option value=" . $i . " " . $selected . ">" . $i . "</option>";
					}
				?>
			</select>
			<span>月</span>
			<input type="submit" value="表示">
		</form>
		<form action="" method="post">
			<select name="day">
				<?php
					for($i = 1; $i <= $month_day; $i++){
						if($i == date('d')){
							$selected = 'selected';
						}
						echo "<option value=" . $i . " " . $selected . ">" . $i . "</option>";
					}
				?>
			</select>
			
			<?php
				if(isset($_GET['year']) && isset($_GET['month'])){
					$year = $_GET['year'];
					$month = $_GET['month'];
				}else{
					$year = date('Y');
					$month = date('m');
				}
			?>
			
			<input type="text" name="memo">
			<input type="hidden" name="year" value=<?php echo $year ?>>
			<input type="hidden" name="month" value=<?php echo $month ?>>
			<input type="hidden" name="token" value=<?php echo $_SESSION['token'] ?>>
			<input type="submit" value="登録">
		</form>
		
		<table border="1">
			<tr>
				<th>日</th>
				<th>メモ</th>
			</tr>
			<?php
				for($i = 1; $i <= $month_day; $i++){
					echo "<tr>";
					echo "<th>" . $i . "</th>";
					echo "<td></td>";
					echo "</tr>";
				}
			?>
		</table>
	</body>
</html>