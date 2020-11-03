<?php
include_once('./_common.php');

include_once('./_head.php');

$page_rows = 10;
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$_REQUEST['it_gubun'] = isset($_REQUEST['it_gubun']) ? $_REQUEST['it_gubun'] : "";
$_REQUEST['sod_status'] = isset($_REQUEST['sod_status']) ? $_REQUEST['sod_status'] : "";
$_REQUEST['sch'] = isset($_REQUEST['sch']) ? $_REQUEST['sch'] : "";
$_REQUEST['sch_val'] = isset($_REQUEST['sch_val']) ? $_REQUEST['sch_val'] : "";

include_once('./_head.php');

$qstr = "it_gubun=".$_REQUEST['it_gubun']."&sch=".$_REQUEST['sch']."&sch_val=".$_REQUEST['sch_val'];
$qstr2 = "&sod_status=".$_REQUEST['sod_status'];

$sub_where = "";
if ( $member['mb_gubun'] == "3" ) {
	$gubun_id = "it_origin";
	$gubun_id2 = "it_maker";
	$gubun_name = "구매자";
	$join = "LEFT JOIN";
	$sub_where .= " AND (a.it_origin='".$member['mb_id']."' OR b.mb_id='".$member['mb_id']."') ";
	$c_and = "";
}
else {
	$gubun_id = "it_maker";
	$gubun_id2 = "it_origin";
	$gubun_name = ( $_REQUEST['it_gubun'] != "3" ) ? "확정 작업자" : "판매자";
	$join = "LEFT JOIN";
	$sub_where .= " AND a.it_maker='".$member['mb_id']."' ";
	$c_and = " AND a.it_origin=b.mb_id";
}

if ( $_REQUEST['it_gubun'] == "3" ) {
	$sub_where .= " AND a.it_gubun='3' ";
	$sub_title = "문의 주문 내역";
	$orderby = "a.it_id";
}
else if ( $_REQUEST['it_gubun'] == "1" || $_REQUEST['it_gubun'] == "2" ) {
	$sub_where .= " AND a.it_gubun IN ('1','2') ";
	$sub_title = "작업 의뢰 프로젝트 등록 내역";
	$orderby = ( $member['mb_gubun'] == "3" ) ? "b.ct_time" : "a.it_id";
}
else {
	$sub_where .= " AND a.it_gubun IN ('2','3') AND c.od_status IN ('작업진행중','작업완료','취소') ";
	$join = "JOIN";
	$sub_title = "거래 내역";
	$orderby = "c.od_id";
}

if ( $_REQUEST['sod_status'] ) {
	if ( $_REQUEST['sod_status'] == "의뢰취소" ) $sub_where .= " AND c.od_status IN ('".$_REQUEST['sod_status']."','취소') ";
	else if ( $_REQUEST['sod_status'] == "의뢰완료" ) $sub_where .= " AND c.od_status IS NULL AND a.it_gubun='3' ";
	else if ( $_REQUEST['sod_status'] == "미채택" ) $sub_where .= " AND c.od_status IS NULL AND a.it_gubun='1' AND a.it_use='1' ";
	else if ( $_REQUEST['sod_status'] == "진행중" ) $sub_where .= " AND ( c.od_status IS NULL OR c.od_status='지원완료' ) AND a.it_gubun='1' AND a.it_use='1' ";
	else if ( $_REQUEST['sod_status'] == "등록대기" ) $sub_where .= " AND c.od_status IS NULL AND a.it_gubun='1' AND a.it_use='0' ";
	else $sub_where .= " AND c.od_status='".$_REQUEST['sod_status']."' ";
}

if ( $_REQUEST['sch'] && $_REQUEST['sch_val'] ) {
	if ( $_REQUEST['sch'] == "od_id" ) $sub_where .= " AND c.".$_REQUEST['sch']." LIKE '%".$_REQUEST['sch_val']."%' ";
	else $sub_where .= " AND a.".$_REQUEST['sch']." LIKE '%".$_REQUEST['sch_val']."%' ";
}

$qry = "SELECT count(*) as cnt FROM ".$g5['g5_shop_item_table']." AS a ".$join." ".$g5['g5_shop_cart_table']." AS b ON a.it_id=b.it_id ".$c_and." ".$join." ".$g5['g5_shop_order_table']." AS c ON b.od_id=c.od_id WHERE 1 ".$sub_where." ";
$tot_dt = sql_fetch($qry);
$total_count = $tot_dt['cnt'];
$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함
//echo $total_count;
$qry = "SELECT a.*,c.*,b.ct_id, b.ct_time, IFNULL(d.cnt,0) cnt FROM ".$g5['g5_shop_item_table']." AS a ".$join." ".$g5['g5_shop_cart_table']." AS b ON a.it_id=b.it_id ".$c_and." ".$join." ".$g5['g5_shop_order_table']." AS c ON b.od_id=c.od_id LEFT JOIN (SELECT it_id, COUNT(*) AS cnt FROM ".$g5['g5_shop_cart_table']." WHERE ct_select='1' AND ct_status NOT IN ('취소','지원취소') GROUP BY it_id) d ON a.it_id=d.it_id WHERE 1 ".$sub_where." ORDER BY ".$orderby." DESC LIMIT ".$from_record.", ".$page_rows." ";
//echo $qry;
$res = sql_query($qry);
$row_cnt = sql_num_rows($res);
?>

<!-- 성우상세 { -->

<div class="commonLocation">
	<ul>
		<li><img src="../theme/basic/img/img_home2.png" /></li>
		<li>MY PAGE</li>
		<li><?php echo $sub_title; ?></li>
	</ul>
</div>


<div class="voiceMypage">
	<?php
include_once('./voiceRight.php');
?>
	<div class="voiceDetailInfo">
		<div class="voiceDetailSection">
			<div style="padding:30px 50px;">
				
				<div class="orderTab">
					<ul>
						<li><a onClick="location.href='<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $qstr; ?>&sod_status=';" <?php echo $_REQUEST['sod_status'] == "" ? "class=\"on\"" : ""; ?>>전체</a></li>
						<?php
						if ( $_REQUEST['it_gubun'] == 3 ) {
						?>
						<li><a onClick="location.href='<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $qstr; ?>&sod_status=의뢰완료';" <?php echo $_REQUEST['sod_status'] == "의뢰완료" ? "class=\"on\"" : ""; ?>>의뢰완료</a></li>
						<li><a onClick="location.href='<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $qstr; ?>&sod_status=거래합의중';" <?php echo $_REQUEST['sod_status'] == "거래합의중" ? "class=\"on\"" : ""; ?>>거래합의중</a></li>
						<?php
						}
						else if ( ( $_REQUEST['it_gubun'] == 1 || $_REQUEST['it_gubun'] == 2 ) && $member['mb_gubun'] != "3" ) {
						?>
						<li><a onClick="location.href='<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $qstr; ?>&sod_status=등록대기';" <?php echo $_REQUEST['sod_status'] == "등록대기" ? "class=\"on\"" : ""; ?>>등록대기</a></li>
						<li><a onClick="location.href='<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $qstr; ?>&sod_status=진행중';" <?php echo $_REQUEST['sod_status'] == "진행중" ? "class=\"on\"" : ""; ?>>진행중</a></li>
						<?php
						}
						else if ( ( $_REQUEST['it_gubun'] == 1 || $_REQUEST['it_gubun'] == 2 ) && $member['mb_gubun'] == "3" ) {
						?>
						<li><a onClick="location.href='<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $qstr; ?>&sod_status=지원완료';" <?php echo $_REQUEST['sod_status'] == "지원완료" ? "class=\"on\"" : ""; ?>>지원완료</a></li>
						<li><a onClick="location.href='<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $qstr; ?>&sod_status=채택완료';" <?php echo $_REQUEST['sod_status'] == "채택완료" ? "class=\"on\"" : ""; ?>>채택완료</a></li>
						<li><a onClick="location.href='<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $qstr; ?>&sod_status=미채택';" <?php echo $_REQUEST['sod_status'] == "미채택" ? "class=\"on\"" : ""; ?>>미채택</a></li>
						<?php
						}
						?>
						<li><a onClick="location.href='<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $qstr; ?>&sod_status=작업진행중';" <?php echo $_REQUEST['sod_status'] == "작업진행중" ? "class=\"on\"" : ""; ?>>작업진행중</a></li>
						<li><a onClick="location.href='<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $qstr; ?>&sod_status=작업완료';" <?php echo $_REQUEST['sod_status'] == "작업완료" ? "class=\"on\"" : ""; ?>>작업완료</a></li>
						<li><a onClick="location.href='<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $qstr; ?>&sod_status=의뢰취소';" <?php echo $_REQUEST['sod_status'] == "의뢰취소" ? "class=\"on\"" : ""; ?>>의뢰취소</a></li>
					</ul>
					
					<form id="sform" name="sform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>">
					<input type="hidden" name="sod_status" value="<?php echo $_REQUEST['sod_status']; ?>">
					<input type="hidden" name="it_gubun" value="<?php echo $_REQUEST['it_gubun']; ?>">
						<span class="slcWrap">
							<select id="sch" name="sch">
								<option value="it_name" <?php echo $_REQUEST['sch'] == "it_name" ? "selected" : ""; ?>>제목</option>
								<option value="od_id" <?php echo $_REQUEST['sch'] == "od_id" ? "selected" : ""; ?>>주문서번호</option>
								<option value="<?php echo $gubun_id2; ?>" <?php echo $_REQUEST['sch'] == $gubun_id2 ? "selected" : ""; ?>><?php echo $gubun_name; ?> 아이디</option>
								<!--option value="it_time" <?php echo $_REQUEST['sch'] == "it_time" ? "selected" : ""; ?>>의뢰일</option-->
							</select>
						</span>
						<input type="text" id="sch_val" name="sch_val" value="<?php echo $_REQUEST['sch_val']; ?>" />
						<input type="image" src="../theme/basic/img/btn_search.png" />
					</form>
				</div>
			
    			<div class="tableSet02">
    				<table>
    					<colgroup>
    						<col width="100" />
    						<col width="*" />
    					</colgroup>
    					<thead>
    						<tr>
        						<th>상태</th>
        						<th>제목</th>
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

	if ( $row['od_status'] == "채택완료" && $member['mb_gubun'] != "3" ) {
		$od_status = "마감";
	}
	else if ( !$row['od_status'] && $row['it_gubun'] == "1" && $row['it_use'] == "0") {
		$od_status = "등록대기";
		$css = "orderStatus05";
	}
	else if ( !$row['od_status'] && $row['it_gubun'] == "1" && $member['mb_gubun'] == "3") {	// 성우회원이면
		$od_status = "미채택";
		$css = "orderStatus05";
	}
	else if ( (!$row['od_status'] || $row['od_status'] == "지원완료") && $row['it_gubun'] == "1" && $member['mb_gubun'] != "3") {	// 일반회원이면
		$od_status = "진행중";
		$css = "orderStatus05";
	}
	else if ( !$row['od_status'] && $row['it_gubun'] == "3") {
		$od_status = "의뢰완료";
		$css = "orderStatus04";
	}
	else if ( $row['od_status'] ) {
		$od_status = $row['od_status'];
	}

	$tmp_date = date("y-m-d H:i", strtotime($row['it_time']));
	$tmp_date3 = date("y-m-d H:i", strtotime($row['it_time']))." (".get_yoil($row['it_time']).")";
?>
    						<tr>
    							<td><span class="orderStatus <?php echo $css; ?>"><?php echo $od_status; ?></span></td>
    							<td><a href="./voiceMypageOrderDetail.php?it_id=<?php echo $row['it_id']; ?>&od_id=<?php echo $row['od_id']; ?>&<?php echo $qstr.$qstr2; ?>&page=<?php echo $page; ?>"><?php echo $row['it_name']; ?></a></td>
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
include_once("./_tail.php");
?>