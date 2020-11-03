<?php
include_once('../shop/_common.php');

$chatroom_id = $_POST['chatroom_id'];
$mb_id = $_POST['mb_id'];

$sql = "UPDATE ALLV_CHAT_MESSAGE SET read_yn = '1' WHERE chatroom_id = '$chatroom_id' AND read_yn_mb_id = '$mb_id'";
sql_query($sql);


