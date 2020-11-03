<?php

include_once('./_common.php');
include_once(ALLV_UTIL_PATH . '/BizMsgKakao.php');

define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_LIB_PATH.'/mailer.lib.php');


//$mailTo		=	"ad@dadastudio.com";
//$mailTo		=	"ad@dadastudio.com";
// if($_REQUEST["lan"] == "en"){
// 	$mailTo		=	$config["cf_admin_email_en"];
// }else{
// 	$mailTo		=	$config["cf_admin_email"];
// }

$mailTo		=	"dahee0506@naver.com";
$mailFrom	=	"allvoice@naver.com";

$recv_mb_id   = "admin";
$row = sql_fetch ( "SELECT * FROM ".$g5['member_table']." WHERE mb_id='".$recv_mb_id."' " );

$mailTo		=	$row['mb_email'];
$mailFrom	=	$row['mb_email'];

//$mailSubject = $_POST[eTitle];
$mailSubject = "후반작업 신청메일";

$mailCont = "
이름 : ".$_POST['it_name']."<br />
연락처 : ".$_POST['it_phone']."<br />
녹음파일사용용도 : ".$_POST['it_purpose'];

$txt_regex = "/(\.(gif|jpe?g|png|txt|pdf|pptx?|xlsx?|hwp|docx?))$/i";
$upload_dir = G5_DATA_PATH.'/after/';
if( !is_dir($upload_dir) ){
	@mkdir($upload_dir, G5_DIR_PERMISSION);
	@chmod($upload_dir, G5_DIR_PERMISSION);
}
$upload_dir .= date("Ymd");

// 대본파일 업로드                it_file                = '$it_file',
if (isset($_FILES['it_file']) && is_uploaded_file($_FILES['it_file']['tmp_name'])) {
	if (!preg_match($txt_regex, $_FILES['it_file']['name'])) {
		alert($_FILES['it_file']['name'] . '은(는) 이미지 혹은 문서 파일이 아닙니다.');
	}
//echo "test1";
	if (preg_match($txt_regex, $_FILES['it_file']['name'])) {
		@mkdir($upload_dir, G5_DIR_PERMISSION);
		@chmod($upload_dir, G5_DIR_PERMISSION);

		// 회원 이미지 삭제
		//if ($_POST['del_file'])
		//	@unlink($upload_dir.'/'.$_POST['del_file']);

		$ext = end(explode('.', $_FILES['it_file']['name'])); 
		
		$dest_file = 'it_file_'.time().'.'.$ext;
		$dest_path = $upload_dir.'/'.$dest_file;
		
		move_uploaded_file($_FILES['it_file']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);

	}
}

$mailHeader = "From: $mailFrom\r\n";
$mailHeader .= "MIME-Version: 1.0\r\n";
$mailHeader .= "Content-type: text/html; charset=utf-8\r\n";

mailer("ALLVOICE", $mailFrom, $mailTo, $mailSubject, $mailCont, 1);


$qry = "INSERT INTO ".$g5['after_table']." ( co_subject, co_mobile, co_file, co_name, co_request_form, co_date ) 
        VALUES ( '".$_POST['it_purpose']."', '".$_POST['it_phone']."', '".$dest_file."', '".$_POST['it_name']."', '".$_POST['it_request_form']."', now() )";
sql_query($qry);

$recv_number = str_replace("-","",$row['mb_hp']);
$send_number = $sms5['cf_phone'];
$cmt = "후반작업 의뢰가 등록되었습니다. 확인해주세요. -올보이스-";
$sms_content = iconv_euckr( $cmt );

// $bizKakao = new BizMsgKakao;
// $bizKakao->insertBizMsgToDB($recv_number, $send_number, biz_msg_type::biz_msg_code_1);


$biz_sql = "INSERT INTO BIZ_MSG (MSG_TYPE, CMID, REQUEST_TIME, SEND_TIME, DEST_PHONE, SEND_PHONE,  MSG_BODY, TEMPLATE_CODE, SENDER_KEY, NATION_CODE, ATTACHED_FILE, RE_TYPE, RE_BODY) VALUES (6, '".date("YmdHis", time()+1)."', NOW(), NOW(), '".$recv_number."', '".$send_number."', '".$cmt."', 'bizp_2019082914494022317576528', '".SENDER_KEY."', '82', 'kakao_button.json', 'SMS', '".$cmt."')";
//echo $biz_sql;
sql_query( $biz_sql );

// admin 계정 연락처만 보낼수 있어서 임시로 작업
$recv_number2 = "01024452055";
$biz_sql2 = "INSERT INTO BIZ_MSG (MSG_TYPE, CMID, REQUEST_TIME, SEND_TIME, DEST_PHONE, SEND_PHONE,  MSG_BODY, TEMPLATE_CODE, SENDER_KEY, NATION_CODE, ATTACHED_FILE, RE_TYPE, RE_BODY) VALUES (6, '".date("YmdHis", time()+2)."', NOW(), NOW(), '".$recv_number2."', '".$send_number."', '".$cmt."', 'bizp_2019082914494022317576528', '".SENDER_KEY."', '82', 'kakao_button.json', 'SMS', '".$cmt."')";
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
?>

<!doctype html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<meta content="IE=edge" http-equiv="X-UA-Compatible">
</head>
<body>

<?php 
//echo $mailSubject;
?>
<br /><br /><br /><br />
<?php 
//echo $mailCont;
?>

<script type="text/javascript">
<?php
	echo "alert('신청이 완료되었습니다.');";
	//echo "history.back()";
	echo "location.href='/shop'";
?>
</script>
</body>
</html>
