<?php
$sub_menu = "300510";
include_once('./_common.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

auth_check($auth[$sub_menu], 'w');

if(!$pr_id)
	alert('프로젝트 고유번호가 넘어오지 않았습니다.', 'pr_list.php');

$sql = " select * from AV_PR where pr_id = '{$pr_id}' ";
$pr = sql_fetch($sql);

$html_title = '캐릭터';
if ($w == ''){
    $html_title .= ' 생성';
	$row['pr_use'] = 1;
}else if ($w == 'u')  {
    $html_title .= ' 수정';
    $sql = " select * from AV_CR where cr_id = '{$cr_id}' ";
    $row = sql_fetch($sql);
} else
    alert('w 값이 제대로 넘어오지 않았습니다.');

$g5['title'] = $html_title;
include_once('../admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');
?>

<form name="fpoll" id="fpoll" action="./cr_form_update.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="pr_id" value="<?php echo $pr_id ?>">
<input type="hidden" name="cr_id" value="<?php echo $cr_id ?>">

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
        <th scope="row"><label>프로젝트</label></th>
        <td><?php echo get_text($pr['pr_subject'])?></td>
    </tr>
    <tr>
        <th scope="row"><label>캐릭터명</label></th>
        <td><input type="text" name="cr_subject" value="<?php echo $row['cr_subject'] ?>" required class="required frm_input" size="80" ></td>
    </tr>

	<tr>
        <th scope="row"><label>캐릭터설명</label></th>
		<td>
			<textarea name="cr_info" required class="required frm_input"><?php echo $row['cr_info'] ?></textarea>
		</td>
    </tr>

		<?
		for ($i=0; $i<1; $i++) {
		?>
		 <tr>
			<th scope="row">캐릭터이미지</th>
			<td>
				<input type="file" name="bf_file[<?=$i?>]" id="file" class="frm_input" >
				<?php
				$thumb = get_app_thumbnail("AV_CR", $row['cr_id'], 400, 400, $i);
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
        <td><?php echo $row['cr_regdate']; ?></td>
    </tr>
    <?php } ?>
    </tbody>
    </table>

</div>

<div class="btn_fixed_top ">
    <a href="./cr_list.php?<?php echo $qstr ?>&pr_id=<?php echo $pr_id?>" class="btn_02 btn">목록</a>
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
