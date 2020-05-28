<!doctype html>
<html lang="ja">
  <head>
  <head>
	<meta charset="utf-8">
	<title>調整くん</title>
<<<<<<< HEAD
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
=======
>>>>>>> e36acd2caf7ec7dca7a7ef4c6a9dea618215a92f
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
	//echo $ori_url;
	//$url="attendance_list.php";
	
	//エラーメッセージ
	echo "<h1>出欠登録に失敗しました。<br>お手数ですが入力をやり直してください。</h1>";

  ?>

	<a href="<?php echo $ori_url; ?>"><button>出欠入力画面へ</button></a>


  </body>
</div>
</div>
</html>
