<?php
include_once('./_common.php');
include_once(G5_LIB_PATH."/register.lib.php");
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

if ($is_guest) {
    alert('회원만 이용하실 수 있습니다.', G5_URL.'/index.php');
	exit;
}

$it_id = time();
$it_maker = $member['mb_id'];

$sql_common = " ca_id               = '$ca_id',
				it_maker            = '$it_maker',
                it_name             = '$it_name',
                it_explan           = '$it_explan',
                it_explan2          = '$it_explan2',
                it_mobile_explan    = '$it_explan',
                it_price            = '$it_price',
				it_use              = '0',
                it_soldout          = '0',
                it_stock_qty        = '9999',
                it_ip               = '{$_SERVER['REMOTE_ADDR']}',
                it_info_gubun       = 'etc',
				it_basic            = '기본설명',
				it_head_html        = ' ',
				it_tail_html        = ' ',
				it_mobile_head_html = ' ',
				it_mobile_tail_html = ' ',
				it_info_value       = ' ',
				it_use_avg          = '0.0',
				it_shop_memo        = ' ',
                it_1                = '$it_1',
                it_2                = '$it_2',
                it_3                = '$it_3',
                it_4                = '$it_4',
                it_5                = '$it_5',
                it_6                = '$it_6',
                it_view_time        = '$it_view_time'
                ";

$image_regex = "/(\.(gif|jpe?g|png))$/i";
$txt_regex = "/(\.(gif|jpe?g|png|txt|pdf|pptx?|xlsx?|hwp|docx?))$/i";
$upload_dir = G5_DATA_PATH.'/item/';
if( !is_dir($upload_dir) ){
	@mkdir($upload_dir, G5_DIR_PERMISSION);
	@chmod($upload_dir, G5_DIR_PERMISSION);
}
$upload_dir .= $it_id;

// 대표이미지 업로드
if (isset($_FILES['it_img1']) && is_uploaded_file($_FILES['it_img1']['tmp_name'])) {
	if (!preg_match($image_regex, $_FILES['it_img1']['name'])) {
		alert($_FILES['it_img1']['name'] . '은(는) 이미지 파일이 아닙니다.');
	}
//echo "test1";
	if (preg_match($image_regex, $_FILES['it_img1']['name'])) {
		@mkdir($upload_dir, G5_DIR_PERMISSION);
		@chmod($upload_dir, G5_DIR_PERMISSION);

		// 회원 이미지 삭제
		//if ($_POST['del_file'])
		//	@unlink($upload_dir.'/'.$_POST['del_file']);

		$ext = end(explode('.', $_FILES['it_img1']['name'])); 
		
		$dest_file = $it_id.'.'.$ext;
		$dest_path = $upload_dir.'/'.$dest_file;
		
		move_uploaded_file($_FILES['it_img1']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);

		$sql_common .= " ,it_img1 = '".$dest_file."' ";
		/*
		if (file_exists($dest_path)) {
			$size = @getimagesize($dest_path);
			if ($size[0] > $config['cf_member_img_width'] || $size[1] > $config['cf_member_img_height']) {
				$thumb = null;
				if($size[2] === 2 || $size[2] === 3) {
					//jpg 또는 png 파일 적용
					$thumb = thumbnail($mb_icon_img, $upload_dir, $upload_dir, $config['cf_member_img_width'], $config['cf_member_img_height'], true, true);
					if($thumb) {
						@unlink($dest_path);
						rename($upload_dir.'/'.$thumb, $dest_path);
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

// 대본파일 업로드                it_7                = '$it_7',
if (isset($_FILES['it_7']) && is_uploaded_file($_FILES['it_7']['tmp_name'])) {
	if (!preg_match($txt_regex, $_FILES['it_7']['name'])) {
		alert($_FILES['it_7']['name'] . '은(는) 이미지 혹은 문서 파일이 아닙니다.');
	}
//echo "test1";
	if (preg_match($txt_regex, $_FILES['it_7']['name'])) {
		@mkdir($upload_dir, G5_DIR_PERMISSION);
		@chmod($upload_dir, G5_DIR_PERMISSION);

		// 회원 이미지 삭제
		//if ($_POST['del_file'])
		//	@unlink($upload_dir.'/'.$_POST['del_file']);

		$ext = end(explode('.', $_FILES['it_7']['name'])); 
		
		$dest_file = 'it_7_'.$it_id.'.'.$ext;
		$dest_path = $upload_dir.'/'.$dest_file;
		
		move_uploaded_file($_FILES['it_7']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);

		$sql_common .= " ,it_7 = '".$dest_file."' ,it_8 = '".$_FILES['it_7']['name']."' ";
		/*
		if (file_exists($dest_path)) {
			$size = @getimagesize($dest_path);
			if ($size[0] > $config['cf_member_img_width'] || $size[1] > $config['cf_member_img_height']) {
				$thumb = null;
				if($size[2] === 2 || $size[2] === 3) {
					//jpg 또는 png 파일 적용
					$thumb = thumbnail($mb_icon_img, $upload_dir, $upload_dir, $config['cf_member_img_width'], $config['cf_member_img_height'], true, true);
					if($thumb) {
						@unlink($dest_path);
						rename($upload_dir.'/'.$thumb, $dest_path);
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
$sql_common .= " , it_time = '".G5_TIME_YMDHIS."' ";
$sql_common .= " , it_update_time = '".G5_TIME_YMDHIS."' ";

$sql = " INSERT INTO {$g5['g5_shop_item_table']}
			set it_id = '$it_id',
				{$sql_common}
";
//echo $sql."<br>"; exit;
sql_query($sql);

$recv_mb_id   = "admin";
$row = sql_fetch ( "SELECT * FROM ".$g5['member_table']." WHERE mb_id='".$recv_mb_id."' " );

$recv_number = str_replace("-","",$row['mb_hp']);
$send_number = $sms5['cf_phone'];
$cmt = "새로운 작업이 등록되었습니다. -올보이스-";
$sms_content = iconv_euckr( $cmt );

$biz_sql = "INSERT INTO BIZ_MSG (MSG_TYPE, CMID, REQUEST_TIME, SEND_TIME, DEST_PHONE, SEND_PHONE,  MSG_BODY, TEMPLATE_CODE, SENDER_KEY, NATION_CODE, ATTACHED_FILE, RE_TYPE, RE_BODY) VALUES (6, '".date("YmdHis", time()+1)."', NOW(), NOW(), '".$recv_number."', '".$send_number."', '".$cmt."', 'bizp_2019082914483016788512544', '".SENDER_KEY."', '82', 'kakao_button.json', 'SMS', '".$cmt."')";
//echo $biz_sql;
sql_query( $biz_sql );

// admin 계정 연락처만 보낼수 있어서 임시로 작업
$recv_number2 = "01024452055";
$biz_sql2 = "INSERT INTO BIZ_MSG (MSG_TYPE, CMID, REQUEST_TIME, SEND_TIME, DEST_PHONE, SEND_PHONE,  MSG_BODY, TEMPLATE_CODE, SENDER_KEY, NATION_CODE, ATTACHED_FILE, RE_TYPE, RE_BODY) VALUES (6, '".date("YmdHis", time()+2)."', NOW(), NOW(), '".$recv_number2."', '".$send_number."', '".$cmt."', 'bizp_2019082914483016788512544', '".SENDER_KEY."', '82', 'kakao_button.json', 'SMS', '".$cmt."')";
sql_query( $biz_sql2 );


include_once(G5_LIB_PATH.'/icode.sms.lib.php');
include_once(G5_PLUGIN_PATH.'/sms5/sms5.lib.php');

$SMS = new SMS; // SMS 연결
$SMS->SMS_con($config['cf_icode_server_ip'], $config['cf_icode_id'], $config['cf_icode_pw'], $config['cf_icode_server_port']);

//echo " $recv_number, $send_number, ".$config['cf_icode_id'].", $sms_content ";
$SMS->Add($recv_number, $send_number, $config['cf_icode_id'], $sms_content, "");

//$SMS->Send();
$result = $SMS->Send();

if ($result) //SMS 서버에 접속했습니다.
{
	$row1 = sql_fetch("select max(wr_no) as wr_no from {$g5['sms5_write_table']}");
	if ($row1)
		$wr_no = $row1['wr_no'] + 1;
	else
		$wr_no = 1;

	sql_query("insert into {$g5['sms5_write_table']} set wr_no='$wr_no', wr_renum=0, wr_reply='$send_number', wr_message='$cmt', wr_booking='0000-00-00 00:00:00', wr_total='1', wr_datetime='".G5_TIME_YMDHIS."'");

	$wr_success = 0;
	$wr_failure = 0;
	$count      = 0;
//print_r($SMS->Result);
	foreach ($SMS->Result as $res)
	{
		list($phone, $code) = explode(":", $res);
//print_r($code);
		if (substr($code,0,5) == "Error")
		{
			$hs_code = substr($code,6,2);

			switch ($hs_code) {
				case '02':	 // "02:형식오류"
					$hs_memo = "형식이 잘못되어 전송이 실패하였습니다.";
					break;
				case '23':	 // "23:인증실패,데이터오류,전송날짜오류"
					$hs_memo = "데이터를 다시 확인해 주시기바랍니다.";
					break;
				case '97':	 // "97:잔여코인부족"
					$hs_memo = "잔여코인이 부족합니다.";
					break;
				case '98':	 // "98:사용기간만료"
					$hs_memo = "사용기간이 만료되었습니다.";
					break;
				case '99':	 // "99:인증실패"
					$hs_memo = "인증 받지 못하였습니다. 계정을 다시 확인해 주세요.";
					break;
				default:	 // "미 확인 오류"
					$hs_memo = "알 수 없는 오류로 전송이 실패하였습니다.";
					break;
			}
			$wr_failure++;
			$hs_flag = 0;
		}
		else
		{
			$hs_code = $code;
			$hs_memo = get_hp($phone, 1)."로 전송했습니다.";//print_r($hs_memo);
			$wr_success++;
			$hs_flag = 1;
		}

		//$row = array_shift($list);
		//$row['bk_hp'] = get_hp($row['bk_hp'], 1);

		$log = array_shift($SMS->Log);
		$log = @iconv('euc-kr', 'utf-8', $log);
//echo "insert into {$g5['sms5_history_table']} set wr_no='$wr_no', wr_renum=0, bg_no='0', mb_id='{$row['mb_id']}', bk_no='0', hs_name='', hs_hp='{$recv_number}', hs_datetime='".G5_TIME_YMDHIS."', hs_flag='$hs_flag', hs_code='$hs_code', hs_memo='".addslashes($hs_memo)."', hs_log='".addslashes($log)."'";
		sql_query("insert into {$g5['sms5_history_table']} set wr_no='$wr_no', wr_renum=0, bg_no='0', mb_id='{$row['mb_id']}', bk_no='0', hs_name='', hs_hp='{$recv_number}', hs_datetime='".G5_TIME_YMDHIS."', hs_flag='$hs_flag', hs_code='$hs_code', hs_memo='".addslashes($hs_memo)."', hs_log='".addslashes($log)."'", false);
	}
	$SMS->Init(); // 보관하고 있던 결과값을 지웁니다.

	sql_query("update {$g5['sms5_write_table']} set wr_success='$wr_success', wr_failure='$wr_failure', wr_memo='$str_serialize' where wr_no='$wr_no' and wr_renum=0");
}

alert('작업등록신청이 완료되었습니다. 검토후 바로 작업이 등록됩니다.', './voiceProjectApply.php');
//goto_url('./voiceProjectApply.php', false);
?>