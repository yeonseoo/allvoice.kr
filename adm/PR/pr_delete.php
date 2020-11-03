<?php
$sub_menu = "200900";
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], 'd');

check_admin_token();

$count = count($_POST['chk']);

function delete_app_thumbnail($bo_table, $file)
{
    if(!$bo_table || !$file)
        return;

    $fn = preg_replace("/\.[^\.]+$/i", "", basename($file));
    $files = glob(G5_DATA_PATH.'/'.$bo_table.'/thumb-'.$fn.'*');
    if (is_array($files)) {
        foreach ($files as $filename)
            unlink($filename);
    }
}

if(!$count)
    alert('삭제할 프로젝트를 1개이상 선택해 주세요.');

for($i=0; $i<$count; $i++) {
    $pr_id = $_POST['chk'][$i];

    $sql = " delete from AV_PR where pr_id = '$pr_id' ";
    sql_query($sql);

		// 업로드된 파일이 있다면 파일삭제
		$bo_table = "AV_PR";
		$row['wr_id'] = $pr_id;
        $sql2 = " select * from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '{$row['wr_id']}' ";
        $result2 = sql_query($sql2);
        while ($row2 = sql_fetch_array($result2)) {
            @unlink(G5_DATA_PATH.'/'.$bo_table.'/'.$row2['bf_file']);
            // 썸네일삭제
            if(preg_match("/\.({$config['cf_image_extension']})$/i", $row2['bf_file'])) {
                delete_app_thumbnail($bo_table, $row2['bf_file']);
            }
        } 
        // 파일테이블 행 삭제
        sql_query(" delete from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '{$row['wr_id']}' ");
}

goto_url('./pr_list.php?'.$qstr);
?>