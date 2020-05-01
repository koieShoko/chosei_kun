<!doctype html>
<html lang="ja">
  <head>
	<meta charset="utf-8">
	<title>調整くん</title>
  </head>
  <body>

  <?php
	#セッション開始
	session_start();

	#セッション変数から値を受け取り
	$event_name =$_SESSION["event_name"];
	$sum_member =$_SESSION["sum_member"];
	$event_memo =$_SESSION["event_memo"];
	$attendance_condition=$_SESSION["attendance_condition"];
	$url_rand =$_SESSION["url_rand"];

   ?>
	<h1>調整くん</h1>       
  <?php
	//イベント名を表示
	echo "<h3>",$event_name,"</h3>";
	echo "<hr>";
	echo "<pre><h5>","  ","回答者",$sum_member,"人</h5></pre>";
  ?>
	<!--イベント編集ボタンを表示-->
	<form action="event_delete.php" method="post" accept-charset="utf-8">
		<input type="hidden" name="aaa" value="aaa">
		<input type="submit" name="" value="イベント編集">
	</form>

	<h3>イベントの詳細説明</h3>
  <?php
	//イベントメモを表示
	echo "<pre><h5>","  ",$event_memo,"</h5></pre>";
  ?>
  <?php
	#出欠回答状況の一覧表を表示
	echo "<table border='1'>";
	$i=0;	
	foreach($attendance_condition as $key => $values){
		echo "<tr>";

		if($i==0){   
		        #もし将来、出欠情報取消ボタンをつくるならここに処理追加
			echo "";
		}else if($i==1){ 
			echo "<h3>日程候補</h3>";   
			#表の見出しになる行
			foreach($values as $value){
				echo "<th>",$value,"</th>";
			}
		}else{    
			#表の中身
			foreach($values as $value){
				echo "<td>",$value,"</td>";
			}
		}
		//echo "<br>";
		$i+=1;
	}
	echo "</table>"

  ?>

  <?php
	//イベント日程を取得する
	//exe_get_global_event_ids_and_names($url_rand);
	//取得したイベント日程の配列をセッション変数に渡す
  ?>

	<!--出欠入力ボタンを表示-->
	<br>
	<form action="attendance_input.php" method="post" accept-charset="utf-8">
	<!--	<input type="hidden" name="event_name" value="<?php echo $event_name; ?>">
		<input type="hidden" name="sum_member" value="<?php echo $sum_member; ?>">
		<input type="hidden" name="event_memo" value="<?php echo $event_memo; ?>">
		<input type="hidden" name="attendance_condition[]"  value="<?php echo $attendance_condition; ?>">  -->
		<input type="submit" name="" value="出欠を入力する">
	</form>
 



  </body>

</html>
