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

	$member_name = $_POST['member_name'];  //名前の受け取り	
	$member_comment = $_POST['member_comment'];  //コメントの受け取り

	include( "./access_db.php" );

	//イベントIDと出欠データを受け取る配列を作成
	$event_date_ids_and_attendances=[];

	//配列でイベントIDと出欠データの受け取り
	foreach($_POST as $key =>$value){
		if($key=="member_name"){
			echo "";
		}else if($key=="member_comment"){
			echo "";
		}else{
			//echo $value;
			//echo "<br>";
			$event_date_ids_and_attendances+=array($key=>$value);
		}

	}

	//DBに出欠情報を書き込む
	$r=exe_regist_member_and_attendance($member_name,$member_comment,$event_date_ids_and_attendances);


	if($r==0){
		#閲覧画面へ遷移
		header("Location: $ori_url");
		exit();	
	}else{
		//エラー画面に遷移
		header("Location: attendance_dialog.php");
		exit();
	}


?>

  </body>
</html>
