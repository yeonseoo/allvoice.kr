<?php
include_once('./_common.php');
include_once(G5_LIB_PATH."/register.lib.php");
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$mb_id = $member['mb_id'];
//print_r($_REQUEST);exit;
$image_regex = "/(\.(mp3|wav|m4a|ogg|txt))$/i";
$mb_icon_img = $mb_id.'.gif';
$mb_img_dir = G5_DATA_PATH.'/member_voice/';
if( !is_dir($mb_img_dir) ){
	@mkdir($mb_img_dir, G5_DIR_PERMISSION);
	@chmod($mb_img_dir, G5_DIR_PERMISSION);
}
$mb_img_dir .= substr($mb_id,0,2);

if ( count( $_POST['title'] ) > 0 ) {
	for ( $i = 0; $i < count( $_POST['title'] ); $i++ ) {
		if ( trim($_POST['title'][$i]) == "" ) continue;
		//$_POST['dae'][$i] = ( $_POST['dae'][$i] == "y" ) ? "y" : "n";
		$sql_common = "  mv_title = '".$_POST['title'][$i]."',
						 mv_cat = '".$_POST['cat'][$i]."',
						 mv_gen = '".$_POST['gen'][$i]."',
						 mv_age = '".$_POST['age'][$i]."',
						 mv_sty = '".$_POST['sty'][$i]."',
						 mv_ton = '".$_POST['ton'][$i]."',
						 mv_lan = '".$_POST['lan'][$i]."',
						 mv_dae = '".$_POST['mv_dae'][$i]."' ";

		// 아이콘 업로드
		if (isset($_FILES['voice']) && is_uploaded_file($_FILES['voice']['tmp_name'][$i])) {
			if (!preg_match($image_regex, $_FILES['voice']['name'][$i])) {
				alert($_FILES['voice']['name'][$i] . '은(는) 음성 파일이 아닙니다.');
			}
//echo "test1";
			if (preg_match($image_regex, $_FILES['voice']['name'][$i])) {
				@mkdir($mb_img_dir, G5_DIR_PERMISSION);
				@chmod($mb_img_dir, G5_DIR_PERMISSION);

				// 회원 이미지 삭제
				if ($_POST['del_file'][$i])
					@unlink($mb_img_dir.'/'.$_POST['del_file'][$i]);

				$ext = end(explode('.', $_FILES['voice']['name'][$i])); 
				
				$dest_file = time().'_'.$i.'.'.$ext;
				$dest_path = $mb_img_dir.'/'.$dest_file;
				
				move_uploaded_file($_FILES['voice']['tmp_name'][$i], $dest_path);
				chmod($dest_path, G5_FILE_PERMISSION);

				$sql_common .= " ,mv_voice_origin = '".$_FILES['voice']['name'][$i]."' ,mv_voice = '".$dest_file."' ";
				/*
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
				*/
			}
		}

		if ( $_POST['del_chk'][$i] ) {
			$sql = " DELETE FROM {$g5['member_voice']}
					 WHERE mv_no = '".$_POST['del_chk'][$i]."'
			";
		}
		else if ( $_POST['mv_no'][$i] ) {
			$sql = " UPDATE {$g5['member_voice']}
						set {$sql_common}
					 WHERE mv_no = '".$_POST['mv_no'][$i]."'
			";
		}
		else {
			$sql = " INSERT INTO {$g5['member_voice']}
						set mb_id = '{$mb_id}',
							{$sql_common}
							,mv_date=now()
			";
		}
		//echo $sql."<br>";exit;
		sql_query($sql);
	}
}
goto_url('./voiceSample.php', false);
?>