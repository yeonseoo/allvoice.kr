<?php
include_once('./_common.php');



include_once(G5_MSHOP_PATH.'/_head.php');


?>

<!-- 성우상세 { -->

<div class="commonLocation">
	<ul>
		<li><img src="../theme/basic/img/img_home2.png" /></li>
		<li>MY PAGE</li>
	</ul>
</div>


<div class="voiceMypage">
<?php
include_once('./voiceRight.php');
?>
	<div class="voiceDetailInfo">
		<div class="voiceDetailSection">
			<div class="voiceDetailTab tab3">
    			<ul>
    				<li class="on"><a href="javascript:;">최근 거래 내역</a></li>
    				<li><a href="javascript:;">문의 주문 내역</a></li>
    				<li><a href="javascript:;">작업 의뢰 주문 내역</a></li>
    			</ul>
			</div>
			<div>
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
if ( $member['mb_gubun'] == "3" ) $sub_where = " AND (a.it_origin='".$member['mb_id']."' OR b.mb_id='".$member['mb_id']."') AND c.od_status IN ('작업진행중','작업완료','취소') ";
else $sub_where = " AND a.it_maker='".$member['mb_id']."' AND c.od_status IN ('작업진행중','작업완료','취소') ";
$qry = "SELECT a.*,c.* FROM ".$g5['g5_shop_item_table']." AS a JOIN ".$g5['g5_shop_cart_table']." AS b ON a.it_id=b.it_id JOIN ".$g5['g5_shop_order_table']." AS c ON b.od_id=c.od_id WHERE a.it_gubun IN ('2','3') ".$sub_where." ORDER BY c.od_id DESC LIMIT 0, 5";
//echo $qry;
$res = sql_query($qry);
$row_cnt = sql_num_rows($res);
for ($i=0; $row=sql_fetch_array($res); $i++) {
	// orderStatus01 제작완료, orderStatus02 작업진행중, orderStatus03 거래합의중, orderStatus04 의뢰완료, orderStatus05 의뢰취소
	$tmp_date = date("y-m-d H:i", strtotime($row['od_time']));
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
?>
    						<tr>
    							<td><span class="orderStatus <?php echo $css; ?>"><?php echo $od_status; ?></span></td>
    							<td><a href="./voiceMypageOrderDetail.php?it_id=<?php echo $row['it_id']; ?>&od_id=<?php echo $row['od_id']; ?>&it_gubun="><?php echo $row['od_id']; ?></a></td>
    							<td><?php echo number_format($row['od_cart_price']); ?>원</td>
    						</tr>
<?php
}
?>
    					</tbody>
    				</table>
    			</div>
    			<div class="more03">
					<!--a href="/shop/voiceMypageList01.php">MORE</a-->
					<a href="/shop/voiceMypageOrder.php?it_gubun=">MORE</a>
    			</div>
			</div>
		</div>
		
		<div class="voiceDetailSection">
			<div class="voiceDetailTab tab3">
    			<ul>
    				<li><a href="javascript:;">최근 거래 내역</a></li>
    				<li class="on"><a href="javascript:;">문의 주문 내역</a></li>
    				<li><a href="javascript:;">작업 의뢰 주문 내역</a></li>
    			</ul>
			</div>
			<div>
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
        						<th>제목</th>
        						<th>제안금액</th>
    						</tr>
    					</thead>
    					<tbody>
<?php
if ( $member['mb_gubun'] == "3" ) $sub_where = " AND (a.it_origin='".$member['mb_id']."' OR b.mb_id='".$member['mb_id']."') ";
else $sub_where = " AND a.it_maker='".$member['mb_id']."' ";
$qry = "SELECT a.*,c.* FROM ".$g5['g5_shop_item_table']." AS a LEFT JOIN ".$g5['g5_shop_cart_table']." AS b ON a.it_id=b.it_id LEFT JOIN ".$g5['g5_shop_order_table']." AS c ON b.od_id=c.od_id WHERE a.it_gubun='3' ".$sub_where." ORDER BY a.it_id DESC LIMIT 0, 5";
//echo $qry;
$res = sql_query($qry);
$row_cnt = sql_num_rows($res);
for ($i=0; $row=sql_fetch_array($res); $i++) {
	// orderStatus01 제작완료, orderStatus02 작업진행중, orderStatus03 거래합의중, orderStatus04 의뢰완료, orderStatus05 의뢰취소
	$tmp_date = date("y-m-d H:i", strtotime($row['it_time']));
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
?>
    						<tr>
    							<td><span class="orderStatus <?php echo $css; ?>"><?php echo $od_status; ?></span></td>
    							<td><a href="./voiceMypageOrderDetail.php?it_id=<?php echo $row['it_id']; ?>&od_id=<?php echo $row['od_id']; ?>&it_gubun=3"><?php echo $row['it_name']; ?></a></td>
    							<td><?php echo number_format($row['it_price']); ?>원</td>
    						</tr>
<?php
}
?>
    					</tbody>
    				</table>
    			</div>
    			<div class="more03">
    				<!--a href="/shop/voiceMypageList02.php">MORE</a-->
					<a href="/shop/voiceMypageOrder.php?it_gubun=3">MORE</a>
    			</div>
			</div>
		</div>
		
		<div class="voiceDetailSection">
			<div class="voiceDetailTab tab3">
    			<ul>
    				<li><a href="javascript:;">최근 거래 내역</a></li>
    				<li><a href="javascript:;">문의 주문 내역</a></li>
    				<li class="on"><a href="javascript:;">작업 의뢰 주문 내역</a></li>
    			</ul>
			</div>
			<div>
    			<div class="tableSet02">
    				<table>
    					<colgroup>
    						<col width="100" />
    						<col width="*" />
    						<col width="110" />
    					</colgroup>
    					<thead>
    						<tr>
        						<th>상태</th>
        						<th>제목</th>
        						<th>금액</th>
    						</tr>
    					</thead>
    					<tbody>
<?php
if ( $member['mb_gubun'] == "3" ) {
	$sub_where = " AND (a.it_origin='".$member['mb_id']."' OR b.mb_id='".$member['mb_id']."') ";
	$qry = "SELECT a.*,c.*, IFNULL(d.cnt,0) cnt, b.ct_time FROM ".$g5['g5_shop_item_table']." AS a LEFT JOIN ".$g5['g5_shop_cart_table']." AS b ON a.it_id=b.it_id LEFT JOIN ".$g5['g5_shop_order_table']." AS c ON b.od_id=c.od_id LEFT JOIN (SELECT it_id, COUNT(*) AS cnt FROM ".$g5['g5_shop_cart_table']." WHERE ct_select='1' AND ct_status NOT IN ('취소','지원취소') GROUP BY it_id) d ON a.it_id=d.it_id WHERE a.it_gubun IN ('1','2') ".$sub_where." ORDER BY b.ct_time DESC LIMIT 0, 5";
}
else {
	$sub_where = " AND a.it_maker='".$member['mb_id']."' ";
	$qry = "SELECT a.*,c.*, IFNULL(d.cnt,0) cnt FROM ".$g5['g5_shop_item_table']." AS a LEFT JOIN ".$g5['g5_shop_cart_table']." AS b ON a.it_id=b.it_id AND a.it_origin=b.mb_id LEFT JOIN ".$g5['g5_shop_order_table']." AS c ON b.od_id=c.od_id LEFT JOIN (SELECT it_id, COUNT(*) AS cnt FROM ".$g5['g5_shop_cart_table']." WHERE ct_select='1' AND ct_status NOT IN ('취소','지원취소') GROUP BY it_id) d ON a.it_id=d.it_id WHERE a.it_gubun IN ('1','2') ".$sub_where." ORDER BY a.it_id DESC LIMIT 0, 5";
}

//echo $qry;
$res = sql_query($qry);
$row_cnt = sql_num_rows($res);
for ($i=0; $row=sql_fetch_array($res); $i++) {
	// orderStatus01 제작완료, orderStatus02 작업진행중, orderStatus03 거래합의중, orderStatus04 의뢰완료, orderStatus05 의뢰취소, 지원완료orderStatus03, 미채택orderStatus05, 채택완료orderStatus01
	$tmp_date = date("y-m-d H:i", strtotime($row['it_time']));
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

?>
    						<tr>
    							<td><span class="orderStatus <?php echo $css; ?>"><?php echo $od_status; ?></span></td>
    							<td><a href="./voiceMypageOrderDetail.php?it_id=<?php echo $row['it_id']; ?>&od_id=<?php echo $row['od_id']; ?>&it_gubun=1"><?php echo $row['it_name']; ?></a></td>
    							<td><?php echo number_format($row['it_price']); ?>원</td>
    						</tr>
<?php
}
?>
    					</tbody>
    				</table>
    			</div>
    			<div class="more03">
    				<!--a href="/shop/voiceMypageList03.php">MORE</a-->
					<a href="/shop/voiceMypageOrder.php?it_gubun=1">MORE</a>
    			</div>
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
        //window.open(this.href, "itemuse_form", "width=810,height=550,scrollbars=1");
        //return false;
    });
});
</script>




<style type="text/css">
#memoCover{position:fixed;top:0;left:0;width:100%;height:100%;background-color:rgba(0,0,0,0.5);display:none;z-index:4000;}
#memoPop{position:fixed;top:10vh;left:5vw;width:90vw;height:80vh;display:none;z-index:4100;}
#memoPop > a{position:absolute;top:0;right:-10px;color:#fff;font-family: sans-serif;display:block;padding:10px;font-size:20px;font-weight:bold;line-height:28px;}
#memoPop > div{width:100%;height:calc(80vh - 48px);margin-top:48px;border:0;overflow-y:scroll;-webkit-overflow-scrolling: touch;}
#memoPop > div > iframe{width:100%;height:100%;}
</style>
<div id="memoCover">
</div>
<div id="memoPop">
	<a href="javascript:;">Ⅹ</a>
	<div>
		<iframe src="<?php echo G5_BBS_URL ?>/memo.php"></iframe>
	</div>
</div>
    
<script type="text/javascript">
$(function(){
	var loadCnt = 0;
	//<?php echo G5_BBS_URL ?>/password_lost.php
	$(".memoPop").attr("href","javascript:;");
	$(".memoPop").click(function(){
		$("#memoCover").show();
		$("#memoPop").show();
	});
	$("#memoPop > a, #memoCover").click(function(){
		$("#memoCover").hide();
		$("#memoPop").hide();
	});

	$("#memoPop > iframe").ready(function(){
		//$("#accInfoFindCover").hide();
		//$("#accInfoFindPop").hide();
		//console.log(loadCnt);
	});
});
</script>

<!-- } 성우상세 끝 -->

<?php
include_once(G5_MSHOP_PATH."/_tail.php");
?>