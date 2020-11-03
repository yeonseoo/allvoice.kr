<?php
include_once('./_common.php');


include_once(G5_MSHOP_PATH.'/_head.php');


$page_rows = 8;
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$_REQUEST['orderby'] = isset($_REQUEST['orderby']) ? $_REQUEST['orderby'] : "a.it_id DESC";
$_REQUEST['cat'] = isset($_REQUEST['cat']) ? $_REQUEST['cat'] : "10";

include_once('./_head.php');

$qstr = "cat=".$_REQUEST['cat'];
$qstr2 = "";
$qstr3 = "&orderby=".$_REQUEST['orderby'];

$qry = "SELECT count(*) as cnt FROM ".$g5['g5_shop_item_table']." AS a JOIN ".$g5['g5_shop_category_table']." AS b ON a.ca_id=b.ca_id JOIN ".$g5['member_table']." AS c ON a.it_maker=c.mb_id WHERE a.it_gubun IN ('1','2') AND a.it_use='1' AND a.ca_id='".$_REQUEST['cat']."' ";
$tot_dt = sql_fetch($qry);
$total_count = $tot_dt['cnt'];
$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

$qry = "SELECT a.*, IFNULL(d.cnt,0) cnt, b.ca_name FROM ".$g5['g5_shop_item_table']." AS a JOIN ".$g5['g5_shop_category_table']." AS b ON a.ca_id=b.ca_id JOIN ".$g5['member_table']." AS c ON a.it_maker=c.mb_id LEFT JOIN (SELECT it_id, COUNT(*) AS cnt FROM ".$g5['g5_shop_cart_table']." WHERE ct_select='1' AND ct_status<>'취소' GROUP BY it_id) d ON a.it_id=d.it_id WHERE a.it_gubun IN ('1','2') AND a.it_use='1' AND a.ca_id='".$_REQUEST['cat']."' ORDER BY ".$_REQUEST['orderby']." LIMIT ".$from_record.", ".$page_rows." ";
//echo $qry;
$res = sql_query($qry);
$row_cnt = sql_num_rows($res);
?>

<div class="subCateDep02">
	<div>
		<ul>
<?php
$sql = " select * from {$g5['g5_shop_category_table']} ";
//if ($is_admin != 'super')
//    $sql .= " where ca_mb_id = '{$member['mb_id']}' ";
$sql .= " order by ca_order, ca_id ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
	if ( $row['ca_id'] == $_REQUEST['cat'] ) {
		$catagory_name = $row['ca_name'];
	}
?>
			<li><a href="<?php echo G5_SHOP_URL; ?>/voiceProject.php?cat=<?php echo $row['ca_id']; ?>" <?php echo ( $row['ca_id'] == $_REQUEST['cat'] ) ? "class='on'" : ""; ?>><?php echo $row['ca_name']; ?></a></li>
<?php
}
?>
		</ul>
	</div>
</div>

<!-- 성우리스트 { -->


<div class="listWrap project">
	<div class="listCont">
		<div class="listInfo">
			<div class="listLocation">
				<ul>
					<li><img src="../theme/basic/img/img_home2.png" /></li>
					<li>성우 섭외 프로젝트</li>
					<li><?php echo $catagory_name; ?></li>
				</ul>
			</div>
			<div class="listOrder listOrderTab3">
				<ul>
					<li><a href="javascript:location.href='<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $qstr ?>&orderby=a.it_id DESC';" <?php echo ( $_REQUEST['orderby'] == "a.it_id DESC" ) ? "class='on'" : ""; ?>>최신순</a></li>
					<li><a href="javascript:location.href='<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $qstr ?>&orderby=a.it_price ASC';" <?php echo ( $_REQUEST['orderby'] == "a.it_price ASC" ) ? "class='on'" : ""; ?>>가격낮은순</a></li>
					<li><a href="javascript:location.href='<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $qstr ?>&orderby=a.it_price DESC';" <?php echo ( $_REQUEST['orderby'] == "a.it_price DESC" ) ? "class='on'" : ""; ?>>높은가격순</a></li>
				</ul>
			</div>
		</div>
		
		<ul class="projectList">
<?php
for ($i=0; $row=sql_fetch_array($res); $i++) {
	$icon_url = G5_DATA_URL.'/item/'.$row['it_id'].'/'.$row['it_img1'];
	$icon_url = is_file(G5_DATA_PATH.'/item/'.$row['it_id'].'/'.$row['it_img1']) ? $icon_url : "/theme/basic/img/profileSample.jpg";

	$link_url = ( $row['it_maker'] != $member['mb_id'] && ( $row['it_gubun'] != 1 || $row['it_view_time'] < date("Y-m-d H:i:s") ) ) ? "javascript:alert('마감된 프로젝트입니다.');" : "/shop/voiceProjectDetail.php?it_id=".$row['it_id']."&ca_id=".$_REQUEST['ca_id']."&orderby=".$_REQUEST['orderby']."&page=".$page."";
?>
    		<li>
    			<a href="<?php echo $link_url; ?>">
        			<img src="<?php echo $icon_url; ?>" />
        			<strong><?php echo $row['ca_name']; ?></strong>
        			<i><?php echo $row['it_name']; ?></i>
        			<em><?php echo number_format($row['it_price']); ?><span>won</span></em>
        			<span><?php echo mb_substr(strip_tags($row['it_explan']), 0, 22, 'utf-8'); ?></span>
        			<b>마감일 : <?php echo $row['it_view_time']; ?></b>
        			<b>지원자수 : <?php echo $row['cnt']; ?>명</b>
    			</a>
    		</li>
<?php
}
?>
    	</ul>
		
		<?php echo get_paging($page_rows, $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.$qstr2.$qstr3.'&amp;page='); ?>
	</div>
</div>


<!-- } 성우리스트 끝 -->

<?php
include_once(G5_MSHOP_PATH."/_tail.php");
?>