<?php
//HTMLエンティティ化機能
function html($h){
  return htmlspecialchars($h, ENT_QUOTES, 'UTF-8');
}

//特殊文字を削除 (イベント名、イベント概要チェック用)
function delete_sc_event($d){
  return preg_replace("/[^ぁ-んァ-ンーa-zA-Z0-9一-龠０-９\-\r]+/u",'' ,$d);
}

//特殊文字を削除 (イベント候補日チェック用)
function delete_sc_dates($d){
  return preg_replace("/[^ぁ-んァ-ンーa-zA-Z0-9一-龠０-９\-\r:〜 ]+/u",'' ,$d);
}

//候補日の空要素を削除
function ary_empty_delete($lines){
  for($i=0; $i<count($lines); $i++){
    $lines[$i] = trim($lines[$i]); //要素内の半角スペースを削除
  }
  $lines = array_filter($lines); //配列の空白要素を削除
  $lines = array_values($lines);
  return $lines;
}

include("./access_db.php" );
session_start();

  $name = "";
  $explain = "";
  $lines = array(); //候補日チェック前

  //イベント名を取得
  $name = $_POST['event_name'];
  $name = html($name);
  $name = delete_sc_event($name);

  //イベント概要を取得
  $explain = $_POST['free'];
  $explain = html($explain);
  $explain = delete_sc_event($explain);

  //dateをPOSTで受け取り,開業区切りで配列に格納
  $dates = $_POST['event_dates'];
  $dates = html($dates);
  $dates = str_replace(['/r/n'|'/r'|'\n'], PHP_EOL, $dates);
  $dates = explode(PHP_EOL, $dates);
  //特殊文字を削除
  $dates = delete_sc_dates($dates);
  //配列の空白要素を削除
  $dates = ary_empty_delete($dates);

  //var_dump($dates);

  //イベント名チェック
  if( $name == '' ){ //イベント名が入力されているか
    $_SESSION[ 'message' ] = "<h4>イベント名が入力されていません</h4>";
    header( "Location: ./dialog.php");
  }else if(mb_strlen($name) > 120 ){ //イベント名に120文字異常入力されているかチェック
    $_SESSION[ 'messaege' ] = "<h4>イベント名の文字数がオーバーしています</h4>";
    header( "Location: ./dialog.php");

  //イベント概要チェック
  }else if(mb_strlen($explain) > 300){ //文字数が300文字以上入力されているかチェック
      $_SESSION[ 'message' ] = "<h4>イベント概要の文字数がオーバーしています。</h4>";
      header( "Location: ./dialog.php");

  //イベント候補日概要チェック
  }else if(count($dates) == 0){ // 候補日が入力されているかチェック
    $_SESSION[ 'message' ] = "<h4>候補日が入力されていません。</h4>";
    header( "Location: ./dialog.php");
  }else if(count($dates) > 30){ //候補日を20以上受け付けられるか
    $_SESSION[ 'message' ] = "<h4>入力した候補日が多すぎます。</h4>";
    header( "Location: ./dialog.php");
  }else{
    //var_dump($dates);
    //データベースへ登録
    for($i=0; $i<count($dates); $i++) {
      exe_regist_event_and_event_date($name, $explain, $dates);
    }
    $_SESSION[ 'url' ] = $global_url;
    // $_SESSION[ 'message' ] = "<h4>成功</h4>";
    header( "Location: ./event_url.php");
  }


?>
