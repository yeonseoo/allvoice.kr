<?php
$sub_menu = '400400';
include_once('./_common.php');
include_once(ALLV_UTIL_PATH . '/BizMsgKakao.php');

auth_check($auth[$sub_menu], "w");

check_admin_token();

$ct_chk_count = count($_POST['ct_chk']);
if(!$ct_chk_count)
    alert('처리할 자료를 하나 이상 선택해 주십시오.');

//$status_normal = array('주문','입금','준비','배송','완료','작업완료','작업진행중','거래합의중','의뢰완료','지원완료','채택완료');
$status_normal = array('주문','입금','준비','배송','완료','작업완료','작업진행중','거래합의중','의뢰완료','진행중','지원완료','채택완료');
$status_cancel = array('취소','의뢰취소','반품','품절');

if (in_array($_POST['ct_status'], $status_normal) || in_array($_POST['ct_status'], $status_cancel)) {
    ; // 통과
} else {
    alert('변경할 상태가 올바르지 않습니다.');
}

$mod_history = '';
$cnt = count($_POST['ct_id']);
$arr_it_id = array();

for ($i=0; $i<$cnt; $i++)
{
    $k = $_POST['ct_chk'][$i];
    $ct_id = $_POST['ct_id'][$k];

    if(!$ct_id)
        continue;

    $sql = " select * from {$g5['g5_shop_cart_table']} where od_id = '$od_id' and ct_id  = '$ct_id' ";
    $ct = sql_fetch($sql);
    if(!$ct['ct_id'])
        continue;

    // 수량이 변경됐다면
    $ct_qty = $_POST['ct_qty'][$k];
    if($ct['ct_qty'] != $ct_qty) {
        $diff_qty = $ct['ct_qty'] - $ct_qty;

        // 재고에 차이 반영.
        if($ct['ct_stock_use']) {
            if($ct['io_id']) {
                $sql = " update {$g5['g5_shop_item_option_table']}
                            set io_stock_qty = io_stock_qty + '$diff_qty'
                            where it_id = '{$ct['it_id']}'
                              and io_id = '{$ct['io_id']}'
                              and io_type = '{$ct['io_type']}' ";
            } else {
                $sql = " update {$g5['g5_shop_item_table']}
                            set it_stock_qty = it_stock_qty + '$diff_qty'
                            where it_id = '{$ct['it_id']}' ";
            }

            sql_query($sql);
        }

        // 수량변경
        $sql = " update {$g5['g5_shop_cart_table']}
                    set ct_qty = '$ct_qty'
                    where ct_id = '$ct_id'
                      and od_id = '$od_id' ";
        sql_query($sql);
        $mod_history .= G5_TIME_YMDHIS.' '.$ct['ct_option'].' 수량변경 '.$ct['ct_qty'].' -> '.$ct_qty."\n";
    }

    // 재고를 이미 사용했다면 (재고에서 이미 뺐다면)
    $stock_use = $ct['ct_stock_use'];
    if ($ct['ct_stock_use'])
    {
        if ($ct_status == '주문' || $ct_status == '취소' || $ct_status == '반품' || $ct_status == '품절')
        {
            $stock_use = 0;
            // 재고에 다시 더한다.
            if($ct['io_id']) {
                $sql = " update {$g5['g5_shop_item_option_table']}
                            set io_stock_qty = io_stock_qty + '{$ct['ct_qty']}'
                            where it_id = '{$ct['it_id']}'
                              and io_id = '{$ct['io_id']}'
                              and io_type = '{$ct['io_type']}' ";
            } else {
                $sql = " update {$g5['g5_shop_item_table']}
                            set it_stock_qty = it_stock_qty + '{$ct['ct_qty']}'
                            where it_id = '{$ct['it_id']}' ";
            }

            sql_query($sql);
        }
    }
    else
    {
        // 재고 오류로 인한 수정
        if ($ct_status == '배송' || $ct_status == '완료')
        {
            $stock_use = 1;
            // 재고에서 뺀다.
            if($ct['io_id']) {
                $sql = " update {$g5['g5_shop_item_option_table']}
                            set io_stock_qty = io_stock_qty - '{$ct['ct_qty']}'
                            where it_id = '{$ct['it_id']}'
                              and io_id = '{$ct['io_id']}'
                              and io_type = '{$ct['io_type']}' ";
            } else {
                $sql = " update {$g5['g5_shop_item_table']}
                            set it_stock_qty = it_stock_qty - '{$ct['ct_qty']}'
                            where it_id = '{$ct['it_id']}' ";
            }

            sql_query($sql);
        }
        /* 주문 수정에서 "품절" 선택시 해당 상품 자동 품절 처리하기
        else if ($ct_status == '품절') {
            $stock_use = 1;
            // 재고에서 뺀다.
            $sql =" update {$g5['g5_shop_item_table']} set it_stock_qty = 0 where it_id = '{$ct['it_id']}' ";
            sql_query($sql);
        } */
    }

    $point_use = $ct['ct_point_use'];
    // 회원이면서 포인트가 0보다 크면
    // 이미 포인트를 부여했다면 뺀다.
    if ($mb_id && $ct['ct_point'] && $ct['ct_point_use'])
    {
        $point_use = 0;
        //insert_point($mb_id, (-1) * ($ct[ct_point] * $ct[ct_qty]), "주문번호 $od_id ($ct_id) 취소");
        delete_point($mb_id, "@delivery", $mb_id, "$od_id,$ct_id");
    }

    // 히스토리에 남김
    // 히스토리에 남길때는 작업|아이디|시간|IP|그리고 나머지 자료
    $now = G5_TIME_YMDHIS;
    $ct_history="\n$ct_status|{$member['mb_id']}|$now|$REMOTE_ADDR";

    $sql = " update {$g5['g5_shop_cart_table']}
                set ct_point_use  = '$point_use',
                    ct_stock_use  = '$stock_use',
                    ct_status     = '$ct_status',
                    ct_history    = CONCAT(ct_history,'$ct_history')
                where od_id = '$od_id'
                and ct_id  = '$ct_id' ";
    sql_query($sql);

    // it_id를 배열에 저장
    if($ct_status == '주문' || $ct_status == '취소' || $ct_status == '반품' || $ct_status == '품절' || $ct_status == '완료')
        $arr_it_id[] = $ct['it_id'];
}

// 상품 판매수량 반영
if(is_array($arr_it_id) && !empty($arr_it_id)) {
    $unq_it_id = array_unique($arr_it_id);

    foreach($unq_it_id as $it_id) {
        $sql2 = " select sum(ct_qty) as sum_qty from {$g5['g5_shop_cart_table']} where it_id = '$it_id' and ct_status = '완료' ";
        $row2 = sql_fetch($sql2);

        $sql3 = " update {$g5['g5_shop_item_table']} set it_sum_qty = '{$row2['sum_qty']}' where it_id = '$it_id' ";
        sql_query($sql3);
    }
}

// 장바구니 상품 모두 취소일 경우 주문상태 변경
$cancel_change = false;
if (in_array($_POST['ct_status'], $status_cancel)) {
    $sql = " select count(*) as od_count1,
                    SUM(IF(ct_status = '취소' OR ct_status = '반품' OR ct_status = '품절', 1, 0)) as od_count2
                from {$g5['g5_shop_cart_table']}
                where od_id = '$od_id' ";
    $row = sql_fetch($sql);

    if($row['od_count1'] == $row['od_count2']) {
        $cancel_change = true;

        $pg_res_cd = '';
        $pg_res_msg = '';
        $pg_cancel_log = '';

        // PG 신용카드 결제 취소일 때
        if($pg_cancel == 1) {
            $sql = " select * from {$g5['g5_shop_order_table']} where od_id = '$od_id' ";
            $od = sql_fetch($sql);

            if($od['od_tno'] && ($od['od_settle_case'] == '신용카드' || $od['od_settle_case'] == '간편결제' || $od['od_settle_case'] == 'KAKAOPAY') || ($od['od_pg'] == 'inicis' && is_inicis_order_pay($od['od_settle_case']) )) {
                switch($od['od_pg']) {
                    case 'lg':
                        include_once(G5_SHOP_PATH.'/settle_lg.inc.php');

                        $LGD_TID = $od['od_tno'];

                        $xpay = new XPay($configPath, $CST_PLATFORM);

                        // Mert Key 설정
                        $xpay->set_config_value('t'.$LGD_MID, $config['cf_lg_mert_key']);
                        $xpay->set_config_value($LGD_MID, $config['cf_lg_mert_key']);

                        $xpay->Init_TX($LGD_MID);

                        $xpay->Set('LGD_TXNAME', 'Cancel');
                        $xpay->Set('LGD_TID', $LGD_TID);

                        if ($xpay->TX()) {
                            $res_cd = $xpay->Response_Code();
                            if($res_cd != '0000' && $res_cd != 'AV11') {
                                $pg_res_cd = $res_cd;
                                $pg_res_msg = $xpay->Response_Msg();
                            }
                        } else {
                            $pg_res_cd = $xpay->Response_Code();
                            $pg_res_msg = $xpay->Response_Msg();
                        }
                        break;
                    case 'inicis':
                        include_once(G5_SHOP_PATH.'/settle_inicis.inc.php');
                        $cancel_msg = iconv_euckr('쇼핑몰 운영자 승인 취소');

                        /*********************
                         * 3. 취소 정보 설정 *
                         *********************/
                        $inipay->SetField("type",      "cancel");                        // 고정 (절대 수정 불가)
                        $inipay->SetField("mid",       $default['de_inicis_mid']);       // 상점아이디
                        /**************************************************************************************************
                         * admin 은 키패스워드 변수명입니다. 수정하시면 안됩니다. 1111의 부분만 수정해서 사용하시기 바랍니다.
                         * 키패스워드는 상점관리자 페이지(https://iniweb.inicis.com)의 비밀번호가 아닙니다. 주의해 주시기 바랍니다.
                         * 키패스워드는 숫자 4자리로만 구성됩니다. 이 값은 키파일 발급시 결정됩니다.
                         * 키패스워드 값을 확인하시려면 상점측에 발급된 키파일 안의 readme.txt 파일을 참조해 주십시오.
                         **************************************************************************************************/
                        $inipay->SetField("admin",     $default['de_inicis_admin_key']); //비대칭 사용키 키패스워드
                        $inipay->SetField("tid",       $od['od_tno']);                   // 취소할 거래의 거래아이디
                        $inipay->SetField("cancelmsg", $cancel_msg);                     // 취소사유

                        /****************
                         * 4. 취소 요청 *
                         ****************/
                        $inipay->startAction();

                        /****************************************************************
                         * 5. 취소 결과                                           	*
                         *                                                        	*
                         * 결과코드 : $inipay->getResult('ResultCode') ("00"이면 취소 성공)  	*
                         * 결과내용 : $inipay->getResult('ResultMsg') (취소결과에 대한 설명) 	*
                         * 취소날짜 : $inipay->getResult('CancelDate') (YYYYMMDD)          	*
                         * 취소시각 : $inipay->getResult('CancelTime') (HHMMSS)            	*
                         * 현금영수증 취소 승인번호 : $inipay->getResult('CSHR_CancelNum')    *
                         * (현금영수증 발급 취소시에만 리턴됨)                          *
                         ****************************************************************/

                        $res_cd  = $inipay->getResult('ResultCode');
                        $res_msg = $inipay->getResult('ResultMsg');

                        if($res_cd != '00') {
                            $pg_res_cd = $res_cd;
                            $pg_res_msg = iconv_utf8($res_msg);
                        }
                        break;
                    case 'KAKAOPAY':
                        include_once(G5_SHOP_PATH.'/settle_kakaopay.inc.php');
                        $_REQUEST['TID']               = $od['od_tno'];
                        $_REQUEST['Amt']               = $od['od_receipt_price'];
                        $_REQUEST['CancelMsg']         = '쇼핑몰 운영자 승인 취소';
                        $_REQUEST['PartialCancelCode'] = 0;
                        include G5_SHOP_PATH.'/kakaopay/kakaopay_cancel.php';
                        break;
                    default:
                        include_once(G5_SHOP_PATH.'/settle_kcp.inc.php');
                        require_once(G5_SHOP_PATH.'/kcp/pp_ax_hub_lib.php');

                        // locale ko_KR.euc-kr 로 설정
                        setlocale(LC_CTYPE, 'ko_KR.euc-kr');

                        $c_PayPlus = new C_PP_CLI_T;

                        $c_PayPlus->mf_clear();

                        $tno = $od['od_tno'];
                        $tran_cd = '00200000';
                        $cancel_msg = iconv_euckr('쇼핑몰 운영자 승인 취소');
                        $cust_ip = $_SERVER['REMOTE_ADDR'];
                        $bSucc_mod_type = "STSC";

                        $c_PayPlus->mf_set_modx_data( "tno",      $tno                         );  // KCP 원거래 거래번호
                        $c_PayPlus->mf_set_modx_data( "mod_type", $bSucc_mod_type              );  // 원거래 변경 요청 종류
                        $c_PayPlus->mf_set_modx_data( "mod_ip",   $cust_ip                     );  // 변경 요청자 IP
                        $c_PayPlus->mf_set_modx_data( "mod_desc", $cancel_msg );  // 변경 사유

                        $c_PayPlus->mf_do_tx( $tno,  $g_conf_home_dir, $g_conf_site_cd,
                                              $g_conf_site_key,  $tran_cd,    "",
                                              $g_conf_gw_url,  $g_conf_gw_port,  "payplus_cli_slib",
                                              $ordr_idxx, $cust_ip, "3" ,
                                              0, 0, $g_conf_key_dir, $g_conf_log_dir);

                        $res_cd  = $c_PayPlus->m_res_cd;
                        $res_msg = $c_PayPlus->m_res_msg;

                        if($res_cd != '0000') {
                            $pg_res_cd = $res_cd;
                            $pg_res_msg = iconv_utf8($res_msg);
                        }

                        // locale 설정 초기화
                        setlocale(LC_CTYPE, '');
                        break;
                }

                // PG 취소요청 성공했으면
                if($pg_res_cd == '') {
                    $pg_cancel_log = ' PG 신용카드 승인취소 처리';
                    $sql = " update {$g5['g5_shop_order_table']}
                                set od_refund_price = '{$od['od_receipt_price']}'
                                where od_id = '$od_id' ";
                    sql_query($sql);
                }
            }
        }

        // 관리자 주문취소 로그
        $mod_history .= G5_TIME_YMDHIS.' '.$member['mb_id'].' 주문'.$_POST['ct_status'].' 처리'.$pg_cancel_log."\n";
    }
}

// 미수금 등의 정보
$info = get_order_info($od_id);

if(!$info)
    alert('주문자료가 존재하지 않습니다.');

$sql = " update {$g5['g5_shop_order_table']}
            set od_cart_price   = '{$info['od_cart_price']}',
                od_cart_coupon  = '{$info['od_cart_coupon']}',
                od_coupon       = '{$info['od_coupon']}',
                od_send_coupon  = '{$info['od_send_coupon']}',
                od_cancel_price = '{$info['od_cancel_price']}',
                od_send_cost    = '{$info['od_send_cost']}',
                od_misu         = '{$info['od_misu']}',
                od_tax_mny      = '{$info['od_tax_mny']}',
                od_vat_mny      = '{$info['od_vat_mny']}',
                od_free_mny     = '{$info['od_free_mny']}' ";
if ($mod_history) { // 주문변경 히스토리 기록
    $sql .= " , od_mod_history = CONCAT(od_mod_history,'$mod_history') ";
}

if($cancel_change) {
    $sql .= " , od_status = '취소' "; // 주문상품 모두 취소, 반품, 품절이면 주문 취소
} else {
    if (in_array($_POST['ct_status'], $status_normal)) { // 정상인 주문상태만 기록
        $sql .= " , od_status = '{$_POST['ct_status']}' ";
    }
}

$sql .= " where od_id = '$od_id' ";
sql_query($sql);

if ( $_POST['ct_status'] == "작업진행중" ) {

	$row = sql_fetch ( "SELECT b.* FROM ".$g5['g5_shop_cart_table']." AS a JOIN ".$g5['g5_shop_item_table']." AS b ON a.it_id=b.it_id JOIN ".$g5['g5_shop_order_table']." AS c ON a.od_id=c.od_id WHERE c.od_id='".$od_id."' " );
	$recv_mb_id   = $row['it_origin'];
	$recv_mb_id2   = $row['it_maker'];
	$row = sql_fetch ( "SELECT * FROM ".$g5['member_table']." WHERE mb_id='".$recv_mb_id."' " );

	$recv_number = str_replace("-","",$row['mb_hp']);
	$send_number = $sms5['cf_phone'];
	$cmt = "결제완료, 작업을 진행해주세요. 성우님의 안심번호를 안내하였습니다. -올보이스-";
	$sms_content = iconv_euckr( $cmt );

	//$biz_sql = "INSERT INTO BIZ_MSG (MSG_TYPE, CMID, REQUEST_TIME, SEND_TIME, DEST_PHONE, SEND_PHONE,  MSG_BODY, TEMPLATE_CODE, SENDER_KEY, NATION_CODE, ATTACHED_FILE, RE_TYPE, RE_BODY) VALUES (6, '".date("YmdHis")."', NOW(), NOW(), '".$recv_number."', '".$send_number."', '".$cmt."', 'bizp_2019082914404422317898522', '".SENDER_KEY."', '82', 'kakao_button.json', 'SMS', '".$cmt."')";
	//echo $biz_sql;exit;
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

	//$biz_sql = "INSERT INTO BIZ_MSG (MSG_TYPE, CMID, REQUEST_TIME, SEND_TIME, DEST_PHONE, SEND_PHONE,  MSG_BODY, TEMPLATE_CODE, SENDER_KEY, NATION_CODE, ATTACHED_FILE, RE_TYPE, RE_BODY) VALUES (6, '".date("YmdHis",time()+1)."', NOW(), NOW(), '".$recv_number."', '".$send_number."', '".$cmt."', 'bizp_2019082914395422317226521', '".SENDER_KEY."', '82', 'kakao_button.json', 'SMS', '".$cmt."')";
	//echo $biz_sql;
	//sql_query( $biz_sql );

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

$qstr = "sort1=$sort1&amp;sort2=$sort2&amp;sel_field=$sel_field&amp;search=$search&amp;page=$page";

$url = "./orderform.php?od_id=$od_id&amp;$qstr";

// 신용카드 취소 때 오류가 있으면 알림
if($pg_cancel == 1 && $pg_res_cd && $pg_res_msg) {
    alert('오류코드 : '.$pg_res_cd.' 오류내용 : '.$pg_res_msg, $url);
} else {
    // 1.06.06
    $od = sql_fetch(" select od_receipt_point from {$g5['g5_shop_order_table']} where od_id = '$od_id' ");
    if ($od['od_receipt_point'])
        alert("포인트로 결제한 주문은,\\n\\n주문상태 변경으로 인해 포인트의 가감이 발생하는 경우\\n\\n회원관리 > 포인트관리에서 수작업으로 포인트를 맞추어 주셔야 합니다.", $url);
    else
        goto_url($url);
}
?>
