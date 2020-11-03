<?php

include_once('./_common.php');

define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_LIB_PATH.'/mailer.lib.php');


//$mailTo		=	"ad@dadastudio.com";
//$mailTo		=	"ad@dadastudio.com";
// if($_REQUEST["lan"] == "en"){
// 	$mailTo		=	$config["cf_admin_email_en"];
// }else{
// 	$mailTo		=	$config["cf_admin_email"];
// }

$mailTo		=	"dahee0506@naver.com";
$mailFrom	=	"allvoice@naver.com";

//$mailSubject = $_POST[eTitle];
$mailSubject = "후반작업 신청메일";

$mailCont = "
이름 : ".$_POST[it_name]."<br />
연락처 : ".$_POST[it_phone]."<br />
녹음파일사용용도 : ".$_POST[it_purpose];


$mailHeader = "From: $mailFrom\r\n";
$mailHeader .= "MIME-Version: 1.0\r\n";
$mailHeader .= "Content-type: text/html; charset=utf-8\r\n";

mailer("ALLVOICE", $mailFrom, $mailTo, $mailSubject, $mailCont, 1);

?>

<!doctype html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<meta content="IE=edge" http-equiv="X-UA-Compatible">
</head>
<body>

<?php 
//echo $mailSubject;
?>
<br /><br /><br /><br />
<?php 
//echo $mailCont;
?>

<script type="text/javascript">
<?php
	echo "alert('Thank you');";
	//echo "history.back()";
	echo "location.href='/shop'";
?>
</script>
</body>
</html>
