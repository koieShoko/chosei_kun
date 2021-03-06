<!doctype html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>


    <!-- 上記の３つのタグはheadの中で最初に現れないといけない -->

    <title>調整くん</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="stylesheet.css">
   <!-- Internet Explorer 8 以前のバージョンのための対策 -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<header class = "header">
    <div class="container">
    <div class="row">
      <div class="col-sm-6">
          <h1>&#x1f4dd; 調整くん</h1>
      </div>
      <div class="col-sm-6 text-left">
          <p></p>
          <p>簡単出欠管理、日程調整ツール。</p>
          <p>効率良くスケジュールを決めましょう。</p>
      </div>
    </div>
  </div>
  </header>




    <!--  コンテンツ  -->
    <?php
	session_start();
	$message = $_SESSION[ 'message' ]; // message to be displayed
	 ?>

    <div class="container">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
        <br>
        <br>
        <br>

        <h4>
          <?php echo $message; ?>
        </h4>
        <br>
        <br>
        <br>
        <br>

        <h4>
          <?php
              echo '<a href="./make_event.html">TOPページに戻る';
          ?>
         </a></h4>
        </div>
        <div class="col-sm-2"></div>
      </div>
    </div>
</body>
</html>
