<?php
$sub_menu = '600010';
include_once('./_common.php'); 

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


$sql_common = " pr_subject = '{$_POST['pr_subject']}', 
				pr_info = '{$_POST['pr_info']}',
				pr_use = '{$_POST['pr_use']}',
				fr_date = '{$_POST['fr_date']}',
				to_date = '{$_POST['to_date']}' ";

if($w == ""){

	sql_query(" insert into AV_PR set pr_regdate = '".G5_TIME_YMDHIS."', {$sql_common} ");
	$pr_id = sql_insert_id();

}
else if ($w == "u")
{
    $sql = " update AV_PR set $sql_common where pr_id = '$pr_id' ";
    sql_query($sql);
}
else if ($w == "d")
{

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

if($w == "" || $w == "u"){
	////////////////////////////////////////////////////////////파일 입력 ////////////////////////////////////////////////////////////////
	$bo_table = "AV_PR";
	$wr_id = $pr_id;

	// 디렉토리가 없다면 생성합니다. (퍼미션도 변경하구요.)
	@mkdir(G5_DATA_PATH.'/'.$bo_table, G5_DIR_PERMISSION);
	@chmod(G5_DATA_PATH.'/'.$bo_table, G5_DIR_PERMISSION);

	$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));

	// 가변 파일 업로드
	$file_upload_msg = '';
	$upload = array();

	//echo count($_FILES['bf_file']['name']);

	//for ($i=0; $i<count($_FILES['bf_file']['name']); $i++) { 
	for ($i=0; $i<9; $i++) { 

		$upload[$i]['file']     = '';
		$upload[$i]['source']   = '';
		$upload[$i]['filesize'] = 0;
		$upload[$i]['image']    = array();
		$upload[$i]['image'][0] = '';
		$upload[$i]['image'][1] = '';
		$upload[$i]['image'][2] = '';

		// 삭제에 체크가 되어있다면 파일을 삭제합니다.
		if (isset($_POST['bf_file_del'][$i]) && $_POST['bf_file_del'][$i]) {
			$upload[$i]['del_check'] = true;

			$row = sql_fetch(" select bf_file from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bf_no = '{$i}' ");
			@unlink(G5_DATA_PATH.'/'.$bo_table.'/'.$row['bf_file']);
			// 썸네일삭제
			if(preg_match("/\.({$config['cf_image_extension']})$/i", $row['bf_file'])) {
				delete_app_thumbnail($bo_table, $row['bf_file']);
			}
		}
		else
			$upload[$i]['del_check'] = false;

		$tmp_file  = $_FILES['bf_file']['tmp_name'][$i]; //echo $tmp_file;
		$filesize  = $_FILES['bf_file']['size'][$i];
		$filename  = $_FILES['bf_file']['name'][$i];
		$filename  = get_safe_filename($filename);

		// 서버에 설정된 값보다 큰파일을 업로드 한다면
		if ($filename) {
			if ($_FILES['bf_file']['error'][$i] == 1) {
				$file_upload_msg .= '\"'.$filename.'\" 파일의 용량이 서버에 설정('.$upload_max_filesize.')된 값보다 크므로 업로드 할 수 없습니다.\\n';
				continue;
			}
			else if ($_FILES['bf_file']['error'][$i] != 0) {
				$file_upload_msg .= '\"'.$filename.'\" 파일이 정상적으로 업로드 되지 않았습니다.\\n';
				continue;
			}
		}

		if (is_uploaded_file($tmp_file)) {
			//echo "111111";

			//=================================================================\
			// 090714
			// 이미지나 플래시 파일에 악성코드를 심어 업로드 하는 경우를 방지
			// 에러메세지는 출력하지 않는다.
			//-----------------------------------------------------------------
			$timg = @getimagesize($tmp_file);
			// image type
			if ( preg_match("/\.({$config['cf_image_extension']})$/i", $filename) ||
				 preg_match("/\.({$config['cf_flash_extension']})$/i", $filename) ) {
				if ($timg['2'] < 1 || $timg['2'] > 16)
					continue;
			}
			//=================================================================

			$upload[$i]['image'] = $timg;

			//echo "22222";

			// 4.00.11 - 글답변에서 파일 업로드시 원글의 파일이 삭제되는 오류를 수정
			if ($w == 'u') {
				// 존재하는 파일이 있다면 삭제합니다.
				$row = sql_fetch(" select bf_file from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_no = '$i' ");
				@unlink(G5_DATA_PATH.'/'.$bo_table.'/'.$row['bf_file']);
				// 이미지파일이면 썸네일삭제
				if(preg_match("/\.({$config['cf_image_extension']})$/i", $row['bf_file'])) {
					delete_board_thumbnail($bo_table, $row['bf_file']);
				}
			}

			//echo "3333";

			// 프로그램 원래 파일명
			$upload[$i]['source'] = $filename;
			$upload[$i]['filesize'] = $filesize;

			// 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
			$filename = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);

			shuffle($chars_array);
			$shuffle = implode('', $chars_array);

			// 첨부파일 첨부시 첨부파일명에 공백이 포함되어 있으면 일부 PC에서 보이지 않거나 다운로드 되지 않는 현상이 있습니다. (길상여의 님 090925)
			$upload[$i]['file'] = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.replace_filename($filename);

			$dest_file = G5_DATA_PATH.'/'.$bo_table.'/'.$upload[$i]['file'];

			//echo $dest_file;

			// 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
			$error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES['bf_file']['error'][$i]);

			// 올라간 파일의 퍼미션을 변경합니다.
			chmod($dest_file, G5_FILE_PERMISSION);
		}
	}

	// 나중에 테이블에 저장하는 이유는 $wr_id 값을 저장해야 하기 때문입니다.
	for ($i=0; $i<count($upload); $i++)
	{
		if (!get_magic_quotes_gpc()) {
			$upload[$i]['source'] = addslashes($upload[$i]['source']);
		}

		$row = sql_fetch(" select count(*) as cnt from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bf_no = '{$i}' ");
		if ($row['cnt'])
		{
			// 삭제에 체크가 있거나 파일이 있다면 업데이트를 합니다.
			// 그렇지 않다면 내용만 업데이트 합니다.
			if ($upload[$i]['del_check'] || $upload[$i]['file'])
			{
				$sql = " update {$g5['board_file_table']}
							set bf_source = '{$upload[$i]['source']}',
								 bf_file = '{$upload[$i]['file']}',
								 bf_content = '{$bf_content[$i]}',
								 bf_filesize = '{$upload[$i]['filesize']}',
								 bf_width = '{$upload[$i]['image']['0']}',
								 bf_height = '{$upload[$i]['image']['1']}',
								 bf_type = '{$upload[$i]['image']['2']}',
								 bf_datetime = '".G5_TIME_YMDHIS."'
						  where bo_table = '{$bo_table}'
									and wr_id = '{$wr_id}'
									and bf_no = '{$i}' ";
				sql_query($sql);
			}
			else
			{
				$sql = " update {$g5['board_file_table']}
							set bf_content = '{$bf_content[$i]}'
							where bo_table = '{$bo_table}'
									  and wr_id = '{$wr_id}'
									  and bf_no = '{$i}' ";
				sql_query($sql);
			}
		}
		else
		{
			$sql = " insert into {$g5['board_file_table']}
						set bo_table = '{$bo_table}',
							 wr_id = '{$wr_id}',
							 bf_no = '{$i}',
							 bf_source = '{$upload[$i]['source']}',
							 bf_file = '{$upload[$i]['file']}',
							 bf_content = '{$bf_content[$i]}',
							 bf_download = 0,
							 bf_filesize = '{$upload[$i]['filesize']}',
							 bf_width = '{$upload[$i]['image']['0']}',
							 bf_height = '{$upload[$i]['image']['1']}',
							 bf_type = '{$upload[$i]['image']['2']}',
							 bf_datetime = '".G5_TIME_YMDHIS."' ";
			sql_query($sql);
		}
	}

	// 업로드된 파일 내용에서 가장 큰 번호를 얻어 거꾸로 확인해 가면서
	// 파일 정보가 없다면 테이블의 내용을 삭제합니다.
	$row = sql_fetch(" select max(bf_no) as max_bf_no from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ");
	for ($i=(int)$row['max_bf_no']; $i>=0; $i--)
	{
		$row2 = sql_fetch(" select bf_file from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bf_no = '{$i}' ");

		// 정보가 있다면 빠집니다.
		if ($row2['bf_file']) break;

		// 그렇지 않다면 정보를 삭제합니다.
		sql_query(" delete from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bf_no = '{$i}' ");
	} 
	//------------------------------------------------------------------------------
}

alert("처리되었습니다.","./pr_form.php?w=u&amp;pr_id=$pr_id");
?>
