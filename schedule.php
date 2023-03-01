<?php
	require_once "init.php";

	if(isset($_GET['year']) && isset($_GET['month'])){
		//選択中の月の日数の算出
		$year_month = $_GET['year'] . '-' . $_GET['month'];
		$last_day = date('t', strtotime($year_month . '-01'));
		
		
		//ユーザーデータのセレクト	
		$mysql_connect = db_connect();
		$sql = "SELECT name, memo FROM memo WHERE user_id = :id and BETWEEN :first AND :end";
	    $stmt = $mysql_connect->prepare($sql);
	    $stmt->bindValue('id', $_SESSION['loggedin_id'], PDO::PARAM_INT);
	    $stmt->bindValue('first', $year_month . '-01', PDO::PARAM_STR);
	    $stmt->bindValue('end', $year_month . '-' . $last_day, PDO::PARAM_STR);
	    
	    $stmt->execute();
		
		$user_memo = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	
	}else{
		$now_year = date('Y');
		$now_month = date('m');
		$now_day = date('d');
		$last_day = date('t');
	}
	
	
	//登録処理
	if(isset($_POST['day']) && isset($_POST['memo'])){
		if($_POST['memo'] != '' && !ctype_space($_POST['memo'])){
			$mysql_connect = db_connect();
			$sql = "INSERT INTO users(id, name, pass, role) VALUE(null, :name, :password, :role)";
	        $stmt = $mysql_connect->prepare($sql);
	        $stmt->bindValue('name', $_POST['name'], PDO::PARAM_STR);
	        $stmt->bindValue('password', $_POST['password'], PDO::PARAM_STR);
	        $stmt->bindValue('role', $_POST['role'], PDO::PARAM_INT);
	        
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
        	<select name="day">
        		<?php for($day = 1; $day <= $last_day; $day++){ ?>
        			<option value=<?php echo $day?>><?php echo $day?></option>
        		<?php } ?>
        	</select>
        	<input type="text" name="memo">
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
						<td></td>
			        </tr>
			<?php
		    	}
		    ?>
		</table>
    </body>
</html>