<?php



/* MySQLサーバに接続し、データベースを使用可能な状態にする */
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







/* 利用者IDに対する利用者名を返す */

$global_url=null;

function regist_event( $event_name, $event_memo ,$url_rand ) {
	global $db_opened;
	global $mysqli;
	global $global_url;
    if( $db_opened == 0 ) init_db();
    $sql='INSERT INTO event(event_name, event_memo, created_at, url_rand )VALUE( ?,?,NOW(),?)';
    $stmt = $mysqli->prepare($sql);
	if( $stmt->bind_param( 'sss', $event_name, $event_memo, $url_rand ) == FALSE ) return( 1 );
    if( $stmt->execute() == FALSE ) return( 2 );
    $stmt->close();
	return( 3 );
}



/* 利用者IDに対する利用者名を返す */

$global_event_name=null;
function get_event( $event_id ) {
	global $db_opened;
	global $mysqli;
	global $global_event_name;
    if( $db_opened == 0 ) init_db();
	$stmt = $mysqli->prepare("SELECT event_name FROM event WHERE event_id = ?");
	if( $stmt->bind_param( 'i', $event_id ) == FALSE ) return( 1 );
	if( $stmt->execute() == FALSE ) return( 2 );
	if( $stmt->store_result() == FALSE ) return( 3 );
	if( $stmt->num_rows == 0 ) {return( 4 );
	}
	if( $stmt->bind_result( $global_event_name ) == FALSE ) return( 5 );
	if( $stmt->fetch() == FALSE ) return( 1 );
    $stmt->close();
    return( 7 );
}

