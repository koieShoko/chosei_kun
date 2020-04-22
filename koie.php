
<?php



include( "./access_db.php" );
#$dates=array('あした','あさって','しあさって',);
#$dates=array('4/22','4/25','4/26',);


#exe_regist_event_and_event_date('遊園地','遊びに行こう',$dates);
#exe_regist_event_and_event_date('勉強会','レッツ勉強',$dates);
#exe_regist_event_and_event_date('もくもく会','宿題でもしませんか',$dates);


#echo $global_url;


#regist_event_date('今日',3);
#echo $global_event_name;
#echo $global_url_rand;
#exe_delete_event_and_event_date('f3e7f412625d5f2d17c4');
#regist_member("石田","いつでもいいよ");
#regist_attendance(4,26,0);
#regist_attendance(4,27,0);
#regist_attendance(4,28,2);
#exe_delete_member_and_attendance(6);
#echo $global_member_id;

#$date_ids_and_attendances=array
#(
#    27=>1,
#    28=>0
#);
#exe_regist_member_and_attendance("大山","助かるよ",$date_ids_and_attendances);



#exe_get_event_name_sum_member_event_memo('d9ad03106319871646fe');
#echo $global_event_name;
#echo $global_sum_member;
#echo $global_event_memo;

get_member_names('d9ad03106319871646fe');
foreach($global_member_names as $member_name){
    echo $member_name;

}






?>