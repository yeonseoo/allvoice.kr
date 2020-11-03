<?php
include_once('./_common.php');

if (!($w == '' || $w == 'u')) {
    alert('w 값이 제대로 넘어오지 않았습니다.');
}

if ($is_guest) {
    alert('회원만 이용하실 수 있습니다.');
}

// 리퍼러 체크
referer_check();

// 접속된 회원 아이디
$mb_id = $member['mb_id'];

/*
// 회원 구분이 미등록(99)인지 확인.
$sql = "SELECT mb_gubun FROM {$g5['member_table']} where mb_id = '$mb_id'";
$result = sql_fetch($sql);

if ($result) {
    if ("99" != $result['mb_id']) {
        alert("회원 정보는 마이페이지에서 변경해 주세요.", G5_SHOP_URL);
    }
} else {
    alert("변경할 회원 정보가 없습니다.");
}
*/

$mb_name = isset($_POST['mb_name']) ? trim($_POST['mb_name']) : "";     // 이름
$mb_nickname = isset($_POST['nick']) ? trim($_POST['nick']) : "";       // 닉네임
$mb_hp = isset($_POST['mb_hp']) ? trim($_POST['mb_hp']) : "";       // 핸드폰

$mb_name = clean_xss_tags($mb_name);
$mb_nickname = clean_xss_tags($mb_nickname);
$mb_hp = clean_xss_tags($mb_hp);

$sql = "select mb_id from {$g5['member_table']} where mb_id = '$mb_id'";
$result = sql_query($sql);
$count = $result->num_rows;

if (1 > $count) {
    alert('회원 정보가 잘못되었습니다.');
}

$sql = "update {$g5['member_table']} 
            set mb_gubun = '1', 
                mb_name = '$mb_name',
                mb_nick = '$mb_nickname', 
                mb_hp = '$mb_hp' 
        where mb_id = '$mb_id'";

$result = sql_query($sql);

if (false == $result) {
    alert('회원 정보 변경을 실패했습니다.');
}

goto_url(G5_BBS_URL . "/signup_complete.php");