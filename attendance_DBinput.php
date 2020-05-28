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
	//セッション開始
	session_start();
	$ori_url =$_SESSION["ori_url"];

	$member_name = $_POST['member_name'];  //名前の受け取り	
	$member_comment = $_POST['member_comment'];  //コメントの受け取り

	include( "./access_db.php" );

	//イベントIDと出欠データを受け取る配列を作成
	$event_date_ids_and_attendances=[];

	//入力された名前とコメントの文字数を確認
	$errMsg="文字数制限を超過しています</h4></p>";
	$name_limit=50;  //名前の制限
	$name_len=strlen($member_name);
	$com_limit=200;  //コメントの制限
	$com_len=strlen($member_comment);

	if( $name_len>$name_limit){
		//名前の制限50以上か？
		echo "<p><h4>名前の",$errMsg;
		echo "<br>";
		echo "<a href=",$ori_url,"><button>出欠入力画面へ</button></a>";
	}else if($com_len>$name_limit){
		//コメントの制限200以上か？
		echo "<br><br><p><h4>コメントの",$errMsg;
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
</div>
</div>
  </body>
</html>
