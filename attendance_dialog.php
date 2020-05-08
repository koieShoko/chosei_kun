<!doctype html>
<html lang="ja">
  <head>
	<meta charset="utf-8">
	<title>調整くん</title>
  </head>
  <body>

  <?php

	//セッション開始
	session_start();
	$ori_url =$_SESSION["ori_url"];
	echo $ori_url;
	//$url="attendance_list.php";
	
	//エラーメッセージ
	echo "<h1>出欠登録に失敗しました。<br>お手数ですが入力をやり直してください。</h1>";

  ?>

	<a href="<?php echo $ori_url; ?>"><button>出欠入力画面へ</button></a>


  </body>

</html>


