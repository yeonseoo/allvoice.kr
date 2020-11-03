<?php
//include_once('./_common.php');
include_once('../shop/_common.php');

// Insert message to Inbox.

// User
// Opponent

/*
CREATE TABLE IF NOT EXISTS `inbox` (
`no` int(11) NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL,
  `op_id` varchar(20) NOT NULL,
  `msg` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`no`),
  KEY `date` (`date`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
*/

/*
$mb_id = $_GET['mb_id'];

$sql = " select * from inbox where mb_id = '{$mb_id}' order by no asc";
$result = sql_query($sql);
$data = array();
//$lastno = 0;

for ($i = 0; $row = sql_fetch_array($result); $i++) {

    $data[] = $row;
    //$lastno = $row['no'];
}

echo json_encode(array('data' => $data));
*/

// chatroom_id
$chatroom_id = $_GET['chatroom_id'];
$mbId = $_GET['mb_id'];

// $sql = "SELECT chatroom_id, message_id, chat_type, mb_id, message, read_yn, chat_date FROM ALLV_CHAT_MESSAGE WHERE chatroom_id = '$chatroom_id' ORDER BY message_id asc";

$sql = "SELECT A.chatroom_id, A.message_id, A.chat_type, A.mb_id, B.mb_name, A.message, A.read_yn, A.chat_date, A.project_id, A.project_order_id, A.file_Path FROM ALLV_CHAT_MESSAGE AS A
        LEFT join g5_member as B on A.mb_id = B.mb_id
        WHERE A.chatroom_id = '$chatroom_id' AND A.read_yn_mb_id = '$mbId' ORDER BY message_id asc";

$result = sql_query($sql);
$data = array();

for ($i = 0; $row = sql_fetch_array($result); $i++) {

    $mb_dir = substr($row['mb_id'], 0, 2);
    $icon_url = G5_DATA_URL . '/member_image/' . $mb_dir . '/' . $row['mb_id'] . '.gif';
    $icon_url = is_file(G5_DATA_PATH . '/member_image/' . $mb_dir . '/' . $row['mb_id'] . '.gif') ? $icon_url : "../theme/basic/img/profileSample.jpg";

    $row['profile_img_src'] = $icon_url;

    $data[] = $row;
}

echo json_encode(array('data' => $data));



