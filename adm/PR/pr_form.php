<?php
$sub_menu = "300510";
include_once('./_common.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

auth_check($auth[$sub_menu], 'w');

$html_title = '프로젝트';
if ($w == ''){
    $html_title .= ' 생성';
	$row['pr_use'] = 1;
}else if ($w == 'u')  {
    $html_title .= ' 수정';
    $sql = " select * from AV_PR where pr_id = '{$pr_id}' ";
    $row = sql_fetch($sql);
} else
    alert('w 값이 제대로 넘어오지 않았습니다.');

$g5['title'] = $html_title;
include_once('../admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');
?>

<form name="fpoll" id="fpoll" action="./pr_form_update.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="pr_id" value="<?php echo $pr_id ?>">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">

<div class="tbl_frm01 tbl_wrap">

    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <tbody>
    <tr>
        <th scope="row"><label>프로젝트명</label></th>
        <!-- <td><input type="text" name="pr_subject" value="<?php echo $row['pr_subject'] ?>" required class="required frm_input" size="80" ></td> -->
		<td>
			<textarea name="pr_subject" required class="required frm_input" style="height:50px;"><?php echo $row['pr_subject'] ?></textarea>
		</td>
    </tr>

	<tr>
        <th scope="row"><label>프로젝트설명</label></th>
		<td>
			<textarea name="pr_info" required class="required frm_input"><?php echo $row['pr_info'] ?></textarea>
		</td>
    </tr>

	<tr>
        <th scope="row"><label>노출</label></th>
			<td>
                <?php echo help("노출여부에 체크를 해제하면 프론트에 노출되지 않습니다."); ?>
                <label><input type="checkbox" name="pr_use" value="1" id="pr_use" <?php echo ($row['pr_use']) ? "checked" : ""; ?>> 예</label>	
            </td>
    </tr>

	<tr>
        <th scope="row"><label>진행기간</label></th>
        <td>
		<input type="text" id="fr_date"  name="fr_date" value="<?php echo $row['fr_date']; ?>" class="frm_input required" required size="10" maxlength="10"> ~
		<input type="text" id="to_date"  name="to_date" value="<?php echo $row['to_date']; ?>" class="frm_input required" required size="10" maxlength="10">
		</td>
    </tr>

		<?
		for ($i=0; $i<1; $i++) {
		?>
		 <tr>
			<th scope="row">상단이미지<br>( 1920px X 556px )</th>
			<td>
				<input type="file" name="bf_file[<?=$i?>]" id="file" class="frm_input" >
				<?php
				$thumb = get_app_thumbnail("AV_PR", $row['pr_id'], 400, 400, $i);
				$pt_img = $thumb['src']; 
				if($pt_img){
				?>
				<div style="padding:10px;">
				<a href="<?=$thumb['ori']?>" target="_blank"><img class="img-responsive" src="<?=$thumb['ori']?>" alt="" style="width:400px;"></a>
				<br>
				<input type="checkbox" id="bf_file_del<?=$$i?>" name="bf_file_del[<?=$i?>]" value="1"> 
				<label for="bf_file_del<?=$i?>"> 파일 삭제</label>
				</div>
				<?php } ?>
			</td>
		</tr>
		<?php } ?>

    <?php if ($w == 'u') { ?>
    <tr>
        <th scope="row">등록일</th>
        <td><?php echo $row['pr_regdate']; ?></td>
    </tr>
    <?php } ?>
    </tbody>
    </table>

</div>

<div class="btn_fixed_top ">
    <a href="./pr_list.php?<?php echo $qstr ?>" class="btn_02 btn">목록</a>
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>

</form>

<script type="text/javascript">
<!--
$(function(){
    $("#fr_date, #to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99" });
});	
//-->
</script>

<?php
include_once('../admin.tail.php');
?>
