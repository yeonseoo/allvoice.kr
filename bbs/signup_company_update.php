<?php
include_once('./_common.php');

// 리퍼러 체크
referer_check();

if (!($w == '' || $w == 'u')) {
    alert('w 값이 제대로 넘어오지 않았습니다.');
}

if ($is_guest) {
    alert('회원만 이용하실 수 있습니다.');
}

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

// 담당자
$manager = isset($_POST['mb_name']) ? trim($_POST['mb_name']) : "";
// 상호명
$company_name = isset($_POST['nick']) ? trim($_POST['nick']) : "";
// 담당자 휴대폰 번호
$manager_hp = isset($_POST['mb_hp']) ? trim($_POST['mb_hp']) : "";
// 사업자 등록 번호
$company_no = isset($_POST['company_no']) ? trim($_POST['company_no']) : "";
// 사업자 등록 사본(파일)
$company_file = isset($_POST['company_no_file']) ? trim($_POST['company_no_file']) : "";

//
$sql = "select mb_id from {$g5['member_table']} where mb_id = '{$member['mb_id']}'";
$result = sql_query($sql);
$count = $result->num_rows;

if (1 > $count) {
    alert("회원정보가 없습니다.");
    goto_url(G5_BBS_URL . "/signup_company.php");
    return;
}

$sql = "update {$g5['member_table']} 
            set mb_gubun = '2',
                mb_name = '$manager', 
                mb_nick = '$company_name', 
                mb_hp = '$manager_hp',
                mb_company_no = '$company_no',
                mb_company_no_file = '$company_file',
                mb_4 = '$company_name',
                mb_5 = '$company_no'
        where mb_id = '{$member['mb_id']}'";

$result = sql_query($sql);

if (false == $result) {
    alert('회원 정보 변경을 실패했습니다.');
}

// 사업자 파일 업로드.
$txt_regex = "/(\.(gif|jpe?g|png|txt|pdf|pptx?|xlsx?|hwp|docx?))$/i";
$upload_dir = G5_DATA_PATH . '/company_no';
if (!is_dir($upload_dir)) {
    @mkdir($upload_dir, G5_DIR_PERMISSION);
    @chmod($upload_dir, G5_DIR_PERMISSION);
}

if (isset($_FILES['company_no_file']) && is_uploaded_file($_FILES['company_no_file']['tmp_name'])) {
    if (!preg_match($txt_regex, $_FILES['company_no_file']['name'])) {
        alert($_FILES['company_no_file']['name'] . '은(는) 이미지 혹은 문서 파일이 아닙니다.');
    }

    if (preg_match($txt_regex, $_FILES['company_no_file']['name'])) {
        @mkdir($upload_dir, G5_DIR_PERMISSION);
        @chmod($upload_dir, G5_DIR_PERMISSION);

        $ext = end(explode('.', $_FILES['company_no_file']['name']));

        $dest_file = $_FILES['company_no_file']['name'];
        $dest_path = $upload_dir . '/' .  uploadedFile($dest_file);

        // $upload_dir = APP_PATH . DIRECTORY_SEPARATOR . "company_no" . DIRECTORY_SEPARATOR;

        $check_move = move_uploaded_file($_FILES['company_no_file']['tmp_name'], $dest_path);
        chmod($dest_path, G5_FILE_PERMISSION);

        // 파일 업로드가 성공하면 파일경로 DB업데이트
        if (true == $check_move) {
            $sql = "update {$g5['member_table']} 
                        set mb_company_no_file = '$dest_file'
                    where mb_id = '{$member['mb_id']}'";
            $result = sql_query($sql);

            if (false == $result) {
                alert('회원 정보 변경을 실패했습니다.');
            }
        }
    }
}

function uploadedFile($uploadUrl, $fileName) {
    return iconv("utf-8", "CP949", $uploadUrl.basename2($fileName));
}

function basename2($filename) {
    return preg_replace( '/^.+[\\\\\\/]/', '', $filename);
}

goto_url(G5_BBS_URL . "/signup_complete.php");
