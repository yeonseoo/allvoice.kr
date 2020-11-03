<?php
$sub_menu = '400400';
include_once('./_common.php');
include_once('./admin.shop.lib.php');
include_once(G5_LIB_PATH.'/mailer.lib.php');
include_once('../../manager/voiceProjectManager.php');

auth_check($auth[$sub_menu], "w");

check_admin_token();

$sql = " select * from {$g5['g5_shop_order_table']} where od_id = '$od_id' ";
$od  = sql_fetch($sql);
if(!$od['od_id'])
    alert('주문자료가 존재하지 않습니다.');

// 결제정보 반영
$sql = " update {$g5['g5_shop_order_table']}
            set od_settle_case    = '{$_POST['od_status2']}'                
            where od_id = '$od_id' ";
$result = sql_query($sql);

// 주문정보
$info = get_order_info($od_id);
if(!$info)
    alert('주문자료가 존재하지 않습니다.');


goto_url("./orderform.php?od_id=$od_id&amp;$qstr");
?>
