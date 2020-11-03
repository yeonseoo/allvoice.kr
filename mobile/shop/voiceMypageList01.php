<?php
include_once('./_common.php');

include_once(G5_MSHOP_PATH.'/_head.php');

$page_rows = 10;
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$_REQUEST['it_gubun'] = isset($_REQUEST['it_gubun']) ? $_REQUEST['it_gubun'] : "";
$_REQUEST['od_status'] = isset($_REQUEST['od_status']) ? $_REQUEST['od_status'] : "";
$_REQUEST['sch'] = isset($_REQUEST['sch']) ? $_REQUEST['sch'] : "";
$_REQUEST['sch_val'] = isset($_REQUEST['sch_val']) ? $_REQUEST['sch_val'] : "";

include_once('./_head.php');

$qstr = "it_gubun=".$_REQUEST['it_gubun']."&sch=".$_REQUEST['sch']."&sch_val=".$_REQUEST['sch_val'];
$qstr2 = "&od_status=".$_REQUEST['od_status'];

if ( $member['mb_gubun'] == "3" ) {
	$gubun_id = "it_origin";
	$gubun_id2 = "it_maker";
	$gubun_name = "구매자";
	$join = "LEFT JOIN";
}
else {
	$gubun_id = "it_maker";
	$gubun_id2 = "it_origin";
	$gubun_name = "판매자";
	$join = "JOIN";
}

$sub_where = "";
if ( $_REQUEST['it_gubun'] == "3" ) {
	$sub_where .= " AND a.it_gubun='3' ";
	$sub_title = "합의 주문 내역";
}
else if ( $_REQUEST['it_gubun'] == "1" || $_REQUEST['it_gubun'] == "2" ) {
	$sub_where .= " AND a.it_gubun IN ('1','2') ";
	$sub_title = "작업 의뢰 프로젝트 지원 내역";
}
else {
	$sub_title = "거래 내역";
}

if ( $_REQUEST['od_status'] ) {
	$sub_where .= " AND c.od_status='".$_REQUEST['od_status']."' ";
}

if ( $_REQUEST['sch'] && $_REQUEST['sch_val'] ) {
	$sub_where .= " AND a.".$_REQUEST['sch']." LIKE '%".$_REQUEST['sch_val']."%' ";
}

$qry = "SELECT count(*) as cnt FROM ".$g5['g5_shop_item_table']." AS a ".$join." ".$g5['g5_shop_cart_table']." AS b ON a.it_id=b.it_id ".$join." ".$g5['g5_shop_order_table']." AS c ON b.od_id=c.od_id WHERE a.".$gubun_id."='".$member['mb_id']."' ".$sub_where." ";
$tot_dt = sql_fetch($qry);
$total_count = $tot_dt['cnt'];
$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함
//echo $total_count;
$qry = "SELECT a.*,c.od_status,c.od_id,b.ct_id FROM ".$g5['g5_shop_item_table']." AS a ".$join." ".$g5['g5_shop_cart_table']." AS b ON a.it_id=b.it_id ".$join." ".$g5['g5_shop_order_table']." AS c ON b.od_id=c.od_id WHERE a.".$gubun_id."='".$member['mb_id']."' ".$sub_where." ORDER BY a.it_id DESC LIMIT ".$from_record.", ".$page_rows." ";
//echo $qry;
$res = sql_query($qry);
$row_cnt = sql_num_rows($res);
?>

<!-- 성우상세 { -->

<div class="commonLocation">
	<ul>
		<li><img src="../theme/basic/img/img_home2.png" /></li>
		<li>MY PAGE</li>
		<li>최근 거래 내역</li>
	</ul>
</div>


<div class="voiceMypage">
<?php
include_once('./voiceRight.php');
?>
	
	<div class="voiceDetailInfo">
		<div class="voiceDetailSection">
			<div style="padding:30px 50px;">
    			<div class="tableSet02">
    				<table>
    					<colgroup>
    						<col width="100" />
    						<col width="*" />
    						<col width="100" />
    					</colgroup>
    					<thead>
    						<tr>
        						<th>상태</th>
        						<th>주문서번호</th>
        						<th>주문금액</th>
    						</tr>
    					</thead>
    					<tbody>
<?php
for ($i=0; $row=sql_fetch_array($res); $i++) {
	switch ( $row['od_status'] ) {
		case "작업완료" :
			$css = "orderStatus01";
			break;
		case "작업진행중" :
			$css = "orderStatus02";
			break;
		case "거래합의중" :
			$css = "orderStatus03";
			break;
		case "의뢰완료" :
			$css = "orderStatus04";
			break;
		case "의뢰취소" :
			$css = "orderStatus05";
			break;
		case "취소" :
			$css = "orderStatus05";
			break;
		case "지원취소" :
			$css = "orderStatus05";
			break;
		case "지원완료" :
			$css = "orderStatus03";
			break;
		case "채택완료" :
			$css = "orderStatus01";
			break;
		default :
			$css = "orderStatus04";
			break;
	}

	if ( $row['od_status'] ) {
		$od_status = $row['od_status'];
	}
	else if ( !$row['od_status'] && $row['it_gubun'] == "1") {
		$od_status = "미채택";
		$css = "orderStatus05";
	}
	else if ( !$row['od_status'] && $row['it_gubun'] == "3") {
		$od_status = "의뢰완료";
		$css = "orderStatus04";
	}

	$tmp_date = date("y-m-d H:i", strtotime($row['it_time']));
?>
    						<tr>
    							<td><span class="orderStatus <?php echo $css; ?>"><?php echo $od_status; ?></span></td>
    							<td><a href="./voiceMypageOrderDetail.php?it_id=<?php echo $row['it_id']; ?>&od_id=<?php echo $row['od_id']; ?>&<?php echo $qstr.$qstr2; ?>&page=<?php echo $page; ?>"><?php echo $row['od_id']; ?></a></td>
    							<td><?php echo number_format($row['it_price']); ?>원</td>
    						</tr>
<?php
}
?>
    					</tbody>
    				</table>
    			</div>
    			
    			<?php echo get_paging($page_rows, $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.$qstr2.'&amp;page='); ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$(function(){
	$(".voiceDetailTab").each(function(){
    	$(this).find("a").each(function(aIdx){
    		$(this).click(function(){
    			console.log($(".voiceDetailSection").eq(aIdx).offset().top);
    			
    			$("html, body").animate({
    				scrollTop : $(".voiceDetailSection").eq(aIdx).offset().top - 203
        		},0);
    		});
    	});
	});

	$(".memoPop").click(function(){
        window.open(this.href, "itemuse_form", "width=810,height=550,scrollbars=1");
        return false;
    });
});
</script>

<!-- } 성우상세 끝 -->

<?php
include_once(G5_MSHOP_PATH."/_tail.php");
?>