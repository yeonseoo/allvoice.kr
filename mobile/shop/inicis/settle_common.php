<?php
include_once('./_common.php');
include_once(ALLV_UTIL_PATH . '/BizMsgKakao.php');


//*******************************************************************************
// FILE NAME : mx_rnoti.php
// FILE DESCRIPTION :
// 이니시스 smart phone 결제 결과 수신 페이지 샘플
// 기술문의 : ts@inicis.com
// HISTORY
// 2010. 02. 25 최초작성
// 2010  06. 23 WEB 방식의 가상계좌 사용시 가상계좌 채번 결과 무시 처리 추가(APP 방식은 해당 없음!!)
// WEB 방식일 경우 이미 P_NEXT_URL 에서 채번 결과를 전달 하였으므로,
// 이니시스에서 전달하는 가상계좌 채번 결과 내용을 무시 하시기 바랍니다.
//*******************************************************************************

$PGIP = $_SERVER['REMOTE_ADDR'];

// 2019-01-28 노티 아이피 203.238.37.15 추가
if($PGIP == "211.219.96.165" || $PGIP == "118.129.210.25" || $PGIP == "183.109.71.153" || $PGIP == "203.238.37.15")	//PG에서 보냈는지 IP로 체크
{
    // 이니시스 NOTI 서버에서 받은 Value
    $P_TID;				// 거래번호
    $P_MID;				// 상점아이디
    $P_AUTH_DT;			// 승인일자
    $P_STATUS;			// 거래상태 (00:성공, 01:실패)
    $P_TYPE;			// 지불수단
    $P_OID;				// 상점주문번호
    $P_FN_CD1;			// 금융사코드1
    $P_FN_CD2;			// 금융사코드2
    $P_FN_NM;			// 금융사명 (은행명, 카드사명, 이통사명)
    $P_AMT;				// 거래금액
    $P_UNAME;			// 결제고객성명
    $P_RMESG1;			// 결과코드
    $P_RMESG2;			// 결과메시지
    $P_NOTI;			// 노티메시지(상점에서 올린 메시지)
    $P_AUTH_NO;			// 승인번호
    $P_SRC_CODE;        // 앱연동 결제구분


    $P_TID      = $_POST['P_TID'];
    $P_MID      = $_POST['P_MID'];
    $P_AUTH_DT  = $_POST['P_AUTH_DT'];
    $P_STATUS   = $_POST['P_STATUS'];
    $P_TYPE     = $_POST['P_TYPE'];
    $P_OID      = $_POST['P_OID'];
    $P_FN_CD1   = $_POST['P_FN_CD1'];
    $P_FN_CD2   = $_POST['P_FN_CD2'];
    $P_FN_NM    = $_POST['P_FN_NM'];
    $P_AMT      = $_POST['P_AMT'];
    $P_UNAME    = $_POST['P_UNAME'];
    $P_RMESG1   = $_POST['P_RMESG1'];
    $P_RMESG2   = $_POST['P_RMESG2'];
    $P_NOTI     = $_POST['P_NOTI'];
    $P_AUTH_NO  = $_POST['P_AUTH_NO'];
    $P_SRC_CODE = $_POST['P_SRC_CODE'];

    include_once(G5_MSHOP_PATH.'/settle_inicis.inc.php');
    
    if(! ($default['de_pg_service'] === 'inicis' && $default['de_inicis_mid'] === $P_MID)){
        echo "FAIL";
        return;
    }

    // 결과 incis log 테이블 기록
    if($P_TYPE == 'BANK' || $P_SRC_CODE == 'A') {

        if(!sql_query(" select post_data from {$g5['g5_shop_inicis_log_table']} limit 1 ", false)) {
            sql_query(" ALTER TABLE `{$g5['g5_shop_inicis_log_table']}`
                            ADD `post_data` text NOT NULL AFTER `P_RMESG1`,
                            ADD `is_mail_send` tinyint(4) NOT NULL DEFAULT '1' AFTER `post_data` ", false);
        }

        $sql = " insert into {$g5['g5_shop_inicis_log_table']}
                    set oid       = '$P_OID',
                        P_TID     = '$P_TID',
                        P_MID     = '$P_MID',
                        P_AUTH_DT = '$P_AUTH_DT',
                        P_STATUS  = '$P_STATUS',
                        P_TYPE    = '$P_TYPE',
                        P_OID     = '$P_OID',
                        P_FN_NM   = '".iconv_utf8($P_FN_NM)."',
                        P_AUTH_NO = '$P_AUTH_NO',
                        P_AMT     = '$P_AMT',
                        P_RMESG1  = '".iconv_utf8($P_RMESG1)."',
                        post_data = '".base64_encode(serialize($_POST))."',
                        is_mail_send = 0 ";
        sql_query($sql, false);
    }

    if( $P_STATUS == "00" && $P_TID && $P_MID && $P_TYPE != "VBANK" ){

        // 주문이 있는지 체크
        $sql = "select count(od_id) as cnt from {$g5['g5_shop_order_table']} where od_id = '$P_OID' and od_tno = '$P_TID' ";
        $exist_order = sql_fetch($sql);
        
        if( !$exist_order['cnt'] ){
            //주문정보를 insert 합니다.
            
            $sql = " select * from {$g5['g5_shop_order_data_table']} where od_id = $P_OID ";
            $od = sql_fetch($sql);
            $data = unserialize(base64_decode($od['dt_data']));

            //개인결제
            if(isset($data['pp_id']) && !empty($data['pp_id'])) {

                // 개인결제 정보
                $pp_check = false;
                $sql = " select * from {$g5['g5_shop_personalpay_table']} where pp_id = '$P_OID' and pp_tno = '$P_TID' and pp_use = '1' ";
                $pp = sql_fetch($sql);

                if( !$pp['pp_tno'] && $data['pp_id'] == $P_OID ){

                    $res_cd = $P_STATUS;
                    $pp_id = $P_OID;

                    $exclude = array('res_cd', 'P_HASH', 'P_TYPE', 'P_AUTH_DT', 'P_VACT_BANK', 'LGD_PAYKEY', 'pp_id', 'good_mny', 'pp_name', 'pp_email', 'pp_hp', 'pp_settle_case');

                    $params = array();

                    foreach($data as $key=>$v) {
                        if( !in_array($key, $exclude) ){
                            $_POST[$key] = $params[$key] = clean_xss_tags(strip_tags($v));
                        }
                    }

                    $good_mny = $P_AMT;
                    $pp_name = clean_xss_tags($data['pp_name']);
                    $pp_email = clean_xss_tags($data['pp_email']);
                    $pp_hp = clean_xss_tags($data['pp_hp']);
                    $pp_settle_case = clean_xss_tags($data['pp_settle_case']);

                    set_session('P_TID', $P_TID);
                    set_session('P_AMT', $P_AMT);
                    $_POST['P_HASH'] = md5(get_session('P_TID').$default['de_inicis_mid'].$P_AMT);
                    $_POST['P_AUTH_NO'] = $P_AUTH_NO;
                    $_POST['pp_id'] = $P_OID;
                    $_POST['good_mny'] = $P_AMT;
                    $is_noti_pay = true;

                    $sql = " select pp_time from {$g5['g5_shop_personalpay_table']} where pp_id = '$P_OID' and pp_use = '1' ";
                    $pp_time = sql_fetch($sql);

                    set_session('ss_personalpay_id', $P_OID);
                    set_session('ss_personalpay_hash', md5($P_OID.$P_AMT.$pp_time['pp_time']));

                    include_once( G5_MSHOP_PATH.'/personalpayformupdate.php' );

                    if( !$order_id ){
                        echo "FAIL";
                    } else {
                        $sql = " delete from {$g5['g5_shop_inicis_log_table']} where (oid = '$P_OID' and P_TID = '$P_TID') OR substr(P_AUTH_DT, 1, 8) < '".date('Ymd', strtotime('-1 month', G5_SERVER_TIME))."' ";
                        sql_query( $sql , false);
                    }
                }

            //상품주문
            } else {

                if($od && isset($data['it_id']) && !empty($data['it_id'])) {

                    $PAY = array(
                        'oid'   => $P_OID,
                        'P_TID'     => $P_TID,
                        'P_MID'     => $P_MID,
                        'P_AUTH_DT' => $P_AUTH_DT,
                        'P_STATUS'  => $P_STATUS,
                        'P_TYPE'    => $P_TYPE,
                        'P_OID'     => $P_OID,
                        'P_FN_NM'   => iconv_utf8($P_FN_NM),
                        'P_AUTH_NO' => $P_AUTH_NO,
                        'P_AMT'     => $P_AMT,
                        'P_RMESG1'  => iconv_utf8($P_RMESG1)
                        );

                    // TID, AMT 를 세션으로 주문완료 페이지 전달
                    $hash = md5($PAY['P_TID'].$PAY['P_MID'].$PAY['P_AMT']);
                    set_session('P_TID',  $PAY['P_TID']);
                    set_session('P_AMT',  $PAY['P_AMT']);
                    set_session('P_HASH', $hash);
                    set_session('ss_order_id', $P_OID);

                    $params = array();
                    $exclude = array('res_cd', 'P_HASH', 'P_TYPE', 'P_AUTH_DT', 'P_VACT_BANK', 'P_AUTH_NO');

                    foreach($data as $key=>$value) {
                        if(!empty($exclude) && in_array($key, $exclude))
                            continue;

                        if(is_array($value)) {
                            foreach($value as $k=>$v) {
                                $_POST[$key][$k] = $params[$key][$k] = clean_xss_tags(strip_tags($v));
                            }
                        } else {
                            $_POST[$key] = $params[$key] = clean_xss_tags(strip_tags($value));
                        }
                    }
                    
                    if( !empty($params['sw_direct']) && !empty($params['post_cart_id'])  ){
                        set_session('ss_direct', $params['sw_direct']);
                        set_session('ss_cart_direct', $params['post_cart_id']);
                    } else if ( $params['post_cart_id'] ){
                        set_session('ss_cart_id', $params['post_cart_id']);
                    }
                    
                    try {
                        unset($params['sw_direct']);
                        unset($params['post_cart_id']);
                    } catch (Exception $e) {
                    }

                    $_POST['res_cd'] = $params['res_cd'] = $PAY['P_STATUS'];
                    $_POST['P_HASH'] = $params['P_HASH'] = $hash;
                    $_POST['P_TYPE'] = $params['P_TYPE'] = $PAY['P_TYPE'];
                    $_POST['P_AUTH_DT'] = $params['P_AUTH_DT'] = $PAY['P_AUTH_DT'];
                    $_POST['P_VACT_BANK'] = $params['P_VACT_BANK'] = $PAY['P_FN_NM'];
                    $_POST['P_AUTH_NO'] = $params['P_AUTH_NO'] = $PAY['P_AUTH_NO'];

                    $check_keys = array('od_name', 'od_tel', 'od_pwd', 'od_hp', 'od_zip', 'od_addr1', 'od_addr2', 'od_addr3', 'od_addr_jibeon', 'od_email', 'ad_default', 'ad_subject', 'od_hope_date', 'od_b_name', 'od_b_tel', 'od_b_hp', 'od_b_zip', 'od_b_addr1', 'od_b_addr2', 'od_b_addr3', 'od_b_addr_jibeon', 'od_memo', 'od_settle_case', 'max_temp_point', 'od_temp_point', 'od_send_cost', 'od_send_cost2', 'od_bank_account', 'od_deposit_name', 'od_test', 'od_ip');
                    
                    foreach($check_keys as $key){
                        $$key = isset($params[$key]) ? $params[$key] : '';
                    }
                    
                    $od_send_cost = (int) $od_send_cost;
                    $od_send_cost2 = (int) $od_send_cost2;
                    $ad_default = (int) $ad_default;

                    if( $od['mb_id'] ){
                        $is_member = true;
                        $member = get_member($od['mb_id']);
                    }

                    $is_noti_pay = true;
                    include_once( G5_MSHOP_PATH.'/orderformupdate.php' );
                    
                    if( !$order_id ){
                        echo "FAIL";
                    } else {
                        $sql = " delete from {$g5['g5_shop_inicis_log_table']} where (oid = '$P_OID' and P_TID = '$P_TID') OR substr(P_AUTH_DT, 1, 8) < '".date('Ymd', strtotime('-1 month', G5_SERVER_TIME))."' ";
                        sql_query( $sql , false);
                    }
                }

            }
        }
    }

    //WEB 방식의 경우 가상계좌 채번 결과 무시 처리
    //(APP 방식의 경우 해당 내용을 삭제 또는 주석 처리 하시기 바랍니다.)
    if($P_TYPE == "VBANK")	//결제수단이 가상계좌이며
    {
       if($P_STATUS != "02") //입금통보 "02" 가 아니면(가상계좌 채번 : 00 또는 01 경우)
       {
          echo "OK";
          return;
       }

       // 입금결과 처리
        $sql = " select pp_id, od_id from {$g5['g5_shop_personalpay_table']} where pp_id = '$P_OID' and pp_tno = '$P_TID' ";
        $row = sql_fetch($sql);

        $result = false;
        $receipt_time = $P_AUTH_DT;

        if($row['pp_id']) {
            // 개인결제 UPDATE
            $sql = " update {$g5['g5_shop_personalpay_table']}
                        set pp_receipt_price    = '$P_AMT',
                            pp_receipt_time     = '$receipt_time'
                        where pp_id = '$P_OID'
                          and pp_tno = '$P_TID' ";
            sql_query($sql, false);

            if($row['od_id']) {
                // 주문서 UPDATE
                $receipt_time    = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3 \\4:\\5:\\6", $receipt_time);
                $sql = " update {$g5['g5_shop_order_table']}
                            set od_receipt_price = od_receipt_price + '$P_AMT',
                                od_receipt_time = '$receipt_time',
                                od_shop_memo = concat(od_shop_memo, \"\\n개인결제 ".$row['pp_id']." 로 결제완료 - ".$receipt_time."\")
                          where od_id = '{$row['od_id']}' ";
                $result = sql_query($sql, FALSE);
            }
        } else {
            // 주문서 UPDATE
            $sql = " update {$g5['g5_shop_order_table']}
                        set od_receipt_price = '$P_AMT',
                            od_receipt_time = '$receipt_time'
                      where od_id = '$P_OID'
                        and od_tno = '$P_TID' ";
            $result = sql_query($sql, FALSE);
        }

        if($result) {
            if($row['od_id'])
                $od_id = $row['od_id'];
            else
                $od_id = $P_OID;

            // 주문정보 체크
            $sql = " select count(od_id) as cnt
                        from {$g5['g5_shop_order_table']}
                        where od_id = '$od_id'
                          and od_status = '거래합의중' ";
            $row = sql_fetch($sql);

            if($row['cnt'] == 1) {
                // 미수금 정보 업데이트
                $info = get_order_info($od_id);

                $sql = " update {$g5['g5_shop_order_table']}
                            set od_misu = '{$info['od_misu']}' ";
                if($info['od_misu'] == 0)
                    $sql .= " , od_status = '작업진행중' ";
                $sql .= " where od_id = '$od_id' ";
                sql_query($sql, FALSE);

                // 장바구니 상태변경
                if($info['od_misu'] == 0) {
                    $sql = " update {$g5['g5_shop_cart_table']}
                                set ct_status = '작업진행중'
                                where od_id = '$od_id' ";
                    sql_query($sql, FALSE);
                }

				$row = sql_fetch ( "SELECT b.* FROM ".$g5['g5_shop_cart_table']." AS a JOIN ".$g5['g5_shop_item_table']." AS b ON a.it_id=b.it_id JOIN ".$g5['g5_shop_order_table']." AS c ON a.od_id=c.od_id WHERE c.od_id='".$od_id."' " );
				$recv_mb_id   = $row['it_origin'];
				$recv_mb_id2   = $row['it_maker'];
				$row = sql_fetch ( "SELECT * FROM ".$g5['member_table']." WHERE mb_id='".$recv_mb_id."' " );

				$recv_number = str_replace("-","",$row['mb_hp']);
				$send_number = $sms5['cf_phone'];
				$cmt = "결제완료, 작업을 진행해주세요. 성우님의 안심번호를 안내하였습니다. -올보이스-";
				$sms_content = iconv_euckr( $cmt );

				//$biz_sql = "INSERT INTO BIZ_MSG (MSG_TYPE, CMID, REQUEST_TIME, SEND_TIME, DEST_PHONE, SEND_PHONE,  MSG_BODY, TEMPLATE_CODE, SENDER_KEY, NATION_CODE, ATTACHED_FILE, RE_TYPE, RE_BODY) VALUES (6, '".date("YmdHis")."', NOW(), NOW(), '".$recv_number."', '".$send_number."', '".$cmt."', 'bizp_2019082914404422317898522', '".SENDER_KEY."', '82', 'kakao_button.json', 'SMS', '".$cmt."')";
				//echo $biz_sql;
				//sql_query( $biz_sql );

                // 20	bizp_2020041316284303031003911	결제완료>To.성우(200413 수정)
                $bizKakao = new BizMsgKakao;
                $bizKakao->insertBizMsgToDB($recv_number, $send_number, biz_msg_type::biz_msg_code_9);

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

				/** 일반회원에게 문자 **/
				$row = sql_fetch ( "SELECT * FROM ".$g5['member_table']." WHERE mb_id='".$recv_mb_id2."' " );

				$recv_number = str_replace("-","",$row['mb_hp']);
				$send_number = $sms5['cf_phone'];
				$cmt = "결제가 완료되어, 사이트 내에서 성우의 안심번호를 확인할 수 있습니다. -올보이스-";
				$sms_content = iconv_euckr( $cmt );

				// $biz_sql = "INSERT INTO BIZ_MSG (MSG_TYPE, CMID, REQUEST_TIME, SEND_TIME, DEST_PHONE, SEND_PHONE,  MSG_BODY, TEMPLATE_CODE, SENDER_KEY, NATION_CODE, ATTACHED_FILE, RE_TYPE, RE_BODY) VALUES (6, '".date("YmdHis",time()+1)."', NOW(), NOW(), '".$recv_number."', '".$send_number."', '".$cmt."', 'bizp_2019082914395422317226521', '".SENDER_KEY."', '82', 'kakao_button.json', 'SMS', '".$cmt."')";
				//echo $biz_sql;
				// sql_query( $biz_sql );

                // 19	bizp_2020041316274103031088910	결제완료>To.일반(200413 수정)
                $bizKakao = new BizMsgKakao;
                $bizKakao->insertBizMsgToDB($recv_number, $send_number, biz_msg_type::biz_msg_code_10);
                

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
				/** 일반회원에게 문자 **/

            }
        }

        if($result) {
            echo "OK";
            return;
        } else {
            echo "FAIL";
            return;
        }
    }

    $PageCall_time = date("H:i:s");

    $value = array(
                "PageCall time" => $PageCall_time,
                "P_TID"			=> $P_TID,
                "P_MID"         => $P_MID,
                "P_AUTH_DT"     => $P_AUTH_DT,
                "P_STATUS"      => $P_STATUS,
                "P_TYPE"        => $P_TYPE,
                "P_OID"         => $P_OID,
                "P_FN_CD1"      => $P_FN_CD1,
                "P_FN_CD2"      => $P_FN_CD2,
                "P_FN_NM"       => $P_FN_NM,
                "P_AMT"         => $P_AMT,
                "P_UNAME"       => $P_UNAME,
                "P_RMESG1"      => $P_RMESG1,
                "P_RMESG2"      => $P_RMESG2,
                "P_NOTI"        => $P_NOTI,
                "P_AUTH_NO"     => $P_AUTH_NO,
                "P_SRC_CODE"    => $P_SRC_CODE
            );

    // 결제처리에 관한 로그 기록
    //writeLog($value);

    /***********************************************************************************
     ' 위에서 상점 데이터베이스에 등록 성공유무에 따라서 성공시에는 "OK"를 이니시스로 실패시는 "FAIL" 을
     ' 리턴하셔야합니다. 아래 조건에 데이터베이스 성공시 받는 FLAG 변수를 넣으세요
     ' (주의) OK를 리턴하지 않으시면 이니시스 지불 서버는 "OK"를 수신할때까지 계속 재전송을 시도합니다
     ' 기타 다른 형태의 echo "" 는 하지 않으시기 바랍니다
    '***********************************************************************************/

    echo 'OK';

}

function writeLog($msg)
{
    $file = G5_SHOP_PATH."/inicis/log/noti_input_".date("Ymd").".log";

    if(!($fp = fopen($path.$file, "a+"))) return 0;

    ob_start();
    print_r($msg);
    $ob_msg = ob_get_contents();
    ob_clean();

    if(fwrite($fp, " ".$ob_msg."\n") === FALSE)
    {
        fclose($fp);
        return 0;
    }
    fclose($fp);
    return 1;
}
?>
