<?php
include_once('./_common.php');

$data = array();

if($cn_id && $vote_email){

	$sql = " select * from AV_VOTE where cn_id = '$cn_id' and vote_email = '$vote_email' ";
	$row = sql_fetch($sql);

	if($row['vote_email']){
		$data['result'] = 2;
	}else{

		$sql = " select * from AV_CN where cn_id = '{$cn_id}' ";
		$cn = sql_fetch($sql);

		$sql = "insert into AV_VOTE set pr_id = '".$cn['pr_id']."', cr_id = '".$cn['cr_id']."', cn_id = '$cn_id', vote_regdate='".G5_TIME_YMDHIS."', vote_email = '$vote_email' ";
		sql_query($sql);

		$sql = "update AV_CN set cn_vote = cn_vote+1 where cn_id = '{$cn_id}' ";
		sql_query($sql);

		$data['result'] = 1;
	}
}else{
	$data['result'] = 3;
}

echo json_encode($data);
?>