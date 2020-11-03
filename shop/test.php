<?php
include_once('../_common.php');
include_once('../util/class_bizmsg_kakao.php');
//include "../util/class_bizmsg_kakao.php";

//auth_check($auth[$sub_menu], 'r');

$bizmsg_kakao = new class_bizmsg_kakao;
$bizmsg_kakao->insertBizMsgToDB('1111', '1111', 8);





//$safeMngr = new cSafeNumberMngr;
//$result = $safeMngr->createSafeNumber($_POST['mb_id'], $_POST['mb_hp']);

?>

<html>
<body>
hello world!
</body>
</html>