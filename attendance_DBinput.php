<!doctype html>
<html lang="ja">
  <head>
	<meta charset="utf-8">
	<title>調整くん</title>
  </head>
  <body>

<?php
	$member_name = $_POST['member_name'];
	//$kouho,"$c" = $_POST['kouho',$c,''];	
	$member_comment = $_POST['member_comment'];


foreach($_POST as $key =>$value){
	if($key=="member_name"){
		echo "";
	}else if($key=="member_comment"){
		echo "";
	}else{
			echo $value;
			echo "<br>";
			//echo $key;
			echo "<br>";
	}
	
//echo $key,$value;
}



	//echo $member_name;
	//echo $kouho"$c";  
	//echo $member_comment;


?>

  </body>
</html>
