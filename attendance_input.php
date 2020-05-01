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



  <?php
	//イベント名を表示
	echo "<h3>",$event_name,"</h3>";
	echo "<hr>";
	echo "<pre><h5>","  ","回答者",$sum_member,"人</h5></pre>";
  ?>

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
	echo "</table>";

  ?>
	<br>
	<p><font size="3">出欠を入力する</font></p>
	<hr>
	<!--出欠入力フォーム-->
	<form action="attendance_DBinput.php" method="post" accept-charset="utf-8">
		<h5>名前</h5>
			<p><font size="2">※絵文字は入力できません</font></p>
			<input type="text" name="member_name" >
		<h5>日程候補</h5>
		  <?php
			#モデルを呼び出す
			include( "./access_db.php" );
			//イベント日程を取得する
			exe_get_global_event_ids_and_names($url_rand);
			//取得したイベント日程の配列を格納
			$event_ids_and_names=$global_event_ids_and_names;
			echo "<table border='1'>";
			foreach($event_ids_and_names as $key => $values){
				echo "<tr>",$values,"</tr>";
				echo '<select name=',$key,' >';
					echo '<option value="0" selected="selected">× </option>';
					echo '<option value="2" >◯ </option>';
					echo '<option value="1" >△ </option>';
				echo '</select>';
				echo "<br>";
			}
			echo "</table>";
  		  ?>   
		<h5>コメント</h5>
		<input type="text" name="member_comment" >
		<br>
		<!--入力ボタン -->
		<input type="submit" name="" value="入力する">
	</form>





  </body>

</html>
