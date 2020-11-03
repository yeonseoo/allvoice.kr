<?php
include_once('./_common.php');

if (isset($_SESSION['ss_mb_reg'])) {
    $mb_tmp = get_member($_SESSION['ss_mb_reg']);
	if ( $mb_tmp['mb_level'] > 1 ) $mb = $mb_tmp;
}

// 회원정보가 없다면 초기 페이지로 이동
if (!$mb['mb_id'])
	goto_url(G5_BBS_URL."/logout.php?url=shop");
    //goto_url(G5_URL."/shop/");

$g5['title'] = '회원가입 완료';
include_once('./_head.php');
include_once($member_skin_path.'/register_result.skin.php');
include_once('./_tail.php');
?>