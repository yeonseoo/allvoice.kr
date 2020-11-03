<?php
include_once('./_common.php');
include_once(G5_CAPTCHA_PATH . '/captcha.lib.php');
?>
    <style type="text/css">
        .ttrxHeader,
        #subCate,
        #ttrxFooter {
            display: none !important;
        }

        body {
            padding-top: 0;
        }

        #contentsWrap {
            margin-top: 0;
        }

        #contentsWrap > div {
            width: 100%;
        }

        body {
            background-color: #f7f7f7;
        }

        #ttrxHeader {
            display: none !important;
        }
    </style>
<?php
if ($is_guest)
    alert('회원만 이용하실 수 있습니다.');

if (!chk_captcha()) {
    alert('자동등록방지 숫자가 틀렸습니다.');
}

$recv_list = explode(',', trim($_POST['me_recv_mb_id']));
$str_nick_list = '';
$msg = '';
$error_list = array();
$member_list = array();
for ($i = 0; $i < count($recv_list); $i++) {
    $row = sql_fetch(" select mb_id, mb_nick, mb_open, mb_leave_date, mb_intercept_date from {$g5['member_table']} where mb_id = '{$recv_list[$i]}' ");
    if ($row) {
        //if ($is_admin || ($row['mb_open'] && (!$row['mb_leave_date'] || !$row['mb_intercept_date']))) {
        if ($is_admin || (!$row['mb_leave_date'] || !$row['mb_intercept_date'])) {
            $member_list['id'][] = $row['mb_id'];
            $member_list['nick'][] = $row['mb_nick'];
        } else {
            $error_list[] = $recv_list[$i];
        }
    }
    /*
    // 관리자가 아니면서
    // 가입된 회원이 아니거나 정보공개를 하지 않았거나 탈퇴한 회원이거나 차단된 회원에게 쪽지를 보내는것은 에러
    if ((!$row['mb_id'] || !$row['mb_open'] || $row['mb_leave_date'] || $row['mb_intercept_date']) && !$is_admin) {
        $error_list[]   = $recv_list[$i];
    } else {
        $member_list['id'][]   = $row['mb_id'];
        $member_list['nick'][] = $row['mb_nick'];
    }
    */
}

$error_msg = implode(",", $error_list);

if ($error_msg && !$is_admin)
    alert("회원아이디 '{$error_msg}' 은(는) 존재(또는 정보공개)하지 않는 회원아이디 이거나 탈퇴, 접근차단된 회원아이디 입니다.\\n쪽지를 발송하지 않았습니다.");

if (!$is_admin) {
    if (count($member_list['id'])) {
        $point = (int)$config['cf_memo_send_point'] * count($member_list['id']);
        if ($point) {
            if ($member['mb_point'] - $point < 0) {
                alert('보유하신 포인트(' . number_format($member['mb_point']) . '점)가 모자라서 쪽지를 보낼 수 없습니다.');
            }
        }
    }
}

for ($i = 0; $i < count($member_list['id']); $i++) {
    $tmp_row = sql_fetch(" select max(me_id) as max_me_id from {$g5['memo_table']} ");
    $me_id = $tmp_row['max_me_id'] + 1;

    $recv_mb_id = $member_list['id'][$i];
    $recv_mb_nick = get_text($member_list['nick'][$i]);

    // 쪽지 INSERT
    $sql = " insert into {$g5['memo_table']} ( me_id, me_recv_mb_id, me_send_mb_id, me_send_datetime, me_memo, me_read_datetime ) values ( '$me_id', '$recv_mb_id', '{$member['mb_id']}', '" . G5_TIME_YMDHIS . "', '{$_POST['me_memo']}', '0000-00-00 00:00:00' ) ";
    sql_query($sql);

    // 실시간 쪽지 알림 기능
    $sql = " update {$g5['member_table']} set mb_memo_call = '{$member['mb_id']}' where mb_id = '$recv_mb_id' ";
    sql_query($sql);

    if (!$is_admin) {
        insert_point($member['mb_id'], (int)$config['cf_memo_send_point'] * (-1), $recv_mb_nick . '(' . $recv_mb_id . ')님께 쪽지 발송', '@memo', $recv_mb_id, $me_id);
    }
}

if ($member_list) {
    $str_nick_list = implode(',', $member_list['id']);

    include_once(G5_LIB_PATH . '/icode.sms.lib.php');
    include_once(G5_PLUGIN_PATH . '/sms5/sms5.lib.php');
    include_once(ALLV_UTIL_PATH . '/BizMsgKakao.php');
    //include_once('../util/BizMsgKakao.php');
    //define('ALLV_UTIL_PATH',	G5_PATH.'/'.G5_UTIL_DIR);

    $SMS = new SMS; // SMS 연결
    $SMS->SMS_con($config['cf_icode_server_ip'], $config['cf_icode_id'], $config['cf_icode_pw'], $config['cf_icode_server_port']);

    for ($s = 0; $s < count($member_list['id']); $s++) {
        $recv_mb_id = $member_list['id'][$s];
        //$sql = "SELECT * FROM ".$g5['member_table']." WHERE mb_id='".$recv_mb_id."' ";
        $row = sql_fetch("SELECT * FROM " . $g5['member_table'] . " WHERE mb_id='" . $recv_mb_id . "' ");
        //print_r($row);
        $recv_number = str_replace("-", "", $row['mb_hp']);
        $send_number = $sms5['cf_phone'];
        $cmt = "작업에 대한 문의 내용이 도착했습니다. 쪽지함을 확인해주세요. -올보이스-";
        $sms_content = iconv_euckr($cmt);

        $cmid = date("YmdHis") . $s;

        // 템플릿 변경 2020.04.24
        $biz_sql = "INSERT INTO BIZ_MSG (MSG_TYPE, CMID, REQUEST_TIME, SEND_TIME, DEST_PHONE, SEND_PHONE,  MSG_BODY, TEMPLATE_CODE, SENDER_KEY, NATION_CODE, ATTACHED_FILE, RE_TYPE, RE_BODY) VALUES (6, $cmid, NOW(), NOW(), '" . $recv_number . "', '" . $send_number . "', '" . $cmt . "', 'bizp_2019091022381916788455088', '" . SENDER_KEY . "', '82', 'kakao_button.json', 'SMS', '" . $cmt . "')";

        // 쪽지 수신(2)(200413 수정)
        $bizKakao = new BizMsgKakao;
        $bizKakao->insertBizMsgToDB($recv_number, $send_number, biz_msg_type::biz_msg_code_1);


        //$biz_sql = "INSERT INTO BIZ_MSG (MSG_TYPE, CMID, REQUEST_TIME, SEND_TIME, DEST_PHONE, SEND_PHONE,  MSG_BODY, TEMPLATE_CODE, SENDER_KEY, NATION_CODE, ATTACHED_FILE, RE_TYPE, RE_BODY) VALUES (6, '".date("YmdHis")."', NOW(), NOW(), '".$recv_number."', '".$send_number."', '".$cmt."', 'bizp_2019091022381916788455088', '".SENDER_KEY."', '82', 'kakao_button.json', 'SMS', '".$cmt."')";
        //echo $biz_sql;
        //sql_query($biz_sql);

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

            sql_query("insert into {$g5['sms5_write_table']} set wr_no='$wr_no', wr_renum=0, wr_reply='$send_number', wr_message='$cmt', wr_booking='0000-00-00 00:00:00', wr_total='1', wr_datetime='" . G5_TIME_YMDHIS . "'");

            $wr_success = 0;
            $wr_failure = 0;
            $count = 0;
//print_r($SMS->Result);
            foreach ($SMS->Result as $res) {
                list($phone, $code) = explode(":", $res);
//print_r($code);
                if (substr($code, 0, 5) == "Error") {
                    $hs_code = substr($code, 6, 2);

                    switch ($hs_code) {
                        case '02':     // "02:형식오류"
                            $hs_memo = "형식이 잘못되어 전송이 실패하였습니다.";
                            break;
                        case '23':     // "23:인증실패,데이터오류,전송날짜오류"
                            $hs_memo = "데이터를 다시 확인해 주시기바랍니다.";
                            break;
                        case '97':     // "97:잔여코인부족"
                            $hs_memo = "잔여코인이 부족합니다.";
                            break;
                        case '98':     // "98:사용기간만료"
                            $hs_memo = "사용기간이 만료되었습니다.";
                            break;
                        case '99':     // "99:인증실패"
                            $hs_memo = "인증 받지 못하였습니다. 계정을 다시 확인해 주세요.";
                            break;
                        default:     // "미 확인 오류"
                            $hs_memo = "알 수 없는 오류로 전송이 실패하였습니다.";
                            break;
                    }
                    $wr_failure++;
                    $hs_flag = 0;
                } else {
                    $hs_code = $code;
                    $hs_memo = get_hp($phone, 1) . "로 전송했습니다.";//print_r($hs_memo);
                    $wr_success++;
                    $hs_flag = 1;
                }

                //$row = array_shift($list);
                //$row['bk_hp'] = get_hp($row['bk_hp'], 1);

                $log = array_shift($SMS->Log);
                $log = @iconv('euc-kr', 'utf-8', $log);
//echo "insert into {$g5['sms5_history_table']} set wr_no='$wr_no', wr_renum=0, bg_no='0', mb_id='{$row['mb_id']}', bk_no='0', hs_name='', hs_hp='{$recv_number}', hs_datetime='".G5_TIME_YMDHIS."', hs_flag='$hs_flag', hs_code='$hs_code', hs_memo='".addslashes($hs_memo)."', hs_log='".addslashes($log)."'";
                sql_query("insert into {$g5['sms5_history_table']} set wr_no='$wr_no', wr_renum=0, bg_no='0', mb_id='{$row['mb_id']}', bk_no='0', hs_name='', hs_hp='{$recv_number}', hs_datetime='" . G5_TIME_YMDHIS . "', hs_flag='$hs_flag', hs_code='$hs_code', hs_memo='" . addslashes($hs_memo) . "', hs_log='" . addslashes($log) . "'", false);
            }
            $SMS->Init(); // 보관하고 있던 결과값을 지웁니다.

            sql_query("update {$g5['sms5_write_table']} set wr_success='$wr_success', wr_failure='$wr_failure', wr_memo='$str_serialize' where wr_no='$wr_no' and wr_renum=0");
        }
    }
    //$SMS->Init(); // 보관하고 있던 결과값을 지웁니다.
//exit;
    alert($str_nick_list . " 님께 쪽지를 전달하였습니다.", G5_HTTP_BBS_URL . "/memo.php?kind=send", false);
} else {
    alert("회원아이디 오류 같습니다.", G5_HTTP_BBS_URL . "/memo_form.php", false);
}
?>