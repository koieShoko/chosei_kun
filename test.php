
<?php

include( "./test_access_db.php" );

#regist_event('誕生日会','みんなでお祝いしましょう','zxmkjhfaskjh');
get_event(1);

echo $global_event_name;

?>