<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/json.lib.php');
include "./cSafeNumberMngr.php";

//auth_check($auth[$sub_menu], 'r');

header("Content-Type: application/json");

$safeMngr = new cSafeNumberMngr;
$result = $safeMngr->createSafeNumber($_POST['mb_id'], $_POST['mb_hp']);

die(json_encode(array('error'=>'', 'safe_no'=>$result)));
