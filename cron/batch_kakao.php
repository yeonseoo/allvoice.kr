#!/usr/local/php55/bin/php
<?php

include_once('/home/hosting_users/allvoice/www/common.php');
include_once('/home/hosting_users/allvoice/www/util/BizMsgKakao.php');

$sql = "select read_yn_mb_id, push_yn, b.mb_hp from ALLV_CHAT_MESSAGE as a
        left join
            ( select mb_id, mb_hp from g5_member ) as b on a.read_yn_mb_id = b.mb_id
        where a.push_yn = 0 and read_yn = 0 group by a.read_yn_mb_id;";
$result = sql_query($sql);

$members = array();

$send_number = $sms5['cf_phone'];
$bizMsg = new BizMsgKakao();

for ($i = 0; $row = sql_fetch_array($result); $i++) {

    /*
    $mb_dir = substr($row['mb_id'], 0, 2);
    $icon_url = G5_DATA_URL . '/member_image/' . $mb_dir . '/' . $row['mb_id'] . '.gif';
    $icon_url = is_file(G5_DATA_PATH . '/member_image/' . $mb_dir . '/' . $row[A'mb_id'] . '.gif') ? $icon_url : "../theme/basic/img/profileSample.jpg";

    $row['profile_img_src'] = $icon_url;

    $data[] = $row;
    */

    $mb_id = $row['read_yn_mb_id'];
    // $mb_hp = $row['mb_hp'];
    $recv_number = str_replace("-", "", $row['mb_hp']);

    $bizMsg->insertBizMsgToDB($recv_number, $send_number, biz_msg_type::biz_msg_code_11);

    $sqlUpdate = "UPDATE ALLV_CHAT_MESSAGE SET push_yn = 1 WHERE read_yn_mb_id = '$mb_id'";
    sql_query($sqlUpdate);
}



