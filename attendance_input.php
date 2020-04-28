<!doctype html>
<html lang="ja">
  <head>
	<meta charset="utf-8">
	<title>調整くん</title>
  </head>
  <body>

  <?php
	//イベント名を表示
	echo "<h3>",$_POST["event_name"],"</h3>";
	echo "<hr>";
	echo "<pre><h5>","  ","回答者",$_POST["sum_member"],"人</h5></pre>";
  ?>

	<h3>イベントの詳細説明</h3>
  <?php
	//イベントメモを表示
	echo "<pre><h5>","  ",$_POST["event_memo"],"</h5></pre>";
  ?>

<!--
<?php
	$attendance_condition=$_POST["attendance_condition[]"];
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
-->	

	<p><font size="3">出欠を入力する</font></p>
	<hr>
	<!--出欠入力フォーム-->
	<form action="attendance_DBinput.php" method="post" accept-charset="utf-8">
		<h5>名前</h5>
			<p><font size="2">※絵文字は入力できません</font></p>
			<input type="text" name="member_name" >
		<h5>日程候補</h5>
			<input type="text" name="member_name" >
			<select name="kouho1" id="f_kouho1">
				<option value="3" selected="selected">× </option>
				<option value="1" >◯ </option>
				<option value="2" >△ </option>
			</select>

		<h5>コメント</h5>
		<input type="text" name="member_comment" >
		<br>
		<input type="submit" name="" value="入力する">
	</form>
<!--
<h4>日にち候補</h4>
	<div id="choice" class="member-form-choice-div">
	<table class="choice choice-table">
	<tr>
	<th>4/28(火) 19:00〜</th>
	<td>
	<select name="kouho1" id="f_kouho1">
		<option value="3" selected="selected">× </option>
		<option value="1" >◯							</option>
		<option value="2" >△							</option>
	</select>
	</td>
	</tr>
	</table>
	</div>
-->




  </body>

</html>
