<?php
$sub_menu = '300900';
include_once('./_common.php');

if ($w == "u" || $w == "d")
    check_demo();

if ($w == 'd')
    auth_check($auth[$sub_menu], "d");
else
    auth_check($auth[$sub_menu], "w");

check_admin_token();

if ($w == "" || $w == "u")
{
    //if(preg_match("/[^a-z0-9_]/i", $co_id)) alert("ID 는 영문자, 숫자, _ 만 가능합니다.");

    $sql = " select * from {$g5['after_table']} where co_id = '$co_id' ";
    $co_row = sql_fetch($sql);
}

//$co_id = preg_replace('/[^a-z0-9_]/i', '', $co_id);
$co_subject = strip_tags($co_subject);
$co_include_head = preg_replace(array("#[\\\]+$#", "#(<\?php|<\?)#i"), "", substr($co_include_head, 0, 255));
$co_include_tail = preg_replace(array("#[\\\]+$#", "#(<\?php|<\?)#i"), "", substr($co_include_tail, 0, 255));

// 관리자가 자동등록방지를 사용해야 할 경우
if (($co_row['co_include_head'] !== $co_include_head || $co_row['co_include_tail'] !== $co_include_tail) && function_exists('get_admin_captcha_by') && get_admin_captcha_by()){
    include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

    if (!chk_captcha()) {
        alert('자동등록방지 숫자가 틀렸습니다.');
    }
}

@mkdir(G5_DATA_PATH."/after", G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH."/after", G5_DIR_PERMISSION);

if ($co_himg_del)  @unlink(G5_DATA_PATH."/after/".str_replace("-","",substr($co_row['co_date'],0,10))."/".$co_row['co_file']);

$error_msg = '';

if ($_FILES['co_file']['name'])
{
	$ext = end(explode('.', $_FILES['co_file']['name'])); 
	$dest_file = 'it_file_'.time().'.'.$ext;

	$dest_path = G5_DATA_PATH."/after/".date("Ymd")."/".$dest_file;
	@move_uploaded_file($_FILES['co_file']['tmp_name'], $dest_path);
	@chmod($dest_path, G5_FILE_PERMISSION);
}

$sql_common = " co_subject    = '$co_subject',
				co_mobile     = '$co_mobile',
				co_file       = '$dest_file',
                co_name       = '$co_name' ";

if ($w == "")
{
    $row = $co_row;
    if ($row['co_id'])
        alert("이미 같은 ID로 등록된 내용이 있습니다.");

    $sql = " insert {$g5['after_table']}
                set co_id = '$co_id',
                    $sql_common ";
    sql_query($sql);
}
else if ($w == "u")
{
    $sql = " update {$g5['after_table']}
                set $sql_common
              where co_id = '$co_id' ";
    sql_query($sql);
}
else if ($w == "d")
{
    @unlink(G5_DATA_PATH."/after/".str_replace("-","",substr($co_row['co_date'],0,10))."/".$co_row['co_file']);

    $sql = " delete from {$g5['after_table']} where co_id = '$co_id' ";
    sql_query($sql);
}

if(function_exists('get_admin_captcha_by'))
    get_admin_captcha_by('remove');

if ($w == "" || $w == "u")
{

    if( $error_msg ){
        alert($error_msg, "./afterform.php?w=u&amp;co_id=$co_id");
    } else {
        goto_url("./afterform.php?w=u&amp;co_id=$co_id");
    }
}
else
{
    goto_url("./afterlist.php");
}
?>
