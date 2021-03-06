<!doctype html>
<html lang="ja">
  <head>
	<meta charset="utf-8">
	<title>調整くん</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="stylesheet.css">
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
	$ori_url =$_SESSION["ori_url"];

   ?>

<header class = "header">
    <div class="container">
    <div class="row">
      <div class="col-sm-6">
          <h1>&#x1f4dd;   調整くん</h1>
      </div>
      <div class="col-sm-6 text-left">
          <p></p>
          <p>簡単出欠管理、日程調整ツール。</p>
          <p>効率良くスケジュールを決めましょう。</p>
      </div>
    </div>
  </div>
  </header> 

	<div class="container">
		<div class="row">
  <?php
	//イベント名を表示
	echo "<h2>",$event_name,"</h2>";
	echo "<h4>","  ","回答者",$sum_member,"人</h4>";
  ?>

	<h3>イベントの詳細説明</h3>
  <?php
	//イベントメモを表示
	echo "<h4>","  ",$event_memo,"</h4>";
  ?>
		<h3>日程候補</h3> 
  <?php
		#出欠回答状況の一覧表を表示
      

		$i=0;
		if(count($attendance_condition[0])!=4){
			echo "<table id='condition_table_a'>";
			foreach($attendance_condition as $key => $values){
				echo "<tr>";

				if($i==0){   
						#もし将来、出欠情報取消ボタンをつくるならここに処理追加
					echo "";
				}else if($i==1){ 

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
				echo "</tr>";
				$i+=1;
			}
			echo "</table>";
		}else{
			echo "<ul>";
			foreach($_SESSION["event_ids_and_names"] as $key=>$value){
				echo "<li><h4>".$value."</h4></li>";
			}
			echo "</ul>";
		}
	

  ?>
  	<br>
		<h2>出欠を入力する</h2>
	<!--出欠入力フォーム-->
	<form action="attendance_DBinput.php" method="post" accept-charset="utf-8">
		<table>
			<tr>
				<td>
					<h3>名前</h3>
						<font size="2">※絵文字は入力しないでください</font>
				</td>
				<td>
						<input type="text" name="member_name" required>
				</td>
			<tr>
				<td>	
					<h3>日程候補</h3>
				</td>
				<td>
					<?php
						#モデルを呼び出す
						include( "./access_db.php" );
						//イベント日程を取得する
						exe_get_global_event_ids_and_names($url_rand);
						//取得したイベント日程の配列を格納
						$event_ids_and_names=$global_event_ids_and_names;
						echo "<ul class='attendance'>";
						foreach($event_ids_and_names as $key => $values){
							echo "<li >";
							echo "<label>",$values,"</label>";
							echo '<select name=',$key,' >';
								echo '<option value="0" selected="selected">× </option>';
								echo '<option value="2" >◯ </option>';
								echo '<option value="1" >△ </option>';
							echo '</select>';
							echo "</li>";
						}
						echo "</ul>";
					?>  
				</td>
			</tr>
			<tr>
				<td>
					<h3>コメント</h3>
				</td>
				<td>
					<input type="text" name="member_comment" >
				</td>
			</tr>
		</table>
		<!--入力ボタン -->
		<input type="submit" name="" value="入力する" class="button">
	</form>
	<br>

	</div>
	</div>


  </body>

</html>