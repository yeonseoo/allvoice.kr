<?php
$sub_menu = "300510";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

if(!$cr_id)
	alert('고유번호가 넘어오지 않았습니다.');

$sql = " select * from AV_CR where cr_id = '{$cr_id}' ";
$cr = sql_fetch($sql);

$sql = " select * from AV_PR where pr_id = '{$cr['pr_id']}' ";
$pr = sql_fetch($sql);

$sql_common = " from AV_CN ";

$sql_search = " where (1) and cr_id = '{$cr_id}' ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        default :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "cn_id";
    $sod = "desc";
}
$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt
            {$sql_common}
            {$sql_search}
            {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
            {$sql_common}
            {$sql_search}
            {$sql_order}
            limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';

$g5['title'] = '후보관리';
include_once('../admin.head.php');

$colspan = 8;
?>

<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    <span class="btn_ov01"><span class="ov_txt">후보수</span><span class="ov_num"> <?php echo number_format($total_count) ?>개</span></span>
</div>

<!-- <form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">
<div class="sch_last">
    <label for="sfl" class="sound_only">검색대상</label>
    <select name="sfl" id="sfl">
        <option value="po_subject"<?php echo get_selected($_GET['sfl'], "po_subject"); ?>>제목</option>
    </select>
    <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
    <input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input">
    <input type="submit" class="btn_submit" value="검색">
</div>
</form> -->


<form name="fpolllist" id="fpolllist" action="./cn_delete.php" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">

<input type="hidden" name="pr_id" value="<?php echo $cr['pr_id'] ?>">
<input type="hidden" name="cr_id" value="<?php echo $cr_id ?>">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">
            <label for="chkall" class="sound_only">현재 페이지 투표 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col">번호</th>
		<th scope="col">프로젝트명</th>
		<th scope="col">캐릭터명</th>
        <th scope="col">후보명</th>
		<th scope="col">투표수</th>
        <th scope="col">등록일</th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $num = $total_count - ($page - 1) * $rows - $i;

        $s_mod = '<a href="./cn_form.php?'.$qstr.'&amp;w=u&amp;cn_id='.$row['cn_id'].'&amp;cr_id='.$row['cr_id'].'" class="btn btn_03">수정</a>';

        $bg = 'bg'.($i%2);
    ?>

    <tr class="<?php echo $bg; ?>">
        <td class="td_chk">
            <input type="checkbox" name="chk[]" value="<?php echo $row['cr_id'] ?>" id="chk_<?php echo $i ?>">
        </td>
        <td class="td_num"><?php echo $num ?></td>
        <td class="td_left"><?php echo get_text($pr['pr_subject']) ?></td>
		<td class="td_left"><?php echo get_text($cr['cr_subject']) ?></td>
		<td class="td_left"><strong><?php echo get_text($row['cn_name']) ?></strong></td>
		<td class="td_num"><?php echo $row['cn_vote'] ?></td>
        <td class="" style="width:120px;"><?php echo substr($row['cn_regdate'],0,10) ?></td>
        <td style="width:220px;">
			<?php echo $s_mod ?>
		</td>
    </tr>

    <?php
    }

    if ($i==0)
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
	<a href="./cr_list.php?pr_id=<?php echo $cr['pr_id']?>" class="btn btn_02">캐릭터목록</a>
    <input type="submit" value="선택삭제" class="btn btn_02">
    <a href="./cn_form.php?cr_id=<?php echo $cr_id?>" id="poll_add" class="btn btn_01">후보 추가</a>
</div>
</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
$(function() {
    $('#fpolllist').submit(function() {
        if(confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
            if (!is_checked("chk[]")) {
                alert("선택삭제 하실 항목을 하나 이상 선택하세요.");
                return false;
            }

            return true;
        } else {
            return false;
        }
    });
});
</script>

<?php
include_once ('../admin.tail.php');
?>