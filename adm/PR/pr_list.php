<?php
$sub_menu = "300510";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$sql_common = " from AV_PR ";

$sql_search = " where (1) ";
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
    $sst  = "pr_id";
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

$g5['title'] = '프로젝트관리';
include_once('../admin.head.php');

$colspan = 7;
?>

<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    <span class="btn_ov01"><span class="ov_txt">프로젝트수</span><span class="ov_num"> <?php echo number_format($total_count) ?>개</span></span>
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


<form name="fpolllist" id="fpolllist" action="./pr_delete.php" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">

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
        <th scope="col">제목</th>
		<th scope="col">진행기간</th>
		<th scope="col">마감여부</th>
        <th scope="col">등록일</th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $num = $total_count - ($page - 1) * $rows - $i;

        $s_mod = '<a href="./pr_form.php?'.$qstr.'&amp;w=u&amp;pr_id='.$row['pr_id'].'" class="btn btn_03">수정</a>';

		$s_add = '<a href="./cr_list.php?'.$qstr.'&amp;w=u&amp;pr_id='.$row['pr_id'].'" class="btn btn_03">캐릭터관리</a>';

        $bg = 'bg'.($i%2);

		$today = date('Y-m-d', G5_SERVER_TIME);

		if($row['to_date'] < $today){
			$mode = '<span style="color:red;">마감</span>';
		}else{
			$mode = '<span style="color:blue;">진행</span>';
		}
    ?>

    <tr class="<?php echo $bg; ?>">
        <td class="td_chk">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo cut_str(get_text($row['po_subject']),70) ?> 프로젝트</label>
            <input type="checkbox" name="chk[]" value="<?php echo $row['pr_id'] ?>" id="chk_<?php echo $i ?>">
        </td>
        <td class="td_num"><?php echo $num ?></td>
        <td class="td_left"><?php echo get_text($row['pr_subject']) ?></td>
		<td>
		<?php echo $row['fr_date']; ?> ~ <?php echo $row['to_date']; ?>
		</td>
		<td class="" style="width:120px;"><?php echo $mode ?></td>
        <td class="" style="width:120px;"><?php echo substr($row['pr_regdate'],0,10) ?></td>
        <td style="width:220px;">
			<?php echo $s_mod ?>
			<?php echo $s_add ?>
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
    <input type="submit" value="선택삭제" class="btn btn_02">
    <a href="./pr_form.php" id="poll_add" class="btn btn_01">프로젝트 추가</a>
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