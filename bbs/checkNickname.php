<?php
include_once('./_common.php');
// include_once(G5_CAPTCHA_PATH . '/captcha.lib.php');
// include_once(G5_LIB_PATH . '/register.lib.php');
// include_once(G5_LIB_PATH . '/mailer.lib.php');
// include_once(G5_LIB_PATH . '/thumbnail.lib.php');

// $is_member = true;

$mb_nickname = trim($_POST['nickname']);

$sql = "select count(*) as cnt from {$g5['member_table']} where mb_nick = '$mb_nickname'";
$result = sql_fetch($sql);

$data = array();
header('Content-type: application/json');

if (0 < $result['cnt']) {
    $data['error'] = "이미 사용중인 닉네임입니다.";
    echo json_encode($data);
    return;
}

$data['result'] = "사용 가능한 닉네임입니다.";
echo json_encode($data);