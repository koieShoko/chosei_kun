<?php



/* 
※コントローラでの使用非推奨
【1.1】初期化 

他の関数の呼び出しに先立って実行されなければならない。
MySQLサーバに接続し、データベースを使用可能な状態にする 
*/
$db_opened = 0;
$mysqli = null;

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
【1.2】接続終了 
※コントローラでの使用非推奨

MySQLサーバとの接続を切る。
*/

function close_db(){
	global $db_opened;
	global $mysqli;
	$mysqli->close();
	$db_opened = 0;
	return (0);
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
	close_db();
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
	close_db();
	return(0);
}


/*
【2.3】イベントと日程を同時に登録する

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
				exe_delete_event_and_event_date($url_rand);
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
	close_db();
	return(0);
}



/*
【4.1】回答者の登録
※コントロールモジュールからの使用非推奨

引数で与えられた
①　回答者名（文字列）
②　コメント（文字列）
をデータベースに登録する。
*/
$global_member_id = null;
function regist_member($member_name, $memmber_comment){
	global $db_opened;
	global $mysqli;
	global $global_member_id;
	$global_member_id= null;
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
	$global_member_id=$stmt->insert_id;
    $stmt->close();
	close_db();
	return(0);
}





/*
【4.2】出欠を登録する

※コントロールモジュールからの使用非推奨
引数で与えられた出欠情報（整数）をデータベースに登録する。
*/

function regist_attendance($member_id, $event_date_id, $attendance){
	global $db_opened;
	global $mysqli;
    if( $db_opened == 0 ) init_db();
	$sql = '
			INSERT INTO attendance(
					member_id,
					event_date_id,
					attendance
				)VALUE(
					?,
					?,
					?
			)
			';
    $stmt = $mysqli->prepare($sql);
	if( $stmt->bind_param( 'iii', $member_id, $event_date_id, $attendance ) == FALSE ) return(1);
    if( $stmt->execute() == FALSE ) return(1);
	$stmt->close();
	close_db();
	return(0);
}


/*

【4.3】回答者と出欠を同時に登録する

引数で与えられた出欠情報（整数）をデータベースに登録する。
*/


function exe_regist_member_and_attendance($member_name, $member_comment, $event_date_ids_and_attendances){
	global $global_member_id;
	$global_member_id = null;
	if(regist_member($member_name, $member_comment)==1)return (0);
	foreach($event_date_ids_and_attendances as $event_date_id=>$attendance){
		if(regist_attendance($global_member_id, $event_date_id, $attendance)==1){
			exe_delete_member_and_attendance($grobal_member_id);	
			return(1);
		}
	}
	$global_member_id = null;
	return (0);
}


/*
【5】 回答者情報と出席の削除

引数で与えられた回答者idに関連するレコードを
①回答者表
②出欠表
のテーブルから削除する。
*/

function exe_delete_member_and_attendance($member_id){
	global $db_opened;
	global $mysqli;
    if( $db_opened == 0 ) init_db();
	$sql = 'DELETE  
				FROM  
					member
				WHERE  
					member_id = ? 
			';
    $stmt = $mysqli->prepare($sql);
	if( $stmt->bind_param( 's', $member_id ) == FALSE ) return(1);
    if( $stmt->execute() == FALSE ) return(1);
    $stmt->close();
	close_db();
	return(0);
}






/*

【6.1】
イベント名・回答者数・詳細 を取得

引数で与えられたイベントURL用ランダム英数字（文字列）を持つレコードを取得し、
①イベント名（文字列）は
　グローバル変数　global_event_name
②回答者の合計人数（整数）は
　グローバル変数　global_sum_member
③イベントの説明文（文字列）は
　グローバル変数　global_event_memo
に格納する。


*/

$global_event_name=null;
$global_sum_member=null;
$global_event_memo=null;
function exe_get_event_name_sum_member_event_memo($url_rand){
	global $db_opened;
	global $mysqli;
	global $global_event_name;
	global $global_sum_member;
	global $global_event_memo;
	if( $db_opened == 0 ) init_db();
	$stmt = $mysqli->prepare("
		SELECT 
				event.event_name,
				count(member.member_id),
				event.event_memo

			FROM 
				member
			INNER JOIN 
					attendance
				ON 
					member.member_id = attendance.member_id 
			INNER JOIN
					event_date
				ON
					attendance.event_date_id = event_date.event_date_id
			INNER JOIN
					event
				ON
					event_date.event_id = event.event_id
			WHERE 
				event.url_rand = ?;
				
	");
	if( 
			$stmt->bind_param( 's', $url_rand )
		and
			$stmt->execute() 
		and	
			$stmt->store_result()
		and	
			$stmt->num_rows == 1//1件のレコードがヒット
		and
			$stmt->bind_result( $global_event_name, $global_sum_member, $global_event_memo ) 
		and
			$stmt->fetch()
		and
			$stmt->close()
		and
			close_db() == 0 //正常終了
	){
		return( 0 );
	}else{
		return( 1 );
	}
}







/*

【7.1】回答者の名前とコメントの一覧を取得する

引数で与えられたイベントURL用ランダム英数字（文字列）を持つレコードを取得し、
　回答者ID（整数）
をキーとし、以下の要素を持つ配列を値とする連想配列を作成し、グローバル変数
　$global_member_ids_names_commentsに格納する。
上記の要素とは
①回答者の名前（配列・整数）
②回答者のコメント（配列・文字列）
である。

*/


$global_member_ids_names_comments=null;
function get_member_ids_names_comments($url_rand){
	global $db_opened;
	global $mysqli;
	global $global_member_ids_names_comments;
	$global_member_ids_names_comments=[];
	if( $db_opened == 0 ) init_db();
	$stmt = $mysqli->prepare("
		SELECT  
			DISTINCT 
				member.member_id,
				member.member_name,
				member.member_comment
			FROM  
				member 
			INNER JOIN  
					attendance 
				ON   
					member.member_id = attendance.member_id  
			INNER JOIN 
					event_date 
				ON 
					attendance.event_date_id = event_date.event_date_id 
			INNER JOIN 
					event  
				ON 
					event_date.event_id = event.event_id 
			WHERE  
				event.url_rand = ? 
	");
	if( 
			$stmt->bind_param( 's', $url_rand )
		and
			$stmt->execute() 
		and	
			$stmt->store_result()
		and
			$stmt->bind_result( $member_id, $member_name, $member_comment ) 
	){
		while($stmt->fetch())
		{
			$global_member_ids_names_comments+=array($member_id => [$member_name, $member_comment]);
		}
		$stmt->close();
		close_db();
		return (0);
	}else
	{
		$stmt->close();
		close_db();		
		return (1);
	}
}



/*

【7.2】全日程の出欠集計を取得する

引数で与えられたイベントURL用ランダム英数字（文字列）を持つレコードを取得し、
　日程候補ID（整数）
をキーとし、以下の要素を持つ配列を値とする連想配列を作成し、グローバル変数
　$global_attendance_summaryに格納する。
上記の要素とは、
①　日程（文字列）　
②　〇を選んだ回答者の人数（整数）
③　△を選んだ回答者の人数（整数）
④　×を選んだ回答者の人数（整数）
である。

*/

$global_attendance_summary=null;
function get_attendance_summary($url_rand){
	global $db_opened;
	global $mysqli;
	global $global_attendance_summary;
	$global_attendance_summary=[];
	if( $db_opened == 0 ) init_db();
	$stmt = $mysqli->prepare("
		SELECT 
				event_date.event_date_id,
				event_date.event_date,
				COUNT(attendance.attendance = 2 OR NULL),  
				COUNT(attendance.attendance = 1 OR NULL), 
				COUNT(attendance.attendance = 0 OR NULL) 
			FROM  
				member 
			INNER JOIN  
					attendance 
				ON  
					member.member_id = attendance.member_id  
			INNER JOIN 
					event_date 
				ON 
					attendance.event_date_id = event_date.event_date_id 
			INNER JOIN 
					event 
				ON 
					event_date.event_id = event.event_id 
			WHERE  
				event.url_rand = ? 
			GROUP BY  
				event_date.event_date_id;
	");
	if( 
			$stmt->bind_param( 's', $url_rand )
		and
			$stmt->execute() 
		and	
			$stmt->store_result()
		and
			$stmt->bind_result( $event_date_id, $event_name, $sum_2, $sum_1, $sum_0 ) 
	){
		while($stmt->fetch())
		{
			$global_attendance_summary+=array($event_date_id => [ $event_name, $sum_2, $sum_1, $sum_0 ] );
		}
		$stmt->close();
		close_db();
		return (0);
	}else
	{
		$stmt->close();
		close_db();		
		return (1);
	}
}


/*

【7.3】出欠を取得する

引数で与えられた日程ID（整数）を持つレコードを取得し、
参加者ごとの出欠を要素とする配列をグローバル変数
　$global_attendance
に格納する。


*/

$global_attendance=null;
function get_attendances($event_date_id){
	global $db_opened;
	global $mysqli;
	global $global_attendance;
	$global_attendance=[];
	if( $db_opened == 0 ) init_db();
	$stmt = $mysqli->prepare("
		SELECT 
				attendance.attendance
			FROM 
				attendance
			INNER JOIN 
					member
				ON 
					attendance.member_id = member.member_id 
			INNER JOIN
					event_date
				ON
					attendance.event_date_id = event_date.event_date_id
			INNER JOIN
					event
				ON
					event_date.event_id = event.event_id
			WHERE 
				event_date.event_date_id = ? 
			ORDER BY
				member.member_id
				
	");
	if( 
			$stmt->bind_param( 'i', $event_date_id)
		and
			$stmt->execute() 
		and	
			$stmt->store_result()
		and
			$stmt->bind_result( $attendance ) 
	){
		while($stmt->fetch())
		{
			$global_attendance[]=$attendance;
		}
		$stmt->close();
		close_db();
		return (0);
	}else
	{
		$stmt->close();
		close_db();		
		return (1);
	}
}




/*

【7.4】出欠状況表に必要な情報を取得する

url用ランダム英数字（文字列）を引数として渡し、
7-1 get_member_ids_names_comments()
7-2 get_attendance_summary()
7-3 get_attendances()
を実行する。
この結果を以下の要素をもつに格納する。
要素1  			空文字、空文字、空文字、空文字、回答者ID（人数分）
要素2  			「"日程"」、「"○"」、「"△"」、「"×"」、回答者名（人数分）
要素3...n行目 	日程名、○選択者の人数、△選択者の人数、×選択者の人数、回答者各個人の回答（人数分）
最終行			 空文字、空文字、空文字、空文字、回答者のコメント（人数分）

*/
#/*
$global_attendance_condition_table=null;
function exe_get_attendance_condition_table($url_rand){

	#先頭行と末尾の行を作成する
	global $global_member_ids_names_comments;
	$global_member_ids_names_comments = null;
	get_member_ids_names_comments($url_rand);
	$member_ids       = [];
	$member_names     = [];
	$member_comments  = [];
	foreach($global_member_ids_names_comments as $key=>$values){
		$member_ids[]=$key;
	}
	foreach($global_member_ids_names_comments as $key=>$values){
		$member_names[]=$values[0];
	}
	foreach($global_member_ids_names_comments as $key=>$values){
		$member_comments[]=$values[1];
	} 
	$row_0=array_merge( array("","","",""), $member_ids);
	$row_1=array_merge( array("日程","○","△","×"), $member_names);
	$row_last=array_merge( array("コメント","","",""), $member_comments);

	#間の行
	$row_n=[];
	global $global_attendance_summary;
	$global_attendance_summary = null;
	get_attendance_summary($url_rand);
	$i=0;
	foreach($global_attendance_summary as $key => $values){
		$row=array();
		foreach($values as $value){
			$row[]=$value;
		}
		global $global_attendance;
		get_attendances($key);
		$tmp=[];
		foreach($global_attendance as $attendance){
			if($attendance ==0){
				$tmp[]="×";
			}else if($attendance ==1){
				$tmp[]="△";
			}else{
				$tmp[]="○";
			}
		}
		$row_n[$i]=array_merge($row,$tmp);
		$i+=1;
	}
	#まとめる
	global $global_attendance_condition_table;
	$global_attendance_condition_table=array($row_0,$row_1);
	foreach($row_n as $row){
		$global_attendance_condition_table[]=$row;
	}
	$global_attendance_condition_table[]=$row_last;
	return (0);
}




#*/



/*
【8】イベント日程を取得する

引数で与えられたイベントURL用ランダム英数字（文字列）を持つレコードを取得し、
①イベント日程id（整数）をキー
　イベント日程（配列・文字列）を値とする
　グローバル連想配列　global_event_ids_and_names
に格納する
*/
$global_event_ids_and_names=null;
function exe_get_global_event_ids_and_names($url_rand){
		global $db_opened;
		global $mysqli;
		global $global_event_ids_and_names;
		$global_event_ids_and_names=[];
		if( $db_opened == 0 ) init_db();
		$stmt = $mysqli->prepare("
			SELECT 
				event_date_id,
				event_date
				FROM 
					event_date
				INNER JOIN 
					event
				ON
					event_date.event_id = event.event_id
				WHERE  
					event.url_rand = ? 
				ORDER BY  
					event_date_id 
		");
		if( 
				$stmt->bind_param( 's', $url_rand)
			and
				$stmt->execute() 
			and	
				$stmt->store_result()
			and
				$stmt->bind_result( $event_id, $event_date ) 
		){
			while($stmt->fetch())
			{
				$global_event_ids_and_names+=array($event_id => $event_date);
			}
			$stmt->close();
			close_db();
			return (0);
		}else
		{
			$stmt->close();
			close_db();		
			return (1);
		}
	
}