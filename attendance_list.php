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
	<div class="container">
        <div class="bg-primary">
		<h1>調整くん</h1>  
	  </div>     
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
      
		echo "<table class='table table-bordered'>";
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
			$i+=1;
		}
		echo "</table>"
	

  ?>

		<!--出欠入力ボタンを表示-->
		<br>
		<form action="attendance_input.php" method="post" accept-charset="utf-8">
			<input type="submit" name="" value="出欠を入力する">
		</form>
		<br>
 


	</div>
  </body>

</html>
