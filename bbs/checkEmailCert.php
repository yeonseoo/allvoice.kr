<?php
include_once('./_common.php');
include_once('../util/MailAPI_NCloud.php');

$email = $_POST['email'];

$email = get_email_address(trim($_POST['email']));

if (!$email) {
    // alert_close('메일주소 오류입니다.');
}

$sql = "select cert_yn from allv_member_email_cert where mb_id = '$email'";
$result = sql_fetch($sql);

$data = array();
header('Content-type: application/json');

if ($result) {
    if ("N" == $result['cert_yn']) {
        $data['error'] = "이메일 인증을 해주세요.";
        echo json_encode($data);
        return;
    } else {
        $data['result'] = "이메일 인증이 확인되었습니다.";
        echo json_encode($data);
        return;
    }
}

$data['error'] = "등록된 이메일 인증이 없습니다. 이메일 인증하기 버튼을 클릭해주세요.";
echo json_encode($data);