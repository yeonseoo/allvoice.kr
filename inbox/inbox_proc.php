<?php
//include_once('./_common.php');
include_once('../shop/_common.php');
include_once ('./chatMngr.php');

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
$op_id  = $_GET['op_id'];
$lastno  = $_GET['lastno'];


$sql = " select * from inbox where op_id = '{$op_id}' and no > {$lastno} order by no asc";
$result = sql_query($sql);
$data = array();
//$lastno = 0;

for ($i = 0; $row = sql_fetch_array($result); $i++) {

    $data[] = $row;
    $lastno = $row['no'];
}

echo json_encode(array('lastno' => $lastno, 'data' => $data));
*/

$chatroomId = $_GET['chatroom_id'];
$type = $_GET['type'];
$mbId = $_GET['mb_id'];
$message_id = $_GET['message_id'];

if ('1' == $type) {

    $sql = "SELECT A.chatroom_id, A.message_id, A.chat_type, A.mb_id, A.message, A.read_yn, A.chat_date, A.project_id, A.project_order_id, A.file_Path, B.mb_name
            FROM ALLV_CHAT_MESSAGE as A LEFT JOIN g5_member as B On A.mb_id = B.mb_id
            WHERE chatroom_id = '$chatroomId' AND A.read_yn_mb_id = '$mbId' AND message_id > {$message_id} ORDER BY message_id asc";

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

}
else if ('2' == $type) {
    $chatMngr = new chatMngr();
    $data = $chatMngr->queryChatMembers($chatroomId);
    echo json_encode(array('data' => $data));
}
else {
    $chatMngr = new chatMngr();
    $data = $chatMngr->queryChatRoomList($mbId);

    echo json_encode(array('data' => $data));
}






