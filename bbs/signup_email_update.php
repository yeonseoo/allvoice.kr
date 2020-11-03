<?php
include_once('./_common.php');
include_once(G5_CAPTCHA_PATH . '/captcha.lib.php');
include_once(G5_LIB_PATH . '/register.lib.php');
include_once(G5_LIB_PATH . '/mailer.lib.php');
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

// 리퍼러 체크
referer_check();

if (!($w == '' || $w == 'u')) {
    alert('w 값이 제대로 넘어오지 않았습니다.');
}

$mb_id = isset($_POST['mb_id']) ? trim($_POST['mb_id']) : "";
$mb_password = isset($_POST['pw']) ? trim($_POST['pw']) : "";
$mb_password2 = isset($_POST['pw2']) ? trim($_POST['pw2']) : "";
$agree1 = isset($_POST['agree1']) ? trim($_POST['agree1']) : "N";       // 서비스 이용약관 동의
$agree2 = isset($_POST['agree2']) ? trim($_POST['agree2']) : "N";       // 개인정보 수집,이용 동의
$agree3 = isset($_POST['agree3']) ? trim($_POST['agree3']) : "N";       // 이벤트, 알림 수신 동의
$mb_mailling = ("Y" == $agree3) ? 1 : 0;
$mb_open = ("Y" == $agree3) ? 1 : 0;


$mb_id = clean_xss_tags($mb_id);
$mb_password = clean_xss_tags($mb_password);
$mb_password2 = clean_xss_tags($mb_password2);
$agree1 = clean_xss_tags($agree1);
$agree2 = clean_xss_tags($agree2);
$agree3 = clean_xss_tags($agree3);

if (empty($mb_id) || empty($mb_password) || empty($mb_password2)) {
    alert('회원가입 입력값이 잘못되었습니다.');
}

$sql = "select mb_id from {$g5['member_table']} where mb_id = '$mb_id'";
$result = sql_query($sql);

if (0 < $result->num_rows) {
    alert('이미 가입된 회원 이메일입니다.');
}

$sql = "insert  into {$g5['member_table']}
                set mb_id = '{$mb_id}',                    
                    mb_gubun = '99',                                            
                    mb_level = '2',                        
                    mb_password = '" . get_encrypt_string($mb_password) . "',
                    mb_name = '올보이스회원',
                    mb_nick = '올보이스회원',
                    mb_nick_date = '" . G5_TIME_YMD . "',
                    mb_email = '{$mb_id}',
                    mb_signature = '',
                    mb_today_login = '" . G5_TIME_YMDHIS . "',
                    mb_datetime = '" . G5_TIME_YMDHIS . "',
                    mb_ip = '{$_SERVER['REMOTE_ADDR']}',
                    mb_login_ip = '{$_SERVER['REMOTE_ADDR']}',
                    mb_open_date = '" . G5_TIME_YMD . "',
                    mb_memo = '',
                    mb_lost_certify = '',
                    mb_profile = '',
                    mb_mailling = {$mb_mailling},
                    mb_open = {$mb_open}            
                    ";

$mb_id = preg_replace("/[^0-9a-z_@.]+/i", "", $mb_id);

// echo "<script>alert('{$mb_id}');</script>";

$result = sql_query($sql);

// 회원 생성 실패
if (false == $result) {
    alert('회원 가입을 실패하였습니다.');
}

$mb = get_member($mb_id);
// echo "<script>alert('{$mb}');</script>";
$member = $mb;

// 회원아이디 세션 생성
set_session('ss_mb_id', $mb['mb_id']);
// FLASH XSS 공격에 대응하기 위하여 회원의 고유키를 생성해 놓는다. 관리자에서 검사함 - 110106
set_session('ss_mb_key', md5($mb['mb_datetime'] . get_real_client_ip() . $_SERVER['HTTP_USER_AGENT']));

set_cookie('ck_mb_id', '', 0);
set_cookie('ck_auto', '', 0);

// echo("<script>location.href='./signup_normal.php';</script>");

$link = urldecode($url);

//goto_url(G5_BBS_URL . "/signup_normal.php?url=".G5_BBS_URL."/signup_email.php");
goto_url(G5_BBS_URL . "/signup_normal.php");
