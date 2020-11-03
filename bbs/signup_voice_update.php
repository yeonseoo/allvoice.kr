<?php
include_once('./_common.php');

if (!($w == '' || $w == 'u')) {
    alert('w 값이 제대로 넘어오지 않았습니다.');
}

// 리퍼러 체크
referer_check();

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

$mb_gubun = isset($_POST['form_voice_type']) ? trim($_POST['form_voice_type']) : "4";   // 회원 구분
$mb_name = isset($_POST['mb_name']) ? trim($_POST['mb_name']) : "";                     // 이름
$mb_sex = isset($_POST['form_voice_gen']) ? trim($_POST['form_voice_gen']) : "";        // 성별
$mb_nickname = isset($_POST['nick']) ? trim($_POST['nick']) : "";                       // 활동명
$mb_hp = isset($_POST['mb_hp']) ? trim($_POST['mb_hp']) : "";                       // 핸드폰
$mb_network_from = isset($_POST['network_from']) ? trim($_POST['network_from']) : "";   // 출신 방송국
$mb_network_entry_year = isset($_POST['year']) ? trim($_POST['year']) : "";             // 입사년도
$mb_rec_device = isset($_POST['rec_device']) ? trim($_POST['rec_device']) : "";         // 녹음장비
$mb_rec_interface = isset($_POST['rec_interface']) ? trim($_POST['rec_interface']) : "";//
$mb_title = isset($_POST['profile_title']) ? conv_content($_POST['profile_title']) : ""; // 프로필 제목
$mb_profile = isset($_POST['profile']) ? conv_content($_POST['profile']) : "";          // 프로필 등록
$mb_memo = isset($_POST['activity']) ? conv_content($_POST['activity']) : "";          // 주요작품 및 클라이언트

$mb_gubun = clean_xss_tags($mb_gubun);
$mb_name = clean_xss_tags($mb_name);
$mb_nickname = clean_xss_tags($mb_nickname);
$mb_hp = clean_xss_tags($mb_hp);
$mb_network_from = clean_xss_tags($mb_network_from);
$mb_network_entry_year = clean_xss_tags($mb_network_entry_year);
$mb_rec_device = clean_xss_tags($mb_rec_device);
$mb_rec_interface = clean_xss_tags($mb_rec_interface);
// $mb_profile = clean_xss_tags($mb_profile);


$sql = "select mb_id from {$g5['member_table']} where mb_id = '$mb_id'";
$result = sql_query($sql);
$count = $result->num_rows;

if (1 > $count) {
    alert('회원 정보가 잘못되었습니다.');
}

$sql = "update {$g5['member_table']} 
            set mb_gubun            = '$mb_gubun',
                mb_name             = '$mb_name',
                mb_sex              = '$mb_sex', 
                mb_nick             = '$mb_nickname', 
                mb_hp               = '$mb_hp',
                mb_network_from     = '$mb_network_from',
                mb_network_year     = '$mb_network_entry_year',
                mb_rec_device       = '$mb_rec_device',
                mb_rec_interface    = '$mb_rec_interface',            
                mb_title            = '$mb_title',
                mb_profile          = '$mb_profile',
                mb_memo             = '$mb_memo',
                mb_9                = '{$mb_network_from}/{$mb_network_entry_year}',
                mb_10               = '{$mb_rec_device}/{$mb_rec_interface}'
        where mb_id = '{$member['mb_id']}'";

$result = sql_query($sql);


/////===== 녹음 생플 등록 ======/////
//print_r($_REQUEST);exit;
$image_regex = "/(\.(mp3|wav|m4a|ogg|txt))$/i";
$mb_icon_img = $mb_id . '.gif';
$mb_img_dir = G5_DATA_PATH . '/member_voice/';
if (!is_dir($mb_img_dir)) {
    @mkdir($mb_img_dir, G5_DIR_PERMISSION);
    @chmod($mb_img_dir, G5_DIR_PERMISSION);
}
$mb_img_dir .= substr($mb_id, 0, 2);


if (isset($_FILES['voice']) && is_uploaded_file($_FILES['voice']['tmp_name'])) {
    $sql_common = "  mv_title = '" . $_POST['title'] . "',
						 mv_cat = '" . $_POST['cat'] . "',
						 mv_gen = '" . $_POST['audio_gen'] . "',
						 mv_age = '" . $_POST['age'] . "',
						 mv_sty = '" . $_POST['sty'] . "',
						 mv_ton = '" . $_POST['ton'] . "',
						 mv_lan = '" . $_POST['lan'] . "',
						 mv_dae = '" . $_POST['main_audio'] . "' ";

    if (!preg_match($image_regex, $_FILES['voice']['name'])) {
        alert($_FILES['voice']['name'] . '은(는) 음성 파일이 아닙니다.');
    }

    if (preg_match($image_regex, $_FILES['voice']['name'])) {
        @mkdir($mb_img_dir, G5_DIR_PERMISSION);
        @chmod($mb_img_dir, G5_DIR_PERMISSION);

        // 회원 이미지 삭제
        if ($_POST['del_file'])
            @unlink($mb_img_dir . '/' . $_POST['del_file']);

        $ext = end(explode('.', $_FILES['voice']['name']));

        $dest_file = time() . '_' . $i . '.' . $ext;
        $dest_path = $mb_img_dir . '/' . $dest_file;

        $upload_check = move_uploaded_file($_FILES['voice']['tmp_name'], $dest_path);
        chmod($dest_path, G5_FILE_PERMISSION);

        //alert($dest_path);

        $sql_common .= " ,mv_voice_origin = '" . $_FILES['voice']['name'] . "' ,mv_voice = '" . $dest_file . "' ";

        $sql = " INSERT INTO {$g5['member_voice']}
						set mb_id = '{$mb_id}',
							{$sql_common}
							,mv_date=now()
			";

        // 에러처리
        sql_query($sql);
    }
}

// alert("test");
// return;


if (false == $result) {
    alert('회원 정보 변경을 실패했습니다.');
}

//goto_url(G5_BBS_URL . "/signup_complete.php");

goto_url(G5_BBS_URL . "/signup_complete.php");

