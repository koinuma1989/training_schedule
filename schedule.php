<?php
	require_once "init.php";

	if(isset($_GET['year']) && isset($_GET['month'])){
		$year = $_GET['year'];
		$month = sprintf('%02d', $_GET['month']);//月の0埋め;

		//選択中の月の日数の算出
		$last_day = date('t', strtotime($year . '-' . $month . '-01'));	
	}else{
		// 初期表示
		$year = date('Y');
		$month = date('m');
		$day = date('d');
		$last_day = date('t');
	}
	
	//ユーザーデータのセレクト
	$mysql_connect = db_connect();
	$sql = "SELECT date, memo FROM users_memo WHERE user_id = :id and date BETWEEN :first AND :end";
    $stmt = $mysql_connect->prepare($sql);
    $stmt->bindValue('id', $_SESSION['loggedin_id'], PDO::PARAM_INT);
    $stmt->bindValue('first', $year . '-' . $month . '-01', PDO::PARAM_STR);
    $stmt->bindValue('end', $year . '-'. $month . $last_day, PDO::PARAM_STR);
    
    $stmt->execute();
	
	$user_memo = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	
	//登録処理
	if(isset($_POST['day']) && isset($_POST['memo'])){
		if($_POST['memo'] != '' && !ctype_space($_POST['memo'])){
			$format_day = sprintf('%02d', $_POST['day']);//日の0埋め
			$date = $year . '-' . $month . '-' . $format_day;
		
			v_d($date);
			exit;
			
			$mysql_connect = db_connect();
			$sql = "INSERT INTO users_memo(user_id, date, memo) VALUE(:user_id, :date, :memo)";
	        $stmt = $mysql_connect->prepare($sql);
	        $stmt->bindValue('user_id', $_POST['user_id'], PDO::PARAM_INT);
	        $stmt->bindValue('date', $date, PDO::PARAM_STR);
	        $stmt->bindValue('memo', $_POST['memo'], PDO::PARAM_STR);
	        
	        $r = $stmt->execute();
		}
	}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>スケジュール帳</title>
    </head>
    <body>
		<form action="login.php" method="get">
			<input type="hidden" name="logout" value="true">
			<input type="submit" value="ログアウト">
		</form>
        <h1>スケジュール帳</h1>
        <form action="" method="get">
        	<select name="year">
        		<?php 
        			for($year = 2000; $year <= 2100; $year++){
        				$selected = '';
	        			if(isset($_GET['year'])){
	        				if($_GET['year'] == $year){
	        					$selected = 'selected';
	        				}
	        			}else{
	        				if($year == date('Y')){
								$selected = 'selected';
	        				}
	        			}
        		?>
        			<option value=<?php echo $year . ' ' . $selected ?>><?php echo $year?></option>
        		<?php } ?>
        	</select>
        	<select name="month">
        		<?php
        			for($month = 1; $month <= 12; $month++){ 
        		        $selected = '';
	        			if(isset($_GET['month'])){
	        				if($_GET['month'] == $month){
	        					$selected = 'selected';
	        				}
	        			}else{
	        				if($month == date('m')){
								$selected = 'selected';
	        				}
	        			}
        		?>
        			<option value=<?php echo $month . ' ' . $selected ?>><?php echo $month?></option>
        		<?php } ?>
        	</select>
        	<input type="submit" value="表示">
        </form>
        <form action="" method="post">
        	<span><?php echo isset($_GET['year']) ? $_GET['year'] : date('Y') ?>月</span><span><?php echo isset($_GET['month']) ? $_GET['month'] : date('m') ?>月</span>
        	<select name="day">
        		<?php for($day = 1; $day <= $last_day; $day++){ ?>
        			<option value=<?php echo $day?>><?php echo $day?></option>
        		<?php } ?>
        	</select><span>日</span>
        	<input type="text" name="memo">
        	<input type="hidden" name="year" value=<?php echo isset($_GET['year']) ? $_GET['year'] : date('Y') ?>>
        	<input type="hidden" name="month" value=<?php echo isset($_GET['month']) ? $_GET['month'] : date('m') ?>>
        	<input type="hidden" name="user_id" value=<?php echo $_SESSION['loggedin_id'] ?>>
        	<input type="submit" value="登録">
        </form>
        <table border=1>
		    <tr>
				<th>日</th>
				<th>メモ</th>
		    </tr>
		    <?php
		    	for($day = 1; $day <= $last_day; $day++){
		    ?>
		    	    <tr>
						<td><?php echo $day ?></td>
						<td>
							<?php
								
							?>
						</td>
			        </tr>
			<?php
		    	}
		    ?>
		</table>
    </body>
</html>