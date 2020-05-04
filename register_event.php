<?php

//文字数確認用
function check($c){
  return mb_strlen($c)."<br>";
}

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
// function ary_empty_delete($lines){
//   $array = array();
//
//   for($i=0; $i<count($lines); $i++){
//     if($lines[$i] !== ""){
//       $array = $lines[$i];
//     }
//   }
//   return $array;
// }

include("./access_db.php" );
session_start();

//POSTされたかを確認
if($_SERVER["REQUEST_METHOD"]==="POST"){

  $name = "";
  $explain = "";
  $lines = array(); //候補日チェック前

  //イベント名を取得
  $name = $_POST['event_name'];
  //イベント概要を取得
  $explain = $_POST['free'];
  //dateをPOSTで受け取り,開業区切りで配列に格納

  $event = $_POST['event_dates'];

  var_dump($event);
  echo "<br>";


  $event_dates = str_replace(['/r/n'|'/r'|'\n'], PHP_EOL, $_POST['event_dates']);
  $lines = explode(PHP_EOL, $event_dates);


  /////////////   イベント名チェック   /////////////
  if( $name == '' ){ //文字が入力されているかチェック
    $_SESSION[ 'message' ] = '<h4>イベント名が入力されていません</h4>';
    //header( "Location: ./dialog.php");
  }else{
    $name = html($name);
    $name = delete_sc_event($name);
    if(mb_strlen($name) > 120 ){
      $_SESSION[ 'messaege' ] = '<h4>イベント名の文字数がオーバーしています</h4>';
      //header( "Location: ./dialog.php");
    }
  }

  /////////////   イベント名概要   /////////////
  if(!(empty($explain))){  //入力されているかチェック
    //$explain = html($explain);
    //$explain = delete_sc_event($explain);
    if(mb_strlen($explain) > 300){ //文字数が300文字以上入力
      $_SESSION[ 'message' ] = '<h4>イベント概要の文字数がオーバーしています。</h4>';
      //header( "Location: ./dialog.php");
    }
  }

  /////////////   イベント候補日概要  /////////////
  if(count($lines) == 0){ //少なくとも候補日が1つ入力されているか
    $_SESSION[ 'message' ] = '<h4>候補日が入力されていません。</h4>';
  }else if(count($lines) > 30){ //候補日を20以上受け付けられるか
    $_SESSION[ 'message' ] = '<h4>入力した候補日が多すぎます。</h4>';
  }else{


    var_dump($lines);

    for($i=0; $i<count($lines); $i++){
      if($lines[$i] == "" || $lines[$i] == " "){
        unset($lines[$i]);
      }
    }

    array_values($lines);

    echo '<br>';
    var_dump($lines);



    for($i=0; $i<count($lines); $i++){
      $lines[$i] = html($lines[$i]);
      $lines[$i] = delete_sc_dates($lines[$i]);
    }

    $lines = array_splice($lines, 1, 3);

    // var_dump($lines);
  }

}else{
  $_SESSION[ 'message' ] = "<h4>不正なアクセスです。</h4>";
}




  // header("Location: ./event_url.php");


  // // header("Location: ./dialog.php");
  //
  //   if(empty($lines) == 0){
  //       //echo "候補日が入力されていません。";
  //   }else{
  //     // for($i=0; $i<count($lines); $i++) {
  //     //   exe_regist_event_and_event_date($name,$explain, $lines);
  //     // }
  //   }


?>
