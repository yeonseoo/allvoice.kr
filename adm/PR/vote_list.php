<?php
$sub_menu = "300520";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$sql_common = " from AV_VOTE ";

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
    $sst  = "vote_id";
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

$g5['title'] = '투표관리';
include_once('../admin.head.php');

$colspan = 7;
?>

<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    <span class="btn_ov01"><span class="ov_txt">투표수</span><span class="ov_num"> <?php echo number_format($total_count) ?>개</span></span>
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
        <th scope="col">번호</th>
		<th scope="col">기간</th>
        <th scope="col">프로젝트명</th>
		<th scope="col">캐릭터명</th>
		<th scope="col">후보명</th>
		<th scope="col">이메일</th>
        <th scope="col">투표일</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $num = $total_count - ($page - 1) * $rows - $i;

        $bg = 'bg'.($i%2);

		$sql = " select * from AV_CR where cr_id = '{$row['cr_id']}' ";
		$cr = sql_fetch($sql);

		$sql = " select * from AV_PR where pr_id = '{$row['pr_id']}' ";
		$pr = sql_fetch($sql);

		$sql = " select * from AV_CN where cn_id = '{$row['cn_id']}' ";
		$cn = sql_fetch($sql);
    ?>

    <tr class="<?php echo $bg; ?>">
        <td class="td_num"><?php echo $num ?></td>
		<td>
		<?php echo $pr['fr_date']; ?> ~ <?php echo $pr['to_date']; ?>
		</td>
        <td class="td_left"><?php echo get_text($pr['pr_subject']) ?></td>
		<td class="td_left"><?php echo get_text($cr['cr_subject']) ?></td>
		<td class="td_left"><?php echo get_text($cn['cn_name']) ?></td>
		<td><?php echo $row['vote_email']; ?></td>
        <td class="" style="width:120px;"><?php echo substr($row['vote_regdate'],0,10) ?></td>
    </tr>

    <?php
    }

    if ($i==0)
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>

<!-- <div class="btn_fixed_top">
    <input type="submit" value="선택삭제" class="btn btn_02">
    <a href="./pr_form.php" id="poll_add" class="btn btn_01">프로젝트 추가</a>
</div> -->
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