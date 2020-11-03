<?php
include_once('./_common.php');

// clean the output buffer
ob_end_clean();

$qry = "SELECT * FROM ".$g5['g5_shop_order_voice_table']." WHERE ov_id='".$_REQUEST['ov_id']."'";
$file = sql_fetch($qry);

$filepath = G5_DATA_PATH.'/order/'.$file['od_id'].'/'.$file['ov_voice'];
$original = urlencode($file['ov_voice_name']);

if(preg_match("/msie/i", $_SERVER['HTTP_USER_AGENT']) && preg_match("/5\.5/", $_SERVER['HTTP_USER_AGENT'])) {
    header("content-type: doesn/matter");
    header("content-length: ".filesize("$filepath"));
    header("content-disposition: attachment; filename=\"$original\"");
    header("content-transfer-encoding: binary");
} else if (preg_match("/Firefox/i", $_SERVER['HTTP_USER_AGENT'])){
    header("content-type: file/unknown");
    header("content-length: ".filesize("$filepath"));
    header("content-disposition: attachment; filename=\"".basename($file['ov_voice_name'])."\"");
    header("content-description: php generated data");
} else {
    header("content-type: file/unknown");
    header("content-length: ".filesize("$filepath"));
    header("content-disposition: attachment; filename=\"$original\"");
    header("content-description: php generated data");
}
header("pragma: no-cache");
header("expires: 0");
flush();

$fp = fopen($filepath, 'rb');

// 4.00 대체
// 서버부하를 줄이려면 print 나 echo 또는 while 문을 이용한 방법보다는 이방법이...
//if (!fpassthru($fp)) {
//    fclose($fp);
//}

$download_rate = 10;

while(!feof($fp)) {
    //echo fread($fp, 100*1024);
    /*
    echo fread($fp, 100*1024);
    flush();
    */

    print fread($fp, round($download_rate * 1024));
    flush();
    usleep(1000);
}
fclose ($fp);
flush();
?>