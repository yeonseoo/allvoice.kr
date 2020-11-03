<?php

include_once('./_common.php');
include_once('../util/MailAPI_NCloud.php');

$email = $_POST['email'];

$data = array();
header('Content-type: application/json');

$email = get_email_address(trim($_POST['email']));
if (!$email) {
    $data['error'] = "이메일 형식 오류입니다.";
    echo json_encode($data);
    return;
}

$sql = "SELECT count(*) AS cnt FROM g5_member WHERE mb_id = '$email' OR mb_email = '$email'";
$result = sql_fetch($sql);

// 이메일 주소가 존재 에러처리
if (0 < $result['cnt']) {
    $data['error'] = "동일한 이메일 주소가 존재합니다.";
    echo json_encode($data);
    return;
}

$cert_key_md5 = md5(pack('V*', rand(), rand(), rand(), rand()));

$sql = "SELECT count(*) AS cnt FROM allv_member_email_cert WHERE mb_id = '$email'";
$result = sql_fetch($sql);

// 이메일 주소가 존재 에러처리
if (0 < $result['cnt']) {
    $sql = "update allv_member_email_cert set create_date = NOW(), cert_key ='$cert_key_md5', cert_yn = 'N'";

} else {
    $sql = "insert allv_member_email_cert set mb_id = '$email', create_date = NOW(), cert_key ='$cert_key_md5'";
}

$result = sql_query($sql);

if (false == $result) {
    $data['error'] = "올보이스에 문의해 주십시오.";
    echo json_encode($data);
    return;
}

$url_link = G5_BBS_URL."/cert_email.php?cert_key=" . $cert_key_md5;

$subject = "올보이스(주) 회원가입 인증메일";
$content = "<p>회원 가입을 위해 아래 링크주소를 클릭해주세요</p><br>";
$content .= "<a href='$url_link'><p>$url_link</p></a><br>";


$mailAPI = new MailAPI_NCloud();
$mailAPI->sendMail($email, $subject, $content);

$data['result'] = "인증 메일이 전송되었습니다.";

echo json_encode($data);






