<?php
include_once('../shop/_common.php');

/*
$upload_dir = G5_DATA_PATH . '/item/file';
if (!is_dir($upload_dir)) {
    @mkdir($upload_dir, G5_DIR_PERMISSION);
    @chmod($upload_dir, G5_DIR_PERMISSION);
}

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
    //$path = "uploads/"; //set your folder path
    $path = $upload_dir;
    //set the valid file extensions
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "GIF", "JPG", "PNG", "doc", "txt", "docx", "pdf", "xls", "xlsx"); //add the formats you want to upload
    $name = $_FILES['attachment']['name']; //get the name of the file

    $size = $_FILES['attachment']['size']; //get the size of the file
    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 2098888) { // check if the file size is more than 2 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['attachment']['tmp_name'];

                // move_uploaded_file($_FILES['it_7']['tmp_name'], $dest_path);
                // chmod($dest_path, G5_FILE_PERMISSION);

                //if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                if (move_uploaded_file($_FILES['attachment']['tmp_name'], $path)) {
                    echo "File uploaded successfully!!";
                } else {
                    echo $path.$tmp;
                }
            } else {
                echo "File size max 2 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }

    echo $path.$tmp;

    exit;
}
*/

$mbId = $_POST['mb_id'];


    //$message = $_POST['message'];

$image_regex = "/(\.(gif|jpe?g|png))$/i";
$txt_regex = "/(\.(gif|jpe?g|png|txt|pdf|pptx?|xlsx?|hwp|docx?|mp3|wav|ogg|m4a|flac|wmv|wma|aac|asx|asf|wmv|wma|mpg|mpeg|mov|avi|mp4))$/i";
$video_regex ="/(\.(asx|asf|wmv|wma|mpg|mpeg|mov|avi|mp3))$/i";

$upload_dir = G5_DATA_PATH . '/chatroom/'. $mbId;
if (!is_dir($upload_dir)) {
    @mkdir($upload_dir, G5_DIR_PERMISSION);
    @chmod($upload_dir, G5_DIR_PERMISSION);
}
$upload_dir .= $it_id;

// 대본파일 업로드                it_7                = '$it_7',
if (isset($_FILES['attachment']) && is_uploaded_file($_FILES['attachment']['tmp_name'])) {
    if (!preg_match($txt_regex, $_FILES['attachment']['name'])) {
        alert($_FILES['attachment']['name'] . '은(는) 이미지 혹은 문서 파일이 아닙니다.');
    }
//echo "test1";
    if (preg_match($txt_regex, $_FILES['attachment']['name'])) {
        @mkdir($upload_dir, G5_DIR_PERMISSION);
        @chmod($upload_dir, G5_DIR_PERMISSION);

        //if ($_POST['del_file'])
        //	@unlink($upload_dir.'/'.$_POST['del_file']);

        $ext = end(explode('.', $_FILES['attachment']['name']));

        //$dest_file = $_FILES['attachment']['name'] . $it_id . '.' . $ext;
        $times = mktime();
        $date = date("Ymdhis", $times);  // 초 -> 년-월-일 시:분:초  변환

        $dest_file = $date.'_'.$mbId.'_'.$_FILES['attachment']['name'];
        $dest_file = preg_replace("/\s+/", "", $dest_file);
        $filePath = $dest_file;
        $dest_path = $upload_dir . '/' . $dest_file;

        move_uploaded_file($_FILES['attachment']['tmp_name'], $dest_path);
        chmod($dest_path, G5_FILE_PERMISSION);

        //$sql_common .= " ,it_7 = '" . $dest_file . "' ,it_8 = '" . $_FILES['it_7']['name'] . "' ";

        echo $dest_file;
        exit;
    }
}
