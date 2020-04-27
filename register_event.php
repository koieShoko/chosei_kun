<?php
  include("./access_db.php");

  $name = $_POST['event_name'];
  $explain = $_POST['free'];
  //dateをPOSTで受け取り、開業区切りで配列に格納
  $event_dates = str_replace(['/r/n','/r'], PHP_EOL, $_POST['date']);
  $lines = explode(PHP_EOL, $event_dates);

  if(empty($name)){
    echo "イベント名が入力されていないか、文字数が多すぎます。";
    $_SESSION['message1'] = "<h4>イベント名が入力されていないか、文字数が多すぎます。</h4>";
  }else{
    if(empty($lines) == 0){
        echo "候補日が入力されていません。";
    }else{
      // for($i=0; $i<count($lines); $i++) {
      //   exe_regist_event_and_event_date($name,$explain, $lines);
      // }
    }
  }
?>
