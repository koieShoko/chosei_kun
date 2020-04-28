<!doctype html>
<html lang="ja">
  <head>
	<meta charset="utf-8">
	<title>調整くん</title>
  </head>
  <body>

  <?php

	#モデルを呼び出す
	include( "./access_db.php" );

	#URL
	$url_rand='afdsjsaldjlkdfjsal';

	#セッション開始
	session_start();

	#イベント名と回答人数とイベント詳細をグローバル変数に入れる関数を呼び出す
	exe_get_event_name_sum_member_event_memo($url_rand);

	#上記の結果が格納されたグローバル変数の内容を、セッション変数に渡す
	$_SESSION["event_name"]= $global_event_name;
	$_SESSION["sum_member"]= $global_sum_member;

	$_SESSION["event_memo"]= $global_event_memo;
	
	#出欠回答状況の一覧表をグローバル変数に格納する関数を呼び出す
	exe_get_attendance_condition_table($url_rand);
	#上記の結果が格納されたグローバル変数の内容を、セッション変数に渡す
	$_SESSION["attendance_condition"]= $global_attendance_condition_table;

	#閲覧画面へ遷移
	header("Location: attendance_list.php");
	exit();

  ?>

  </body>

</html>

