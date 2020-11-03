<?php
$sub_menu = "300510";
include_once('./_common.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

auth_check($auth[$sub_menu], 'w');

if(!$cr_id)
	alert('고유번호가 넘어오지 않았습니다.', 'pr_list.php');

$sql = " select * from AV_CR where cr_id = '{$cr_id}' ";
$cr = sql_fetch($sql);

$sql = " select * from AV_PR where pr_id = '{$cr['pr_id']}' ";
$pr = sql_fetch($sql);

$html_title = '후보';
if ($w == ''){
    $html_title .= ' 생성';
	$row['pr_use'] = 1;
}else if ($w == 'u')  {
    $html_title .= ' 수정';
    $sql = " select * from AV_CN where cn_id = '{$cn_id}' ";
    $row = sql_fetch($sql);
} else
    alert('w 값이 제대로 넘어오지 않았습니다.');

$g5['title'] = $html_title;
include_once('../admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');
?>

<form name="fpoll" id="fpoll" action="./cn_form_update.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="pr_id" value="<?php echo $cr['pr_id'] ?>">
<input type="hidden" name="cr_id" value="<?php echo $cr_id ?>">

<input type="hidden" name="cn_id" value="<?php echo $cn_id ?>">

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
        <td><?php echo get_text($cr['cr_subject'])?></td>
    </tr>

	<tr>
        <th scope="row"><label>후보명</label></th>
        <td><input type="text" name="cn_name" value="<?php echo $row['cn_name'] ?>" required class="required frm_input" size="80" ></td>
    </tr>

		<?
		for ($i=0; $i<1; $i++) {
		?>
		 <tr>
			<th scope="row">음성파일</th>
			<td>
				<input type="file" name="bf_file[<?=$i?>]" id="file" class="frm_input" >
				<?php
				$file = sql_fetch("select * from g5_board_file where bo_table='AV_CN' and wr_id='{$cn_id}' and bf_no='{$i}' "); 
				$pt_img = $file['bf_file']; 
				if($pt_img){
				?>
				<div style="padding:10px;">
				<?=$file['bf_source']?>
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
        <td><?php echo $row['cn_regdate']; ?></td>
    </tr>
    <?php } ?>
    </tbody>
    </table>

</div>


<?php if ($w == 'u') { ?>
<h2 class="h2_frm">투표리스트</h2>
<div class="tbl_frm01 tbl_wrap">

    <table>
    <tbody>
	<?php
	$sql = " select * from AV_VOTE where (1) and cn_id = '{$cn_id}' order by vote_regdate desc ";
	$result = sql_query($sql);
	for ($i=0; $row_vote=sql_fetch_array($result); $i++) {
	?>
	<tr>
        <th scope="row"><label><?php echo $row_vote['vote_email']?></label></th>
        <td><?php echo $row_vote['vote_regdate']?></td>
    </tr>
	<?php } ?>
	</tbody>
    </table>

</div>
<?php } ?>

<div class="btn_fixed_top ">
    <a href="./cn_list.php?<?php echo $qstr ?>&cr_id=<?php echo $cr_id?>" class="btn_02 btn">목록</a>
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
