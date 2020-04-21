<?php



/* 
※コントローラでの使用非推奨
【1】初期化 

他の関数の呼び出しに先立って実行されなければならない。
MySQLサーバに接続し、データベースを使用可能な状態にする 
*/
$db_opened = 0;
$mysqili = null;

function init_db() {
	global $db_opened;
	global $mysqli;
	$mysqli = new mysqli( '127.0.0.1', 'chosei_kun', 'teamA', 'chosei_kun' );
	if( $mysqli->connect_error ) {
        return 1;
    }
	$db_opened = 1;
}






/*
※コントローラでの使用非推奨
【2.1】 イベントを登録する 

引数で与えられたURL用ランダム英数字（文字列）を持つイベントの
①イベント日程（文字列）を
データベースに登録する。
 */

function regist_event( $event_name, $event_memo ,$url_rand ) {
	global $db_opened;
	global $mysqli;
	if( $db_opened == 0 ) init_db();
    $sql =  'INSERT INTO event(
					event_name, 
					event_memo,
					created_at,
					url_rand 
				)VALUE( 
					?,?,NOW(),?
			)';
    $stmt = $mysqli->prepare($sql);
	if( $stmt->bind_param( 'sss', $event_name, $event_memo, $url_rand ) == FALSE ) return(1);
	if( $stmt->execute() == FALSE ) return(1);
    $stmt->close();
	return(0);
}


/*
【2.2】イベント日程を登録する  ※コントローラでの使用非推奨

引数で与えられたURL用ランダム英数字（文字列）を持つイベントの
①イベント日程（文字列）を
データベースに登録する。
*/
function regist_event_date( $event_date, $url_rand) {
	global $db_opened;
	global $mysqli;
    if( $db_opened == 0 ) init_db();
	$sql = 'INSERT INTO event_date ( 
				event_date, 
				event_id 
			)SELECT
				? , 
				event_id 
			FROM 
				event 
			WHERE 
				url_rand LIKE ? 
			';
    $stmt = $mysqli->prepare($sql);
	if( $stmt->bind_param( 'ss', $event_date, $url_rand ) == FALSE ) return(1);
    if( $stmt->execute() == FALSE ) return(1);
    $stmt->close();
	return(0);
}


/*
【2.3】イベントを作成する

"URL用ランダム英数字（文字列）を生成。regist_eventを実行後、成功すれば、すべての日程候補に対して、regist_event_dateを実行し、「http://127.0.0.1/chosei_kun/attendance_make.php?url_rand=」とURL用ランダム英数字を結合した文字列をグローバル変数
　　global_url
に格納する。
同じURL用ランダム英数字が、データベースへ登録済であった場合は、
regist_eventに失敗する。10回再試行しても登録に成功しない場合は、regist_event_dateを行わず処理を終了する。
イベントを作成したが、イベント日程の作成に失敗した場合には、イベントも削除する。"

*/
$grobal_url=null;
function exe_regist_event_and_event_date($event_name, $event_memo, $event_dates){
	global $global_url;
	$grobal_url=null;
	#url_rand重複による登録失敗を防ぐための再挑戦ループ
	for ($i=0; $i<10; $i++){
		#ランダム英数字を生成
		$url_rand=substr(bin2hex(random_bytes(20)), 0, 20);
		if (regist_event($event_name, $event_memo, $url_rand) == 1) return (1);
		foreach($event_dates as $date){
			if(regist_event_date($date,$url_rand)==1){
				exe_regist_event_and_event_date($url_rand);
				return(1);
			}
		}
		#URLをつくる
		$url="http://127.0.0.1/chosei_kun/attendance_make.php?url_rand=".$url_rand;		
		$global_url=$url;
		return (0);
	}

}




/*
【3】イベントの削除
引数で与えられたイベントURL用ランダム英数字（文字列）に関連するレコードを
①イベント表
②イベント日程表
のテーブルから削除する。
*/
function exe_delete_event_and_event_date($url_rand){
	global $db_opened;
	global $mysqli;
    if( $db_opened == 0 ) init_db();
	$sql = 'DELETE  
				FROM  
					event  
				WHERE  
					url_rand = ? 
			';
    $stmt = $mysqli->prepare($sql);
	if( $stmt->bind_param( 's', $url_rand ) == FALSE ) return(1);
    if( $stmt->execute() == FALSE ) return(1);
    $stmt->close();
	return(0);
}



/*
【4】回答者の登録
※コントロールモジュールからの使用非推奨

引数で与えられた
①　回答者名（文字列）
②　コメント（文字列）
をデータベースに登録する。
*/
function regist_member($member_name, $memmber_comment){
	global $db_opened;
	global $mysqli;
    if( $db_opened == 0 ) init_db();
	$sql = '
			INSERT INTO member (
					member_name,
					member_comment
				)VALUE(
					?,
					?
				)
			';
    $stmt = $mysqli->prepare($sql);
	if( $stmt->bind_param( 'ss', $member_name, $memmber_comment ) == FALSE ) return(1);
    if( $stmt->execute() == FALSE ) return(1);
    $stmt->close();
	return(0);
}





/*
【4】出欠情報を登録する

引数で与えられた出欠情報（整数）をデータベースに登録する。
*/
function regist_attendance($url_rand){
	global $db_opened;
	global $mysqli;
    if( $db_opened == 0 ) init_db();
	$sql = '
			';
    $stmt = $mysqli->prepare($sql);
	if( $stmt->bind_param( 's', $url_rand ) == FALSE ) return(1);
    if( $stmt->execute() == FALSE ) return(1);
    $stmt->close();
	return(0);
}















