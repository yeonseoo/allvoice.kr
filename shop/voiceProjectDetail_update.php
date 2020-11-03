<?php
include_once('./_common.php');
include_once(G5_LIB_PATH."/register.lib.php");
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

include_once(G5_LIB_PATH.'/icode.sms.lib.php');
include_once(G5_PLUGIN_PATH.'/sms5/sms5.lib.php');
include_once(ALLV_UTIL_PATH . '/BizMsgKakao.php');

if ( $_REQUEST['mode'] == "cancel" ) {
	/*
	$ct_history="\n$ct_status|{$member['mb_id']}|$now|$REMOTE_ADDR";
	cart ==> ct_status='취소', ct_history='취소|admin|2019-04-05 11:53:51|175.114.22.216'

	$mod_history .= G5_TIME_YMDHIS.' '.$member['mb_id'].' 주문'.$_POST['ct_status'].' 처리'.$pg_cancel_log."\n";
	order ==> od_cancel_price=500000, od_misu='0', od_mod_history='2019-04-05 11:53:51 admin 주문취소 처리', od_status='취소', od_tax_mny=0, od_vat_mny=0, od_free_mny=0
	*/
	$upload_dir = G5_DATA_PATH.'/order/';
	if( !is_dir($upload_dir) ){
		@mkdir($upload_dir, G5_DIR_PERMISSION);
		@chmod($upload_dir, G5_DIR_PERMISSION);
	}

	$qry = "SELECT * FROM ".$g5['g5_shop_cart_table']." WHERE it_id='".$_REQUEST['it_id']."' AND mb_id='".$member['mb_id']."' AND ct_select='1' AND ct_status<>'취소' ";
	$info_dt = sql_fetch($qry);

	$upload_dir .= $info_dt['od_id'];
	$dest_path = $upload_dir.'/'.$info_dt['ct_option'];
	@unlink($dest_path);

	$sql = "UPDATE ".$g5['g5_shop_cart_table']." SET ct_status='취소', ct_history='\n지원취소|".$member['mb_id']."|".G5_TIME_YMDHIS."|".$_SERVER['REMOTE_ADDR']."' WHERE ct_id='".$info_dt['ct_id']."' ";
	$result = sql_query($sql, false);

	$sql = "UPDATE ".$g5['g5_shop_order_table']." SET od_cancel_price=".$info_dt['ct_price'].", od_misu='0', od_mod_history='".G5_TIME_YMDHIS." ".$member['mb_id']." 지원취소 처리', od_status='취소', od_tax_mny=0, od_vat_mny=0, od_free_mny=0 WHERE od_id='".$info_dt['od_id']."' ";
	$result = sql_query($sql, false);
}
else if ( $_REQUEST['mode'] == "confirm" ) {

	$sql = "UPDATE ".$g5['g5_shop_item_table']." SET it_origin='".$_REQUEST['origin']."', it_gubun='2' WHERE it_id='".$_REQUEST['it_id']."' ";
	$result = sql_query($sql, false);

	$sql = "UPDATE ".$g5['g5_shop_cart_table']." SET ct_status='채택완료' WHERE od_id='".$_REQUEST['od_id']."' AND mb_id='".$_REQUEST['origin']."' ";
	$result = sql_query($sql, false);

	$sql = "UPDATE ".$g5['g5_shop_order_table']." SET od_status='채택완료', od_gubun='2' WHERE od_id='".$_REQUEST['od_id']."' ";
	$result = sql_query($sql, false);

	$recv_mb_id   = $_REQUEST['origin'];
	$row = sql_fetch ( "SELECT * FROM ".$g5['member_table']." WHERE mb_id='".$recv_mb_id."' " );

	$recv_number = str_replace("-","",$row['mb_hp']);
	$send_number = $sms5['cf_phone'];
	$cmt = "지원하신 작업에 채택되셨습니다. 결제가 완료되면 작업을 진행해주세요. -올보이스-";
	$sms_content = iconv_euckr( $cmt );

	// $biz_sql = "INSERT INTO BIZ_MSG (MSG_TYPE, CMID, REQUEST_TIME, SEND_TIME, DEST_PHONE, SEND_PHONE,  MSG_BODY, TEMPLATE_CODE, SENDER_KEY, NATION_CODE, ATTACHED_FILE, RE_TYPE, RE_BODY) VALUES (6, '".date("YmdHis")."', NOW(), NOW(), '".$recv_number."', '".$send_number."', '".$cmt."', 'bizp_2019082914463922317016526', '".SENDER_KEY."', '82', 'kakao_button.json', 'SMS', '".$cmt."')";
	//echo $biz_sql;
	// sql_query( $biz_sql );

    // 25	bizp_2020041316362903031831915	작업의뢰>채택시>To.성우(200413 수정)
    $bizKakao = new BizMsgKakao;
    $bizKakao->insertBizMsgToDB($recv_number, $send_number, biz_msg_type::biz_msg_code_4);

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

	alert('성우 채택이 완료되었습니다. 마이페이지에서 결제를 진행해주세요.','./voiceProject.php?page='.$page.'&ca_id='.$ca_id.'&orderby='.$orderby);
	exit;
}
else {
	$query = "SELECT od_id FROM ".$g5['g5_shop_cart_table']." WHERE it_id = '".$_REQUEST['it_id']."' AND mb_id = '".$member['mb_id']."'";
	$cnt_dt = sql_fetch($query);
	if ( $cnt_dt['od_id'] ) {
		$od_id = $cnt_dt['od_id'];
	}
	else {
		$od_id = get_uniqid();
	}
	$od_pwd = $member['mb_id'];

	$qry = "SELECT a.*, b.ca_name, c.mb_name FROM ".$g5['g5_shop_item_table']." AS a JOIN ".$g5['g5_shop_category_table']." AS b ON a.ca_id=b.ca_id JOIN ".$g5['member_table']." AS c ON a.it_maker=c.mb_id WHERE a.it_id='".$_REQUEST['it_id']."' ";
	$view_dt = sql_fetch($qry);

	$image_regex = "/(\.(".$voice_file_str."))$/i";
	$upload_dir = G5_DATA_PATH.'/order/';
	if( !is_dir($upload_dir) ){
		@mkdir($upload_dir, G5_DIR_PERMISSION);
		@chmod($upload_dir, G5_DIR_PERMISSION);
	}
	$upload_dir .= $od_id;
	$sql_common = "";

	// 샘플음성 업로드                it_7                = '$it_7',
	if (isset($_FILES['ct_option']) && is_uploaded_file($_FILES['ct_option']['tmp_name'])) {
		if (!preg_match($image_regex, $_FILES['ct_option']['name'])) {
			alert($_FILES['ct_option']['name'] . '은(는) 음성 파일이 아닙니다.');
		}
	//echo "test1";
		if (preg_match($image_regex, $_FILES['ct_option']['name'])) {
			@mkdir($upload_dir, G5_DIR_PERMISSION);
			@chmod($upload_dir, G5_DIR_PERMISSION);

			// 회원 이미지 삭제
			//if ($_POST['del_file'])
			//	@unlink($upload_dir.'/'.$_POST['del_file']);

			$ext = end(explode('.', $_FILES['ct_option']['name'])); 
			
			$dest_file = time().'_'.$od_id.'.'.$ext;
			$dest_path = $upload_dir.'/'.$dest_file;
			
			move_uploaded_file($_FILES['ct_option']['tmp_name'], $dest_path);
			chmod($dest_path, G5_FILE_PERMISSION);

			$sql_common .= " ,ct_option = '".$dest_file."' ";
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

	if ( $cnt_dt['od_id'] ) {
		$sql = " UPDATE {$g5['g5_shop_cart_table']}
					SET ct_qty            = '1',
						ct_status         = '지원완료',
						ct_price          = '".$view_dt['it_price']."',
						it_name           = '".$view_dt['it_name']."',
						ct_time           = '".G5_TIME_YMDHIS."',
						ct_ip             = '".$_SERVER['REMOTE_ADDR']."',
						ct_direct         = '1',
						ct_select         = '1',
						ct_select_time    = '".G5_TIME_YMDHIS."'
						".$sql_common."
						WHERE it_id = '".$_REQUEST['it_id']."' AND mb_id = '".$member['mb_id']."' AND od_id = '".$od_id."' ";
	}
	else {
		$sql = " insert {$g5['g5_shop_cart_table']}
					set it_id             = '".$_REQUEST['it_id']."',
						od_id             = '".$od_id."',
						mb_id             = '".$member['mb_id']."',
						ct_qty            = '1',
						ct_status         = '지원완료',
						ct_price          = '".$view_dt['it_price']."',
						it_name           = '".$view_dt['it_name']."',
						ct_time           = '".G5_TIME_YMDHIS."',
						ct_ip             = '".$_SERVER['REMOTE_ADDR']."',
						ct_direct         = '1',
						ct_select         = '1',
						ct_select_time    = '".G5_TIME_YMDHIS."'
						".$sql_common."
						";
	}
	$result = sql_query($sql, false);

	if ($is_member)
		$od_pwd = $member['mb_password'];
	else
		$od_pwd = get_encrypt_string($_POST['od_pwd']);

	$od_pg = $default['de_pg_service'];
	if($od_settle_case == 'KAKAOPAY')
		$od_pg = 'KAKAOPAY';

	$od_escrow = 0;
	if($escw_yn == 'Y')
		$od_escrow = 1;

	// 복합과세 금액
	$od_tax_mny = round($view_dt['it_price'] / 1.1);
	$od_vat_mny = $view_dt['it_price'] - $od_tax_mny;
	$od_free_mny = 0;
	/*
	if($default['de_tax_flag_use']) {
		$od_tax_mny = (int)$_POST['comm_tax_mny'];
		$od_vat_mny = (int)$_POST['comm_vat_mny'];
		$od_free_mny = (int)$_POST['comm_free_mny'];
	}
	*/
	$od_tax_flag      = $default['de_tax_flag_use'];

	// 주문서에 입력
	if ( $cnt_dt['od_id'] ) {
		$sql = " UPDATE {$g5['g5_shop_order_table']}
					SET od_pwd            = '".$od_pwd."',
						od_name           = '".$member['mb_name']."',
						od_email          = '".$member['mb_email']."',
						od_tel            = '".$member['mb_hp']."',
						od_hp             = '".$member['mb_hp']."',
						od_zip1           = '".$member['mb_zip1']."',
						od_zip2           = '".$member['mb_zip2']."',
						od_addr1          = '".$member['mb_addr1']."',
						od_addr2          = '".$member['mb_addr2']."',
						od_addr3          = '".$member['mb_addr3']."',
						od_addr_jibeon    = '".$member['mb_addr_jibeon']."',
						od_b_name         = '".$member['mb_name']."',
						od_b_tel          = '".$member['mb_hp']."',
						od_b_hp           = '".$member['mb_hp']."',
						od_b_zip1         = '".$member['mb_zip1']."',
						od_b_zip2         = '".$member['mb_zip2']."',
						od_b_addr1        = '".$member['mb_addr1']."',
						od_b_addr2        = '".$member['mb_addr2']."',
						od_b_addr3        = '".$member['mb_addr3']."',
						od_b_addr_jibeon  = '".$member['mb_addr_jibeon']."',
						od_deposit_name   = '".$member['mb_name']."',
						od_memo           = '".$od_memo."',
						od_cart_count     = '1',
						od_cart_price     = '".$view_dt['it_price']."',
						od_origin_price   = '".$view_dt['it_price']."',
						od_cart_coupon    = '0',
						od_send_cost      = '0',
						od_send_coupon    = '0',
						od_send_cost2     = '0',
						od_coupon         = '0',
						od_receipt_price  = '0',
						od_receipt_point  = '0',
						od_misu           = '".$view_dt['it_price']."',
						od_pg             = '".$od_pg."',
						od_escrow         = '".$od_escrow."',
						od_tax_flag       = '".$od_tax_flag."',
						od_tax_mny        = '".$od_tax_mny."',
						od_vat_mny        = '".$od_vat_mny."',
						od_free_mny       = '".$od_free_mny."',
						od_status         = '지원완료',
						od_shop_memo      = '',
						od_time           = '".G5_TIME_YMDHIS."',
						od_ip             = '".$_SERVER['REMOTE_ADDR']."',
						od_test           = '".$default['de_card_test']."'
						WHERE mb_id = '".$member['mb_id']."' AND od_id = '".$od_id."'";
	}
	else {
		$sql = " insert {$g5['g5_shop_order_table']}
					set od_id             = '".$od_id."',
						mb_id             = '".$member['mb_id']."',
						od_pwd            = '".$od_pwd."',
						od_name           = '".$member['mb_name']."',
						od_email          = '".$member['mb_email']."',
						od_tel            = '".$member['mb_hp']."',
						od_hp             = '".$member['mb_hp']."',
						od_zip1           = '".$member['mb_zip1']."',
						od_zip2           = '".$member['mb_zip2']."',
						od_addr1          = '".$member['mb_addr1']."',
						od_addr2          = '".$member['mb_addr2']."',
						od_addr3          = '".$member['mb_addr3']."',
						od_addr_jibeon    = '".$member['mb_addr_jibeon']."',
						od_b_name         = '".$member['mb_name']."',
						od_b_tel          = '".$member['mb_hp']."',
						od_b_hp           = '".$member['mb_hp']."',
						od_b_zip1         = '".$member['mb_zip1']."',
						od_b_zip2         = '".$member['mb_zip2']."',
						od_b_addr1        = '".$member['mb_addr1']."',
						od_b_addr2        = '".$member['mb_addr2']."',
						od_b_addr3        = '".$member['mb_addr3']."',
						od_b_addr_jibeon  = '".$member['mb_addr_jibeon']."',
						od_deposit_name   = '".$member['mb_name']."',
						od_memo           = '".$od_memo."',
						od_cart_count     = '1',
						od_cart_price     = '".$view_dt['it_price']."',
						od_origin_price   = '".$view_dt['it_price']."',
						od_cart_coupon    = '0',
						od_send_cost      = '0',
						od_send_coupon    = '0',
						od_send_cost2     = '0',
						od_coupon         = '0',
						od_receipt_price  = '0',
						od_receipt_point  = '0',
						od_misu           = '".$view_dt['it_price']."',
						od_pg             = '".$od_pg."',
						od_escrow         = '".$od_escrow."',
						od_tax_flag       = '".$od_tax_flag."',
						od_tax_mny        = '".$od_tax_mny."',
						od_vat_mny        = '".$od_vat_mny."',
						od_free_mny       = '".$od_free_mny."',
						od_status         = '지원완료',
						od_shop_memo      = '',
						od_time           = '".G5_TIME_YMDHIS."',
						od_ip             = '".$_SERVER['REMOTE_ADDR']."',
						od_test           = '".$default['de_card_test']."'
						";
	}
	$result = sql_query($sql, false);

	$recv_mb_id   = $view_dt['it_maker'];
	$row = sql_fetch ( "SELECT * FROM ".$g5['member_table']." WHERE mb_id='".$recv_mb_id."' " );

	$recv_number = str_replace("-","",$row['mb_hp']);
	$send_number = $sms5['cf_phone'];
	$cmt = "고객님이 등록하신 작업에 성우가 지원하였습니다. -올보이스-";
	$sms_content = iconv_euckr( $cmt );

	// $biz_sql = "INSERT INTO BIZ_MSG (MSG _TYPE, CMID, REQUEST_TIME, SEND_TIME, DEST_PHONE, SEND_PHONE,  MSG_BODY, TEMPLATE_CODE, SENDER_KEY, NATION_CODE, ATTACHED_FILE, RE_TYPE, RE_BODY) VALUES (6, '".date("YmdHis")."', NOW(), NOW(), '".$recv_number."', '".$send_number."', '".$cmt."', 'bizp_2019082914471716788078543', '".SENDER_KEY."', '82', 'kakao_button.json', 'SMS', '".$cmt."')";
	//echo $biz_sql;
	// sql_query( $biz_sql );

    // 26	bizp_2020041316380903031864916	작업의뢰>성우지원시>To.일반(200413 수정)
    $bizKakao = new BizMsgKakao;
    $bizKakao->insertBizMsgToDB($recv_number, $send_number, biz_msg_type::biz_msg_code_3);

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

	alert('지원이 완료되었습니다.', './voiceProjectDetail.php?it_id='.$it_id.'&ca_id='.$ca_id.'&orderby='.$orderby);
	exit;
}
goto_url('./voiceProjectDetail.php?it_id='.$it_id.'&ca_id='.$ca_id.'&orderby='.$orderby, false);
?>