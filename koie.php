
<?php


#
#各モジュールの使い方紹介用
#コード集
#【】内の数字は、データベースに関するドキュメント内の
#関数番号に対応
#




include( "./access_db.php" );



#【2.3】
#$dates=array('4/22','4/25','4/26');
#exe_regist_event_and_event_date('遊園地','遊びに行こう',$dates);


#【3】
#exe_delete_event_and_event_date('afdsjsaldjlkdfjsal');


#【4.3】

$date_ids_and_attendances=array
(
    1=>2,
    2=>2
);
exe_regist_member_and_attendance("田中","幹事ありがと",$date_ids_and_attendances);




#【5】
#exe_delete_member_and_attendance(1);



#【6】
#/*
exe_get_event_name_sum_member_event_memo('d9ad03106319871646fe');
echo $global_event_name;
echo "<br>";
echo $global_sum_member;
echo "<br>";
echo $global_event_memo;
echo "<br>";
#*/

/*
#【7.1】回答者名／コメント一覧テスト用
get_member_ids_names_comments("afdsjsaldjlkdfjsal");
foreach($global_member_ids_names_comments as $key => $values){
    echo $key;
    foreach($values as $value){
        echo $value;
    }
}
*/



/*
#【7.2】出欠集計表テスト用
get_attendance_summary('afdsjsaldjlkdfjsal');
echo "<table>";
foreach($global_attendance_summary as $key=>$values)
{
    echo "<tr>";
    echo "<td>$key</td>";
    foreach($values as  $value)
        {
                echo "<td>$value</td>";
        }
    echo "</tr>";
}
echo "</table>";
*/

/*
#【7.3】日程別個人の出欠テスト
get_attendances(10,"afdsjsaldjlkdfjsal");
echo "<table>";
foreach($global_attendance as $values)
{
    echo "<tr>";
                echo "<td>$values</td>";
    echo "</tr>";
}
echo "</table>";

*/




#【7.4】
#/*
exe_get_attendance_condition_table('d9ad03106319871646fe');

echo "<table>";
$i=0;
foreach($global_attendance_condition_table as $key => $values){
    echo "<tr>";
    if($i==0){
        echo "";
    }else if($i==1){
        foreach($values as $value){
            echo "<th>",$value,"</th>";
        }
    }else{
        foreach($values as $value){
            echo "<td>",$value,"</td>";
        }
    }
    echo "<br>";
    $i+=1;
}
echo "</table>"
#/*



/*
#【8】日程IDと日程の連装配列を取得
exe_get_global_event_ids_and_names("d9ad03106319871646fe");
foreach($global_event_ids_and_names as $key => $value){
    echo $key,$value;
}#

*/
?>