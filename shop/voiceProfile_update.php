<?php
include_once('./_common.php');
include_once(G5_LIB_PATH."/register.lib.php");
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$mb_id = $member['mb_id'];

$sql_common = "  mb_sex = '{$_POST['mb_sex']}',
                 mb_memo = '{$_POST['mb_memo']}',
                 mb_profile = '{$_POST['mb_profile']}',
				 mb_state = '{$_POST['mb_state']}',
                 mb_8 = '{$_POST['mb_8']}',
                 mb_9 = '{$_POST['mb_9']}',
                 mb_10 = '{$_POST['mb_10']}',
				 mb_title = '{$_POST['mb_title']}'";

$image_regex = "/(\.(gif|jpe?g|png))$/i";
$mb_icon_img = $mb_id.'.gif';
$mb_img_dir = G5_DATA_PATH.'/member_image/';
if( !is_dir($mb_img_dir) ){
	@mkdir($mb_img_dir, G5_DIR_PERMISSION);
	@chmod($mb_img_dir, G5_DIR_PERMISSION);
}
$mb_img_dir .= substr($mb_id,0,2);

// 회원 이미지 삭제
if ($del_mb_img)
	@unlink($mb_img_dir.'/'.$mb_icon_img);

// 아이콘 업로드
if (isset($_FILES['mb_img']) && is_uploaded_file($_FILES['mb_img']['tmp_name'])) {
	if (!preg_match($image_regex, $_FILES['mb_img']['name'])) {
		alert($_FILES['mb_img']['name'] . '은(는) 이미지 파일이 아닙니다.');
	}
	
	if (preg_match($image_regex, $_FILES['mb_img']['name'])) {
		@mkdir($mb_img_dir, G5_DIR_PERMISSION);
		@chmod($mb_img_dir, G5_DIR_PERMISSION);
		
		$dest_path = $mb_img_dir.'/'.$mb_icon_img;
		
		move_uploaded_file($_FILES['mb_img']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);

		if (file_exists($dest_path)) {
			$size = @getimagesize($dest_path);
			if ($size[0] > $config['cf_member_img_width'] || $size[1] > $config['cf_member_img_height']) {
				$thumb = null;
				if($size[2] === 2 || $size[2] === 3) {
					//jpg 또는 png 파일 적용
					$thumb = thumbnail($mb_icon_img, $mb_img_dir, $mb_img_dir, $config['cf_member_img_width'], $config['cf_member_img_height'], true, true);
					if($thumb) {
						@unlink($dest_path);
						rename($mb_img_dir.'/'.$thumb, $dest_path);
					}
				}
				if( !$thumb ){
					// 아이콘의 폭 또는 높이가 설정값 보다 크다면 이미 업로드 된 아이콘 삭제
					@unlink($dest_path);
				}
			}
		}
	}
}

$sql = " update {$g5['member_table']}
			set {$sql_common}
			where mb_id = '{$mb_id}' ";
sql_query($sql);

goto_url('./voiceProfile.php', false);
?>