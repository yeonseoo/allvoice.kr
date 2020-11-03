<?php
include_once('./_common.php');
include_once(G5_LIB_PATH."/register.lib.php");
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
include_once(G5_LIB_PATH.'/mailer.lib.php');

include_once(G5_LIB_PATH.'/icode.sms.lib.php');
include_once(G5_PLUGIN_PATH.'/sms5/sms5.lib.php');
include_once(ALLV_UTIL_PATH . '/BizMsgKakao.php');

if ($is_guest) {
    alert('회원만 이용하실 수 있습니다.');
	exit;
}

//echo "test ==> ".$_REQUEST['mode'];exit;
if ( $_REQUEST['mode'] == "cancel" ) {

	$upload_dir = G5_DATA_PATH.'/order/';
	if( !is_dir($upload_dir) ){
		@mkdir($upload_dir, G5_DIR_PERMISSION);
		@chmod($upload_dir, G5_DIR_PERMISSION);
	}

	$qry = "SELECT * FROM ".$g5['g5_shop_cart_table']." WHERE ct_id='".$_REQUEST['ct_id']."' ";
	$info_dt = sql_fetch($qry);

	$upload_dir .= $info_dt['od_id'];
	$dest_path = $upload_dir.'/'.$info_dt['ct_option'];
	@unlink($dest_path);

	$sql = "UPDATE ".$g5['g5_shop_cart_table']." SET ct_status='취소', ct_history='\n의뢰취소|".$member['mb_id']."|".G5_TIME_YMDHIS."|".$_SERVER['REMOTE_ADDR']."' WHERE ct_id='".$info_dt['ct_id']."' ";
	$result = sql_query($sql, false);

	$sql = "UPDATE ".$g5['g5_shop_order_table']." SET od_cancel_price=".$info_dt['ct_price'].", od_misu='0', od_mod_history='".G5_TIME_YMDHIS." ".$member['mb_id']." 의뢰취소 처리', od_status='취소', od_tax_mny=0, od_vat_mny=0, od_free_mny=0 WHERE od_id='".$info_dt['od_id']."' ";
	$result = sql_query($sql, false);

	$row = sql_fetch ( "SELECT b.* FROM ".$g5['g5_shop_cart_table']." AS a JOIN ".$g5['g5_shop_item_table']." AS b ON a.it_id=b.it_id WHERE a.ct_id='".$_REQUEST['ct_id']."' " );
	$recv_mb_id   = $row['it_origin'];
	$row = sql_fetch ( "SELECT * FROM ".$g5['member_table']." WHERE mb_id='".$recv_mb_id."' " );

	$recv_number = str_replace("-","",$row['mb_hp']);
	$send_number = $sms5['cf_phone'];
	$cmt = "고객님이 작업 의뢰를 취소하셨습니다. -올보이스-";
	$sms_content = iconv_euckr( $cmt );

	// 템플릿 변경 2020.04.24
	//$biz_sql = "INSERT INTO BIZ_MSG (MSG_TYPE, CMID, REQUEST_TIME, SEND_TIME, DEST_PHONE, SEND_PHONE,  MSG_BODY, TEMPLATE_CODE, SENDER_KEY, NATION_CODE, ATTACHED_FILE, RE_TYPE, RE_BODY) VALUES (6, '".date("YmdHis")."', NOW(), NOW(), '".$recv_number."', '".$send_number."', '".$cmt."', 'bizp_2019091010371722317145059', '".SENDER_KEY."', '82', 'kakao_button.json', 'SMS', '".$cmt."')";
	//echo $biz_sql;
	//sql_query( $biz_sql );

    // 27	bizp_2020041316391903031588917	의뢰취소>To.성우(200413 수정)
    $bizKakao = new BizMsgKakao;
    $bizKakao->insertBizMsgToDB($recv_number, $send_number, biz_msg_type::biz_msg_code_2);

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

}
else if ( $_REQUEST['mode'] == "complete" ) {
	
	$sql = "UPDATE ".$g5['g5_shop_cart_table']." SET ct_status='작업완료' WHERE ct_id='".$_REQUEST['ct_id']."' ";
	$result = sql_query($sql, false);

	$sql = "UPDATE ".$g5['g5_shop_order_table']." SET od_status='작업완료' WHERE od_id='".$_REQUEST['od_id']."' ";
	$result = sql_query($sql, false);

	$row = sql_fetch ( "SELECT b.* FROM ".$g5['g5_shop_cart_table']." AS a JOIN ".$g5['g5_shop_item_table']." AS b ON a.it_id=b.it_id WHERE a.ct_id='".$_REQUEST['ct_id']."' " );
	$recv_mb_id   = $row['it_origin'];
	$row = sql_fetch ( "SELECT * FROM ".$g5['member_table']." WHERE mb_id='".$recv_mb_id."' " );

	$recv_number = str_replace("-","",$row['mb_hp']);
	$send_number = $sms5['cf_phone'];
	$cmt = "고객님이 작업완료를 인증하셨습니다. -올보이스-";
	$sms_content = iconv_euckr( $cmt );

	// $biz_sql = "INSERT INTO BIZ_MSG (MSG_TYPE, CMID, REQUEST_TIME, SEND_TIME, DEST_PHONE, SEND_PHONE,  MSG_BODY, TEMPLATE_CODE, SENDER_KEY, NATION_CODE, ATTACHED_FILE, RE_TYPE, RE_BODY) VALUES (6, '".date("YmdHis")."', NOW(), NOW(), '".$recv_number."', '".$send_number."', '".$cmt."', 'bizp_2019082914440222317867525', '".SENDER_KEY."', '82', 'kakao_button.json', 'SMS', '".$cmt."')";
	// echo $biz_sql;
	// sql_query( $biz_sql );

    // 24	bizp_2020041316342403031107914	합의주문>작업완료>To.성우(200413 수정)
    $bizKakao = new BizMsgKakao;
    $bizKakao->insertBizMsgToDB($recv_number, $send_number, biz_msg_type::biz_msg_code_5);

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

}
else if ( $_REQUEST['mode'] == "voice_upload" ) {
	//echo "test";exit;
	if ( count( $_FILES['voice'] ) > 0 ) {
	
		$image_regex = "/(\.(".$voice_file_str."))$/i";
		$upload_dir = G5_DATA_PATH.'/order/';
		if( !is_dir($upload_dir) ){
			@mkdir($upload_dir, G5_DIR_PERMISSION);
			@chmod($upload_dir, G5_DIR_PERMISSION);
		}
		$upload_dir .= $_REQUEST['od_id'];
//print_R($_FILES);exit;
		for ( $i = 0; $i < count( $_FILES['voice']['name'] ); $i++ ) {
			if (isset($_FILES['voice']) && is_uploaded_file($_FILES['voice']['tmp_name'][$i])) {
				if (!preg_match($image_regex, $_FILES['voice']['name'][$i])) {
					alert($_FILES['voice']['name'][$i] . '은(는) 음성 파일이 아닙니다.');
				}
			//echo "test1";
				if (preg_match($image_regex, $_FILES['voice']['name'][$i])) {
					@mkdir($upload_dir, G5_DIR_PERMISSION);
					@chmod($upload_dir, G5_DIR_PERMISSION);

					// 회원 이미지 삭제
					//if ($_POST['del_file'][$i])
					//	@unlink($upload_dir.'/'.$_POST['del_file'][$i]);

					$ext = end(explode('.', $_FILES['voice']['name'][$i])); 
					
					$dest_file = time().'_'.$od_id.'_'.$i.'.'.$ext;
					$dest_path = $upload_dir.'/'.$dest_file;
					
					move_uploaded_file($_FILES['voice']['tmp_name'][$i], $dest_path);
					chmod($dest_path, G5_FILE_PERMISSION);

					$sql_common = " ,ov_voice = '".$dest_file."' ,ov_voice_name = '".$_FILES['voice']['name'][$i]."' ";
				}

				$sql = " INSERT INTO {$g5['g5_shop_order_voice_table']}
							set od_id = '".$_REQUEST['od_id']."'
								{$sql_common}
								,ov_time=now()
				";
				sql_query($sql);
			}
		}
	}

	$row = sql_fetch ( "SELECT b.* FROM ".$g5['g5_shop_cart_table']." AS a JOIN ".$g5['g5_shop_item_table']." AS b ON a.it_id=b.it_id WHERE a.ct_id='".$_REQUEST['ct_id']."' " );
	$recv_mb_id   = $row['it_maker'];
	$row = sql_fetch ( "SELECT * FROM ".$g5['member_table']." WHERE mb_id='".$recv_mb_id."' " );

	$recv_number = str_replace("-","",$row['mb_hp']);
	$send_number = $sms5['cf_phone'];
	$cmt = "작업물 도착. 마이페이지에서 확인 후 작업완료 인증을 해주세요. -올보이스-";
	$sms_content = iconv_euckr( $cmt );

	//$biz_sql = "INSERT INTO BIZ_MSG (MSG_TYPE, CMID, REQUEST_TIME, SEND_TIME, DEST_PHONE, SEND_PHONE,  MSG_BODY, TEMPLATE_CODE, SENDER_KEY, NATION_CODE, ATTACHED_FILE, RE_TYPE, RE_BODY) VALUES (6, '".date("YmdHis")."', NOW(), NOW(), '".$recv_number."', '".$send_number."', '".$cmt."', 'bizp_2019082914433522317196524', '".SENDER_KEY."', '82', 'kakao_button.json', 'SMS', '".$cmt."')";
	//echo $biz_sql;
	//sql_query( $biz_sql );
    // 23	bizp_2020041316334303031166913	합의주문>작업물도착>To.일반(200413 수정)
    $bizKakao = new BizMsgKakao;
    $bizKakao->insertBizMsgToDB($recv_number, $send_number, biz_msg_type::biz_msg_code_6);


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

	alert('고객에게 파일이 전달되었습니다.', G5_SHOP_URL.'/voiceMypageOrderDetail.php?it_id='.$_REQUEST['it_id'].'&it_gubun='.$_REQUEST['it_gubun'].'&sch='.$_REQUEST['sch'].'&sch_val='.$_REQUEST['sch_val'].'&sod_status='.$_REQUEST['sod_status'].'&page='.$_REQUEST['page']);
	exit;
}
else if ( $_REQUEST['mode'] == "pay" ) {

	$_REQUEST['it_id'] = $it_id;
	$_REQUEST['it_gubun'] = $it_gubun;
	$_REQUEST['sch'] = $sch;
	$_REQUEST['sch_val'] = $sch_val;
	$_REQUEST['od_status'] = $od_status;
	$_REQUEST['page'] = $page;
	//이니시스 lpay 요청으로 왔다면 $default['de_pg_service'] 값을 이니시스로 변경합니다.
	if( $od_settle_case == 'lpay' ){
		$default['de_pg_service'] = 'inicis';
	}
//print_r($default);exit;
	if(($od_settle_case != '무통장' && $od_settle_case != 'KAKAOPAY') && $default['de_pg_service'] == 'lg' && !$_POST['LGD_PAYKEY'])
		alert('결제등록 요청 후 주문해 주십시오.');

	$sql = "SELECT * FROM ".$g5['g5_shop_order_table']." WHERE od_id='".$_REQUEST['od_id']."' ";
	$od_dt = sql_fetch($sql);

	$i_price     = (int)$od_dt['od_cart_price'];
	$i_send_cost  = (int)$od_dt['od_send_cost'];
	$i_send_cost2  = (int)$od_dt['od_send_cost2'];
	$i_send_coupon  = (int)$od_dt['od_send_coupon'];
	$i_temp_point = 0;

	$tot_ct_price = $od_dt['od_cart_price'];
	$cart_count = 1;
	$tot_od_price = $tot_ct_price;
	$send_cost = 0;
	$send_cost2 = 0;
	$tot_sc_cp_price = 0;
	$od_temp_point = 0;

	$i_price = $i_price + $i_send_cost + $i_send_cost2 - $i_temp_point - $i_send_coupon;
	$order_price = $tot_od_price + $send_cost + $send_cost2 - $tot_sc_cp_price - $od_temp_point;// + ( $tot_ct_price * 0.1 );
	//if ($od_settle_case == "신용카드" || $_REQUEST["tax_cash_select"] != "신청안함") {
	//if ($_REQUEST["tax_cash_select"] != "신청안함") {
		$order_price = $order_price + ( $tot_ct_price * 0.1 );
		$i_price = $i_price + ( $i_price * 0.1 );
		
		$order_price = ceil($order_price);
		$i_price = ceil($i_price);
	//}

	$_shop_path = ( G5_IS_MOBILE ) ? G5_MSHOP_PATH : G5_SHOP_PATH;
	$_shop_file = ( G5_IS_MOBILE ) ? "pay_result.php" : "inistdpay_result.php";

	$od_status = '거래합의중';
	$od_tno    = '';
	if ($od_settle_case == "무통장")
	{
		$od_receipt_point   = $i_temp_point;
		$od_receipt_price   = 0;
	
		$od_misu            = $i_price - $od_receipt_price;
		if($od_misu == 0) {
			$od_status      = '작업진행중';
			$od_receipt_time = G5_TIME_YMDHIS;
		}
	}
	else if ($od_settle_case == "계좌이체")
	{
		switch($default['de_pg_service']) {
			case 'lg':
				include G5_SHOP_PATH.'/lg/xpay_result.php';
				break;
			case 'inicis':
				include $_shop_path.'/inicis/'.$_shop_file.'';
				break;
			default:
				include $_shop_path.'/kcp/pp_ax_hub.php';
				$bank_name  = iconv("cp949", "utf-8", $bank_name);
				break;
		}

		$od_tno             = $tno;
		$od_receipt_price   = $amount;
		$od_receipt_point   = $i_temp_point;
		$od_receipt_time    = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3 \\4:\\5:\\6", $app_time);
		$od_bank_account    = $od_settle_case;
		$od_deposit_name    = $od_name;
		$od_bank_account    = $bank_name;
		$pg_price           = $amount;
		$od_misu            = $i_price - $od_receipt_price;
		if($od_misu == 0)
			$od_status      = '작업진행중';
	}
	else if ($od_settle_case == "가상계좌")
	{
		switch($default['de_pg_service']) {
			case 'lg':
				include G5_SHOP_PATH.'/lg/xpay_result.php';
				break;
			case 'inicis':
				include $_shop_path.'/inicis/'.$_shop_file.'';
				$od_app_no = $app_no;
				break;
			default:
				include $_shop_path.'/kcp/pp_ax_hub.php';
				$bankname   = iconv("cp949", "utf-8", $bankname);
				$depositor  = iconv("cp949", "utf-8", $depositor);
				break;
		}

		$od_receipt_point   = $i_temp_point;
		$od_tno             = $tno;
		$od_receipt_price   = 0;
		$od_bank_account    = $bankname.' '.$account;
		$od_deposit_name    = $depositor;
		$pg_price           = $amount;
		$od_misu            = $i_price - $od_receipt_price;
	}
	else if ($od_settle_case == "휴대폰")
	{
		switch($default['de_pg_service']) {
			case 'lg':
				include G5_SHOP_PATH.'/lg/xpay_result.php';
				break;
			case 'inicis':
				include $_shop_path.'/inicis/'.$_shop_file.'';
				break;
			default:
				include $_shop_path.'/kcp/pp_ax_hub.php';
				break;
		}

		$od_tno             = $tno;
		$od_receipt_price   = $amount;
		$od_receipt_point   = $i_temp_point;
		$od_receipt_time    = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3 \\4:\\5:\\6", $app_time);
		$od_bank_account    = $commid . ($commid ? ' ' : '').$mobile_no;
		$pg_price           = $amount;
		$od_misu            = $i_price - $od_receipt_price;
		if($od_misu == 0)
			$od_status      = '작업진행중';
	}
	else if ($od_settle_case == "신용카드")
	{
		switch($default['de_pg_service']) {
			case 'lg':
				include G5_SHOP_PATH.'/lg/xpay_result.php';
				break;
			case 'inicis':
				include $_shop_path.'/inicis/'.$_shop_file.'';
				break;
			default:
				include $_shop_path.'/kcp/pp_ax_hub.php';
				$card_name  = iconv("cp949", "utf-8", $card_name);
				break;
		}

		$od_tno             = $tno;
		$od_app_no          = $app_no;
		$od_receipt_price   = $amount;
		$od_receipt_point   = $i_temp_point;
		$od_receipt_time    = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3 \\4:\\5:\\6", $app_time);
		$od_bank_account    = $card_name;
		$pg_price           = $amount;
		$od_misu            = $i_price - $od_receipt_price;
		if($od_misu == 0)
			$od_status      = '작업진행중';
	}
	else if ($od_settle_case == "간편결제" || ($od_settle_case == "lpay" && $default['de_pg_service'] === 'inicis') )
	{
		switch($default['de_pg_service']) {
			case 'lg':
				include G5_SHOP_PATH.'/lg/xpay_result.php';
				break;
			case 'inicis':
				include $_shop_path.'/inicis/'.$_shop_file.'';
				break;
			default:
				include $_shop_path.'/kcp/pp_ax_hub.php';
				$card_name  = iconv("cp949", "utf-8", $card_name);
				break;
		}

		$od_tno             = $tno;
		$od_app_no          = $app_no;
		$od_receipt_price   = $amount;
		$od_receipt_point   = $i_temp_point;
		$od_receipt_time    = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3 \\4:\\5:\\6", $app_time);
		$od_bank_account    = $card_name;
		$pg_price           = $amount;
		$od_misu            = $i_price - $od_receipt_price;
		if($od_misu == 0)
			$od_status      = '작업진행중';
	}
	else if ($od_settle_case == "KAKAOPAY")
	{
		include G5_SHOP_PATH.'/kakaopay/kakaopay_result.php';

		$od_tno             = $tno;
		$od_app_no          = $app_no;
		$od_receipt_price   = $amount;
		$od_receipt_point   = $i_temp_point;
		$od_receipt_time    = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3 \\4:\\5:\\6", $app_time);
		$od_bank_account    = $card_name;
		$pg_price           = $amount;
		$od_misu            = $i_price - $od_receipt_price;
		if($od_misu == 0)
			$od_status      = '작업진행중';
	}
	else
	{
		die("od_settle_case Error!!!");
	}

	$od_pg = $default['de_pg_service'];
	if($od_settle_case == 'KAKAOPAY')
		$od_pg = 'KAKAOPAY';

	// 주문금액과 결제금액이 일치하는지 체크
	if($tno) {
		//echo $order_price . " / ". $pg_price;
		if((int)$order_price !== (int)$pg_price) {
			$cancel_msg = '결제금액 불일치';
			switch($od_pg) {
				case 'lg':
					include G5_SHOP_PATH.'/lg/xpay_cancel.php';
					break;
				case 'inicis':
					include G5_SHOP_PATH.'/inicis/inipay_cancel.php';
					break;
				case 'KAKAOPAY':
					$_REQUEST['TID']               = $tno;
					$_REQUEST['Amt']               = $amount;
					$_REQUEST['CancelMsg']         = $cancel_msg;
					$_REQUEST['PartialCancelCode'] = 0;
					include G5_SHOP_PATH.'/kakaopay/kakaopay_cancel.php';
					break;
				default:
					include G5_SHOP_PATH.'/kcp/pp_ax_hub_cancel.php';
					break;
			}

			die("Receipt Amount Error");
		}
	}

	$sql = "UPDATE ".$g5['g5_shop_order_table']." SET 
				od_status='".$od_status."', 
				od_receipt_price  = '$od_receipt_price', 
				od_receipt_point  = '$od_receipt_point', 
				od_bank_account   = '$od_bank_account', 
				od_receipt_time   = '$od_receipt_time', 
				od_misu           = '$od_misu',
                od_pg             = '$od_pg',
                od_tno            = '$od_tno',
                od_app_no         = '$od_app_no',
                od_escrow         = '$od_escrow',
                od_tax_flag       = '$od_tax_flag',
                od_tax_mny        = '$od_tax_mny',
                od_vat_mny        = '$od_vat_mny',
                od_free_mny       = '$od_free_mny',
				od_hope_date      = '$od_hope_date',
				od_settle_case    = '$od_settle_case',
                od_test           = '{$default['de_card_test']}'
			WHERE od_id='".$_REQUEST['od_id']."' ";
	
	$result = sql_query($sql, false);

	// 주문정보 입력 오류시 결제 취소
	if(!$result) {
		if($tno) {
			$cancel_msg = '주문정보 입력 오류';
			switch($od_pg) {
				case 'lg':
					include G5_SHOP_PATH.'/lg/xpay_cancel.php';
					break;
				case 'inicis':
					include G5_SHOP_PATH.'/inicis/inipay_cancel.php';
					break;
				case 'KAKAOPAY':
					$_REQUEST['TID']               = $tno;
					$_REQUEST['Amt']               = $amount;
					$_REQUEST['CancelMsg']         = $cancel_msg;
					$_REQUEST['PartialCancelCode'] = 0;
					include G5_SHOP_PATH.'/kakaopay/kakaopay_cancel.php';
					break;
				default:
					include G5_SHOP_PATH.'/kcp/pp_ax_hub_cancel.php';
					break;
			}
		}

		// 관리자에게 오류 알림 메일발송
		$error = 'order';
		include G5_SHOP_PATH.'/ordererrormail.php';

		die('<p>고객님의 주문 정보를 처리하는 중 오류가 발생해서 주문이 완료되지 않았습니다.</p><p>'.strtoupper($od_pg).'를 이용한 전자결제(신용카드, 계좌이체, 가상계좌 등)은 자동 취소되었습니다.');
	}

	// 장바구니 상태변경
	// 신용카드로 주문하면서 신용카드 포인트 사용하지 않는다면 포인트 부여하지 않음
	$cart_status = $od_status;
	$sql_card_point = "";
	if ($od_receipt_price > 0 && !$default['de_card_point']) {
		$sql_card_point = " , ct_point = '0' ";
	}
	$sql = "update {$g5['g5_shop_cart_table']}
			   set 
				   ct_status = '$cart_status'
				   $sql_card_point
			 where ct_id = '".$_REQUEST['ct_id']."' ";
	$result = sql_query($sql, false);

	// 주문정보 입력 오류시 결제 취소
	if(!$result) {
		if($tno) {
			$cancel_msg = '주문상태 변경 오류';
			switch($od_pg) {
				case 'lg':
					include G5_SHOP_PATH.'/lg/xpay_cancel.php';
					break;
				case 'inicis':
					include G5_SHOP_PATH.'/inicis/inipay_cancel.php';
					break;
				case 'KAKAOPAY':
					$_REQUEST['TID']               = $tno;
					$_REQUEST['Amt']               = $amount;
					$_REQUEST['CancelMsg']         = $cancel_msg;
					$_REQUEST['PartialCancelCode'] = 0;
					include G5_SHOP_PATH.'/kakaopay/kakaopay_cancel.php';
					break;
				default:
					include G5_SHOP_PATH.'/kcp/pp_ax_hub_cancel.php';
					break;
			}
		}

		// 관리자에게 오류 알림 메일발송
		$error = 'status';
		include G5_SHOP_PATH.'/ordererrormail.php';

		// 주문삭제
		sql_query(" delete from {$g5['g5_shop_order_table']} where od_id = '$od_id' ");

		die('<p>고객님의 주문 정보를 처리하는 중 오류가 발생해서 주문이 완료되지 않았습니다.</p><p>'.strtoupper($od_pg).'를 이용한 전자결제(신용카드, 계좌이체, 가상계좌 등)은 자동 취소되었습니다.');
	}

	if ( $od_status == "작업진행중" ) {

		$row = sql_fetch ( "SELECT b.* FROM ".$g5['g5_shop_cart_table']." AS a JOIN ".$g5['g5_shop_item_table']." AS b ON a.it_id=b.it_id JOIN ".$g5['g5_shop_order_table']." AS c ON a.od_id=c.od_id WHERE c.od_id='".$_REQUEST['od_id']."' " );
		// 성우회원
		$recv_mb_id   = $row['it_origin'];
		$row = sql_fetch ( "SELECT * FROM ".$g5['member_table']." WHERE mb_id='".$recv_mb_id."' " );
		// 일반회원
		$recv_mb_id2   = $row['it_maker'];
		$row2 = sql_fetch ( "SELECT * FROM ".$g5['member_table']." WHERE mb_id='".$recv_mb_id2."' " );

		$recv_number = str_replace("-","",$row['mb_hp']);	// 성우회원
		$recv_number2 = str_replace("-","",$row2['mb_hp']);	// 일반회원
		$send_number = $sms5['cf_phone'];
		$cmt = "결제완료, 작업을 진행해주세요. 성우님의 안심번호를 안내하였습니다. -올보이스-";	// 성우회원에게 안내문자
		$cmt2 = "결제가 완료되어, 사이트 내에서 성우의 안심번호를 확인할 수 있습니다. -올보이스-";	// 일반회원에게 안내문자
		$sms_content = iconv_euckr( $cmt );
		$sms_content2 = iconv_euckr( $cmt2 );

		//$biz_sql = "INSERT INTO BIZ_MSG (MSG_TYPE, CMID, REQUEST_TIME, SEND_TIME, DEST_PHONE, SEND_PHONE,  MSG_BODY, TEMPLATE_CODE, SENDER_KEY, NATION_CODE, ATTACHED_FILE, RE_TYPE, RE_BODY) VALUES (6, '".date("YmdHis")."', NOW(), NOW(), '".$recv_number."', '".$send_number."', '".$cmt."', 'bizp_2019082914404422317898522', '".SENDER_KEY."', '82', 'kakao_button.json', 'SMS', '".$cmt."')";
		//echo $biz_sql;
		//sql_query( $biz_sql );

        // 20	bizp_2020041316284303031003911	결제완료>To.성우(200413 수정)
        $bizKakao = new BizMsgKakao;
        $bizKakao->insertBizMsgToDB($recv_number, $send_number, biz_msg_type::biz_msg_code_9);

        // 19	bizp_2020041316274103031088910	결제완료>To.일반(200413 수정)
        $bizKakao->insertBizMsgToDB($recv_number, $send_number, biz_msg_type::biz_msg_code_10);

		//$biz_sql2 = "INSERT INTO BIZ_MSG (MSG_TYPE, CMID, REQUEST_TIME, SEND_TIME, DEST_PHONE, SEND_PHONE,  MSG_BODY, TEMPLATE_CODE, SENDER_KEY, NATION_CODE, ATTACHED_FILE, RE_TYPE, RE_BODY) VALUES (6, '".date("YmdHis", time()+1)."', NOW(), NOW(), '".$recv_number2."', '".$send_number."', '".$cmt2."', 'bizp_2019082914395422317226521', '".SENDER_KEY."', '82', 'kakao_button.json', 'SMS', '".$cmt2."')";
		//echo $biz_sql;
		//sql_query( $biz_sql2 );

		$SMS = new SMS; // SMS 연결
		$SMS->SMS_con($config['cf_icode_server_ip'], $config['cf_icode_id'], $config['cf_icode_pw'], $config['cf_icode_server_port']);

		//echo " $recv_number, $send_number, ".$config['cf_icode_id'].", $sms_content ";
		/** 성우회원에게 문자 **/
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
		/** 성우회원에게 문자 **/

		/** 일반회원에게 문자 **/
		$SMS->Add($recv_number2, $send_number, $config['cf_icode_id'], $sms_content2, "");

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
				sql_query("insert into {$g5['sms5_history_table']} set wr_no='$wr_no', wr_renum=0, bg_no='0', mb_id='{$row['mb_id']}', bk_no='0', hs_name='', hs_hp='{$recv_number2}', hs_datetime='".G5_TIME_YMDHIS."', hs_flag='$hs_flag', hs_code='$hs_code', hs_memo='".addslashes($hs_memo)."', hs_log='".addslashes($log)."'", false);
			}
			$SMS->Init(); // 보관하고 있던 결과값을 지웁니다.

			sql_query("update {$g5['sms5_write_table']} set wr_success='$wr_success', wr_failure='$wr_failure', wr_memo='$str_serialize' where wr_no='$wr_no' and wr_renum=0");
		}
		/** 일반회원에게 문자 **/

	}
	/*
		세금 계산서 입력
	*/
	$q = "select count(1) as cnt from g5_order_tax where od_id='".$_REQUEST['od_id']."' ";
	$chk_rows = sql_fetch($q);
	if($chk_rows["cnt"] > 0){
		$q = "update g5_order_tax set mb_id='".$member['mb_id']."',method='".$_REQUEST['method']."', od_settle_case='".$_REQUEST['od_settle_case']."',od_bank_account='".$_REQUEST['od_bank_account']."',od_deposit_name='".$_REQUEST['od_deposit_name']."',
		tax_cash_select='".$_REQUEST['tax_cash_select']."',coNm='".$_REQUEST['coNm']."',coBossName='".$_REQUEST['coBossName']."',coNo='".$_REQUEST['coNo']."',
		coBusiness='".$_REQUEST['coBusiness']."',coType='".$_REQUEST['coType']."',coName='".$_REQUEST['coName']."',coEmail='".$_REQUEST['coEmail']."',
		ph1='".$_REQUEST['ph1']."',ph2='".$_REQUEST['ph2']."',ph3='".$_REQUEST['ph3']."',coNumber1='".$_REQUEST['coNumber1']."',
		coNumber2='".$_REQUEST['coNumber2']."',coNumber3='".$_REQUEST['coNumber3']."',ca1='".$_REQUEST['ca1']."',ca2='".$_REQUEST['ca2']."',
		ca3='".$_REQUEST['ca3']."',ca4='".$_REQUEST['ca4']."' where od_id='".$_REQUEST['od_id']."' ";		
	}else{
		$q = "insert into g5_order_tax(mb_id,method,ca1,ca2,ca3,ca4,coNumber1,coNumber2,coNumber3,ph1,ph2,ph3,od_id, od_settle_case, od_bank_account, od_deposit_name, tax_cash_select, coNm, coBossName, coNo, delivery_return_zip,
		delivery_return_addr1, delivery_return_addr2, delivery_return_addr3, coBusiness, coType, coName, coEmail, dt)values(
		'".$member['mb_id']."','".$_REQUEST['method']."','".$_REQUEST['ca1']."', '".$_REQUEST['ca2']."','".$_REQUEST['ca3']."','".$_REQUEST['ca4']."',
		'".$_REQUEST['coNumber1']."', '".$_REQUEST['coNumber2']."','".$_REQUEST['coNumber3']."','".$_REQUEST['ph1']."', '".$_REQUEST['ph2']."','".$_REQUEST['ph3']."',
		'".$_REQUEST['od_id']."', '".$_REQUEST['od_settle_case']."','".$_REQUEST['od_bank_account']."','".$_REQUEST['od_deposit_name']."','".$_REQUEST['tax_cash_select']."','".$_REQUEST['coNm']."',
		'".$_REQUEST['coBossName']."','".$_REQUEST['coNo']."','".$_REQUEST['delivery_return_zip']."','".$_REQUEST['delivery_return_addr1']."','".$_REQUEST['delivery_return_addr2']."','".$_REQUEST['delivery_return_addr3']."',
		'".$_REQUEST['coBusiness']."','".$_REQUEST['coType']."','".$_REQUEST['coName']."','".$_REQUEST['coEmail']."',now())";
	}
	sql_query($q);

	if ($od_settle_case == "신용카드" || $od_settle_case == "계좌이체") {		
		alert ('결제가 완료되었습니다.', G5_SHOP_URL.'/voiceMypageOrderDetail.php?it_id='.$_REQUEST['it_id'].'&it_gubun='.$_REQUEST['it_gubun'].'&sch='.$_REQUEST['sch'].'&sch_val='.$_REQUEST['sch_val'].'&sod_status='.$_REQUEST['sod_status'].'&page='.$_REQUEST['page']);
	}
	else {				
		alert ('결제신청이 완료되었습니다.', G5_SHOP_URL.'/voiceMypageOrderDetail.php?it_id='.$_REQUEST['it_id'].'&it_gubun='.$_REQUEST['it_gubun'].'&sch='.$_REQUEST['sch'].'&sch_val='.$_REQUEST['sch_val'].'&sod_status='.$_REQUEST['sod_status'].'&page='.$_REQUEST['page']);
	}
	exit;

}
else {
	$od_id = get_uniqid();
	$od_pwd = $member['mb_id'];

	if ( !$_REQUEST['ct_id'] ) {
		$qry = "SELECT a.*, b.ca_name, c.mb_name FROM ".$g5['g5_shop_item_table']." AS a JOIN ".$g5['g5_shop_category_table']." AS b ON a.ca_id=b.ca_id JOIN ".$g5['member_table']." AS c ON a.it_maker=c.mb_id WHERE a.it_id='".$_REQUEST['it_id']."' ";
		$view_dt = sql_fetch($qry);

		$sql = " insert {$g5['g5_shop_cart_table']}
					set it_id             = '".$_REQUEST['it_id']."',
						od_id             = '".$od_id."',
						mb_id             = '".$member['mb_id']."',
						ct_qty            = '1',
						ct_status         = '거래합의중',
						ct_price          = '".$_REQUEST['od_cart_price']."',
						it_name           = '".$view_dt['it_name']."',
						ct_time           = '".G5_TIME_YMDHIS."',
						ct_ip             = '".$_SERVER['REMOTE_ADDR']."',
						ct_direct         = '1',
						ct_select         = '1',
						ct_select_time    = '".G5_TIME_YMDHIS."'
						";
	}
	else {
		$sql = " UPDATE {$g5['g5_shop_cart_table']}
					set ct_status         = '거래합의중', 
						ct_price          = '".$_REQUEST['od_cart_price']."'
					WHERE ct_id = '".$_REQUEST['ct_id']."'
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
	$od_tax_mny = round($_REQUEST['od_cart_price'] / 1.1);
	$od_vat_mny = $_REQUEST['od_cart_price'] - $od_tax_mny;
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
	if ( !$_REQUEST['od_id'] ) {
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
						od_memo           = '".$_REQUEST['od_memo']."',
						od_cart_count     = '1',
						od_cart_price     = '".$_REQUEST['od_cart_price']."',
						od_origin_price   = '".$view_dt['it_price']."',
						od_cart_coupon    = '0',
						od_send_cost      = '0',
						od_send_coupon    = '0',
						od_send_cost2     = '0',
						od_coupon         = '0',
						od_receipt_price  = '0',
						od_receipt_point  = '0',
						od_misu           = '".$_REQUEST['od_cart_price']."',
						od_pg             = '".$od_pg."',
						od_escrow         = '".$od_escrow."',
						od_tax_flag       = '".$od_tax_flag."',
						od_tax_mny        = '".$od_tax_mny."',
						od_vat_mny        = '".$od_vat_mny."',
						od_free_mny       = '".$od_free_mny."',
						od_status         = '거래합의중',
						od_shop_memo      = '',
						od_gubun          = '2',
						od_time           = '".G5_TIME_YMDHIS."',
						od_ip             = '".$_SERVER['REMOTE_ADDR']."',
						od_test           = '".$default['de_card_test']."'
						";
	}
	else {
		$sql = " UPDATE {$g5['g5_shop_order_table']}
					set od_cart_price     = '".$_REQUEST['od_cart_price']."',
						od_misu           = '".$_REQUEST['od_cart_price']."',
						od_memo           = '".$_REQUEST['od_memo']."',
						od_status         = '거래합의중',
						od_tax_mny        = '".$od_tax_mny."',
						od_vat_mny        = '".$od_vat_mny."',
						od_free_mny       = '".$od_free_mny."'
					WHERE od_id = '".$_REQUEST['od_id']."'
						";
	}
	$result = sql_query($sql, false);

	$row3 = sql_fetch ( "SELECT b.* FROM ".$g5['g5_shop_item_table']." AS b WHERE b.it_id='".$_REQUEST['it_id']."' " );
	$recv_mb_id   = $row3['it_maker'];
	$row = sql_fetch ( "SELECT * FROM ".$g5['member_table']." WHERE mb_id='".$recv_mb_id."' " );

	$recv_number = str_replace("-","",$row['mb_hp']);
	$send_number = $sms5['cf_phone'];
	$cmt = "성우의 견적 금액이 도착 했습니다. 마이페이지에서 확인해주세요. -올보이스-";
	$sms_content = iconv_euckr( $cmt );
 
	// $biz_sql = "INSERT INTO BIZ_MSG (MSG_TYPE, CMID, REQUEST_TIME, SEND_TIME, DEST_PHONE, SEND_PHONE,  MSG_BODY, TEMPLATE_CODE, SENDER_KEY, NATION_CODE, ATTACHED_FILE, RE_TYPE, RE_BODY) VALUES (6, '".date("YmdHis")."', NOW(), NOW(), '".$recv_number."', '".$send_number."', '".$cmt."', 'bizp_2019082914411816788931542', '".SENDER_KEY."', '82', 'kakao_button.json', 'SMS', '".$cmt."')";
//if ( $_SERVER['REMOTE_ADDR'] == "175.114.22.192") {echo $biz_sql; exit;}
	//echo $biz_sql;exit;
	// sql_query( $biz_sql );

    // 21	bizp_2020041316310321562467840	합의주문>견적금액도착>To.일반(200413 수정)
    $bizKakao = new BizMsgKakao;
    $bizKakao->insertBizMsgToDB($recv_number, $send_number, biz_msg_type::biz_msg_code_8);

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

	alert('고객에게 협의 내용이 전달되었습니다. 내용 및 견적금액 수정시 아래 수정 내용 저장을 반드시 클릭해주세요.', G5_SHOP_URL.'/voiceMypageOrderDetail.php?it_id='.$_REQUEST['it_id'].'&it_gubun='.$_REQUEST['it_gubun'].'&sch='.$_REQUEST['sch'].'&sch_val='.$_REQUEST['sch_val'].'&sod_status='.$_REQUEST['sod_status'].'&page='.$_REQUEST['page']);
	exit;
}

goto_url(G5_SHOP_URL.'/voiceMypageOrderDetail.php?it_id='.$_REQUEST['it_id'].'&it_gubun='.$_REQUEST['it_gubun'].'&sch='.$_REQUEST['sch'].'&sch_val='.$_REQUEST['sch_val'].'&sod_status='.$_REQUEST['sod_status'].'&page='.$_REQUEST['page'], false);
?>

<html>
    <head>
        <title>주문정보 기록</title>
        <script>
            // 결제 중 새로고침 방지 샘플 스크립트 (중복결제 방지)
            function noRefresh()
            {
                /* CTRL + N키 막음. */
                if ((event.keyCode == 78) && (event.ctrlKey == true))
                {
                    event.keyCode = 0;
                    return false;
                }
                /* F5 번키 막음. */
                if(event.keyCode == 116)
                {
                    event.keyCode = 0;
                    return false;
                }
            }

            document.onkeydown = noRefresh ;
        </script>
    </head>
</html>