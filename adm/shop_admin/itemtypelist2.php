<?php
$sub_menu = '400630';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$doc = strip_tags($doc);

$g5['title'] = 'BESTVOICE';
include_once (G5_ADMIN_PATH.'/admin.head.php');

/*
$sql_search = " where 1 ";
if ($search != "") {
	if ($sel_field != "") {
    	$sql_search .= " and $sel_field like '%$search%' ";
    }
}

if ($sel_ca_id != "") {
    $sql_search .= " and (ca_id like '$sel_ca_id%' or ca_id2 like '$sel_ca_id%' or ca_id3 like '$sel_ca_id%') ";
}

if ($sel_field == "")  $sel_field = "it_name";
*/

$where = " AND ";
$sql_search = " WHERE mb_gubun='3' ";
if ($stx != "") {
    if ($sfl != "") {
        $sql_search .= " $where $sfl like '%$stx%' ";
        $where = " AND ";
    }
    if ($save_stx != $stx)
        $page = 1;
}

if ($sca != "") {
    //$sql_search .= " $where (a.mv_cat like '$sca%') ";
}

if ($sfl == "")  $sfl = "mb_name";

if (!$sst)  {
    $sst  = "mb_no";
    $sod = "desc";
}
$sql_order = "order by $sst $sod";

$sql_common = "  from {$g5['member_table']} ";
$sql_common .= $sql_search;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql  = " select *
          $sql_common
          $sql_order
          limit $from_record, $rows ";
$result = sql_query($sql);
//echo $sql;
$qstr  = $qstr.'&amp;sca='.$sca.'&amp;page='.$page.'&amp;save_stx='.$stx;

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';
?>

<div class="local_ov01 local_ov">
    <?php echo $listall; ?>
        <span class="btn_ov01"><span class="ov_txt">전체 상품</span><span class="ov_num">  <?php echo $total_count; ?>개</span></span>
</div>

<form name="flist" class="local_sch01 local_sch">
<input type="hidden" name="doc" value="<?php echo $doc; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<!--label for="sca" class="sound_only">분류선택</label>
<select name="sca" id="sca">
    <option value="">전체분류</option>
    <?php
    $sql1 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} order by ca_order, ca_id ";
    $result1 = sql_query($sql1);
    for ($i=0; $row1=sql_fetch_array($result1); $i++) {
        $len = strlen($row1['ca_id']) / 2 - 1;
        $nbsp = "";
        for ($i=0; $i<$len; $i++) $nbsp .= "&nbsp;&nbsp;&nbsp;";
        echo '<option value="'.$row1['ca_id'].'" '.get_selected($sca, $row1['ca_id']).'>'.$nbsp.$row1['ca_name'].PHP_EOL;
    }
    ?>
</select-->

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="mb_name" <?php echo get_selected($sfl, 'mb_name'); ?>>성명</option>
    <option value="mb_id" <?php echo get_selected($sfl, 'mb_id'); ?>>아이디</option>
</select>

<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" required class="frm_input required">
<input type="submit" value="검색" class="btn_submit">

</form>

<form name="fitemtypelist" method="post" action="./itemtypelist2update.php">
<input type="hidden" name="sca" value="<?php echo $sca; ?>">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col"><?php echo subject_sort_link("mb_no", $qstr, 1); ?>코드</a></th>
        <th scope="col"><?php echo subject_sort_link("mb_id"); ?>아이디</a></th>
		<th scope="col"><?php echo subject_sort_link("mb_name"); ?>성명</a></th>
        <th scope="col"><?php echo subject_sort_link("mb_type1", $qstr, 1); ?>BEST</a></th>
        <!--th scope="col"><?php echo subject_sort_link("mv_type2", $qstr, 1); ?>추천<br>상품</a></th>
        <th scope="col"><?php echo subject_sort_link("mv_type3", $qstr, 1); ?>신규<br>상품</a></th>
        <th scope="col"><?php echo subject_sort_link("mv_type4", $qstr, 1); ?>인기<br>상품</a></th>
        <th scope="col"><?php echo subject_sort_link("mv_type5", $qstr, 1); ?>할인<br>상품</a></th>
        <th scope="col">관리</th-->
    </tr>
    </thead>
    <tbody>
    <?php for ($i=0; $row=sql_fetch_array($result); $i++) {
        $href = G5_SHOP_URL.'/item.php?mv_id='.$row['mv_id'];

        $bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>">
        <td class="td_code">
            <input type="hidden" name="mb_no[<?php echo $i; ?>]" value="<?php echo $row['mb_no']; ?>">
            <?php echo $row['mb_no']; ?>
        </td>
        <td class="td_left"><a href="<?php echo $href; ?>"><?php echo $row['mb_id']; ?></a></td>
		<td class="td_left"><?php echo $row['mb_name']; ?></a></td>
        <td class="td_chk2">
            <label for="type1_<?php echo $i; ?>" class="sound_only">BEST</label>
            <input type="checkbox" name="mb_type1[<?php echo $i; ?>]" value="1" id="type1_<?php echo $i; ?>" <?php echo ($row['mb_type1'] ? 'checked' : ''); ?>>
        </td>
        <!--td class="td_chk2">
            <label for="type2_<?php echo $i; ?>" class="sound_only">추천상품</label>
            <input type="checkbox" name="mv_type2[<?php echo $i; ?>]" value="1" id="type2_<?php echo $i; ?>" <?php echo ($row['mv_type2'] ? 'checked' : ''); ?>>
        </td>
        <td class="td_chk2">
            <label for="type3_<?php echo $i; ?>" class="sound_only">신규상품</label>
            <input type="checkbox" name="mv_type3[<?php echo $i; ?>]" value="1" id="type3_<?php echo $i; ?>" <?php echo ($row['mv_type3'] ? 'checked' : ''); ?>>
        </td>
        <td class="td_chk2">
            <label for="type4_<?php echo $i; ?>" class="sound_only">인기상품</label>
            <input type="checkbox" name="mv_type4[<?php echo $i; ?>]" value="1" id="type4_<?php echo $i; ?>" <?php echo ($row['mv_type4'] ? 'checked' : ''); ?>>
        </td>
        <td class="td_chk2">
            <label for="type5_<?php echo $i; ?>" class="sound_only">할인상품</label>
            <input type="checkbox" name="mv_type5[<?php echo $i; ?>]" value="1" id="type5_<?php echo $i; ?>" <?php echo ($row['mv_type5'] ? 'checked' : ''); ?>>
        </td>
        <td class="td_mng td_mng_s">
            <a href="./itemform.php?w=u&amp;mv_no=<?php echo $row['mv_no']; ?>&amp;ca_id=<?php echo $row['ca_id']; ?>&amp;<?php echo $qstr; ?>" class="btn btn_03"><span class="sound_only"><?php echo cut_str(stripslashes($row['mv_title']), 60, "&#133"); ?> </span>수정</a>
         </td-->
    </tr>
    <?php
    }

    if (!$i)
        echo '<tr><td colspan="4" class="empty_table"><span>자료가 없습니다.</span></td></tr>';
    ?>
    </tbody>
    </table>
</div>

<div class="btn_confirm03 btn_confirm">
    <input type="submit" value="일괄수정" class="btn_submit">
</div>
</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
