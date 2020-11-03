<?php
include_once('../shop/_common.php');
include_once('../manager/voiceProjectManager.php');
include_once('../util/BizMsgKakao.php');

$chatroom_id = $_POST['chatroom_id'];
$chat_type = $_POST['chat_type'];
$mb_id = $_POST['mb_id'];
$message = $_POST['message'];
$projectId = "";
$projectOrderId = "";
$filePath = "";

if ('3' == $chat_type) {

    // 보이스 프로젝트 등록 후 처리.

    $voiceProjectMngr = new voiceProjectManager();
    $projectInfo = $voiceProjectMngr->addVoiceProject2($chatroom_id, $mb_id, $message);


    $projectId = $projectInfo['project_id'];
    $projectOrderId = $projectInfo['project_order_id'];

} else if ('2' == $chat_type) {

    $jsonData = stripslashes($message);
    $jsonData = json_decode($jsonData);
    $filePath = $jsonData->filePath;
}

$members = array();
$sql = "SELECT mb_id FROM ALLV_CHAT_MEMBER WHERE chatroom_id = '$chatroom_id'";

$members = sql_query($sql);
$to_mb_id = "";

for ($i = 0; $row = sql_fetch_array($members); $i++) {
    // $row['mb_id']

    // $read_yn = ($row['mb_id'] == $mb_id) ? 1 : 0;
    if ($row['mb_id'] == $mb_id) {
        $read_yn = 1;
    } else {
        $read_yn = 0;
        $to_mb_id = $row['mb_id'];
    }

    $sqlMessage = "INSERT INTO ALLV_CHAT_MESSAGE(chatroom_id, chat_type, mb_id, message, read_yn, read_yn_mb_id, chat_date, project_id, project_order_id, file_path)
        VALUES('$chatroom_id', $chat_type, '$mb_id', '$message', $read_yn,  '{$row['mb_id']}', NOw(), '$projectId', '$projectOrderId', '$filePath')";

    sql_query($sqlMessage);
}


// $sql = "SELECT mb_gubun, mb_name, mb_hp FROM " . $g5['member_table'] . " WHERE mb_id = '$to_mb_id' ";

$sql = "SELECT a.mb_gubun, a.mb_name, a.mb_hp, b.mb_name AS my_name FROM g5_member AS a
        JOIN (
            SELECT mb_name FROM g5_member WHERE g5_member.mb_id = '$mb_id'
        ) AS b WHERE mb_id = '$to_mb_id'";

$result = sql_fetch($sql);

if ($result) {
    $recv_number = str_replace("-","",$result['mb_hp']);
    $send_number = $sms5['cf_phone'];
    $repMessage = str_replace('<br />', '\r\n', $message);
    if ($result['mb_gubun'] == 3) {
        $bizKakao = new BizMsgKakao();
        $bizKakao->insertInboxMessageBizMsgToDB($recv_number, $send_number, biz_msg_type::biz_msg_code_13, $result['my_name'], $repMessage);
    }
    else  {
        $bizKakao = new BizMsgKakao();
        $bizKakao->insertInboxMessageBizMsgToDB($recv_number, $send_number, biz_msg_type::biz_msg_code_12, $result['my_name'], $repMessage);
    }
}

// die($sql);




