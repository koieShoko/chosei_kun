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

	//入力された名前とコメントの文字数を確認
	$errMsg="文字数制限を超過しています";
	$name_limit=50;  //名前の制限
	$name_len=strlen($member_name);
	$com_limit=200;  //コメントの制限
	$com_len=strlen($member_comment);

	if( $name_len>$name_limit){
		//名前の制限50以上か？
		echo "名前の",$errMsg;
		echo "<br>";
		echo "<a href=",$ori_url,"><button>出欠入力画面へ</button></a>";
	}else if($com_len>$name_limit){
		//コメントの制限200以上か？
		echo "コメントの",$errMsg;
		echo "<br>";
		echo "<a href=",$ori_url,"><button>出欠入力画面へ</button></a>";		
	}else{


	//HTMLエンティティ化機能
  	//特殊文字を削除 (イベント名、イベント概要チェック用)
	  function delete_sc($d){
		$tmp=htmlspecialchars($d, ENT_QUOTES, 'UTF-8');
		return preg_replace("/[^ぁ-んァ-ンーa-zA-Z0-9一-龠０-９\-\r]+/u",'' ,$tmp);
  	}
	
	//配列でイベントIDと出欠データの受け取り
	foreach($_POST as $key =>$value){
		if($key=="member_name"){
			echo "";
		}else if($key=="member_comment"){
			echo "";
		}else{
			//echo $value;
			//echo "<br>";
			$k=delete_sc($key);
			$v=delete_sc($value);
			$event_date_ids_and_attendances+=array($k=>$v);
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

	}










?>

  </body>
</html>
