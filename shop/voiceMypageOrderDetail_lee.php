<?php
include_once('./_common.php');


if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/voiceMypageOrderDetail.php');
    return;
}

$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$_REQUEST['it_gubun'] = isset($_REQUEST['it_gubun']) ? $_REQUEST['it_gubun'] : "";
$_REQUEST['sod_status'] = isset($_REQUEST['sod_status']) ? $_REQUEST['sod_status'] : "";
$_REQUEST['sch'] = isset($_REQUEST['sch']) ? $_REQUEST['sch'] : "";
$_REQUEST['sch_val'] = isset($_REQUEST['sch_val']) ? $_REQUEST['sch_val'] : "";
$_REQUEST['it_id'] = isset($_REQUEST['it_id']) ? $_REQUEST['it_id'] : "";
$_REQUEST['od_id'] = isset($_REQUEST['od_id']) ? $_REQUEST['od_id'] : "";

include_once('./_head.php');

$qstr = "it_gubun=".$_REQUEST['it_gubun']."&sch=".$_REQUEST['sch']."&sch_val=".$_REQUEST['sch_val'];
$qstr2 = "&sod_status=".$_REQUEST['sod_status'];

if ( $member['mb_gubun'] == "3" ) {
	$gubun_id = "it_origin";
	$gubun_id2 = "it_maker";
	$gubun_name = "구매자";
}
else {
	$gubun_id = "it_maker";
	$gubun_id2 = "it_origin";
	$gubun_name = "판매자";
}

$sub_where = "";
if ( $_REQUEST['it_gubun'] == "3" ) {
	$sub_where .= " AND a.it_gubun='3' ";
	$sub_title = "문의 주문 내역";
	$sub_title2 = "문의 주문서 보기";
}
else if ( $_REQUEST['it_gubun'] == "1" || $_REQUEST['it_gubun'] == "2" ) {
	$sub_where .= " AND a.it_gubun IN ('1','2') ";
	$sub_title = "작업 의뢰 프로젝트 지원 내역";
	$sub_title2 = "작업 의뢰 프로젝트 지원서 보기";
}
else {
	$sub_title = "거래 내역";
	$sub_title2 = "거래 내역서 보기";
}

$sub_where = "";
if ( $_REQUEST['od_id'] ) {
	$sub_where .= " AND c.od_id='".$_REQUEST['od_id']."' ";
}

$qry = "SELECT a.*,c.*,d.ca_name,b.ct_id FROM ".$g5['g5_shop_item_table']." AS a LEFT JOIN ".$g5['g5_shop_cart_table']." AS b ON a.it_id=b.it_id LEFT JOIN ".$g5['g5_shop_order_table']." AS c ON b.od_id=c.od_id JOIN ".$g5['g5_shop_category_table']." AS d ON a.ca_id=d.ca_id WHERE a.it_id='".$_REQUEST['it_id']."'".$sub_where;
$view_dt = sql_fetch($qry);
//echo $qry;
$tmp_date = date("y-m-d H:i", strtotime($view_dt['it_time']));

switch ( $view_dt['od_status'] ) {
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

if ( $view_dt['od_status'] ) {
	$od_status = $view_dt['od_status'];
}
else if ( !$view_dt['od_status'] && $view_dt['it_gubun'] == "1") {
	$od_status = "미채택";
	$css = "orderStatus05";
}
else if ( !$view_dt['od_status'] && $view_dt['it_gubun'] == "3") {
	$od_status = "의뢰완료";
	$css = "orderStatus04";
}

$_REQUEST['od_id'] = ( $view_dt['od_id'] ) ? $view_dt['od_id'] : $_REQUEST['od_id'];
$od_id = $_REQUEST['od_id'];
?>

<!-- 성우상세 { -->

<div class="commonLocation">
	<ul>
		<li><img src="../theme/basic/img/img_home2.png" /></li>
		<li>MY PAGE</li>
		<li><?php echo $sub_title; ?></li>
		<li><?php echo $sub_title2; ?></li>
	</ul>
</div>


<div class="voiceMypage">
	<div class="voiceDetailInfo">
		<div class="voiceDetailSection">
			<div style="padding:30px 50px;">
				<div class="orderDetailView">
    				<a href="javascript:;" class="orderDetailViewCtrl">
    					<strong><?php echo $view_dt['it_maker']; ?>님의 주문서</strong>
    					<span>의뢰일 <?php echo $tmp_date; ?>(<?php echo get_yoil($view_dt['it_time']); ?>)</span>
    				</a>

    				<ul class="orderDetailViewCont">
    					<li>
    						<span>상태</span>
    						<div>
    							<span class="orderStatus <?php echo $css; ?>"><?php echo $od_status; ?></span>
    						</div>
    					</li>
    					<li>
    						<span>제목</span>
    						<div>
    							<?php echo $view_dt['it_name']; ?>
    						</div>
    					</li>
    					<li>
    						<span>설명</span>
    						<div>
    							<?php echo nl2br($view_dt['it_explan']); ?>
    						</div>
    					</li>
    					<li>
    						<span>대본</span>
    						<div>
    							<?php echo nl2br($view_dt['it_explan2']); ?>
    							<div>
	    							<?php echo $view_dt['it_8']; ?>&nbsp;&nbsp;&nbsp;<a href="./download.php?it_id=<?php echo $view_dt['it_id']; ?>" class="downloadBtn">Download</a>
    							</div>
    						</div>
    					</li>
    					<li>
    						<span>마감시한</span>
    						<div>
    							<?php echo $view_dt['it_view_time']; ?>
    						</div>
    					</li>
    					<li>
    						<span>Category</span>
    						<div>
    							<?php echo $view_dt['ca_name']; ?>
    						</div>
    					</li>
    					<li>
    						<span>Gender</span>
    						<div>
    							<?php echo $gender_arr[$view_dt['it_1']]; ?>
    						</div>
    					</li>
    					<li>
    						<span>Age</span>
    						<div>
    							<?php echo $age_arr[$view_dt['it_2']]; ?>
    						</div>
    					</li>
    					<li>
    						<span>Style</span>
    						<div>
    							<?php echo $style_arr[$view_dt['it_3']]; ?>
    						</div>
    					</li>
						<li>
    						<span>Tone</span>
    						<div>
    							<?php echo $tone_arr[$view_dt['it_4']]; ?>
    						</div>
    					</li>
    					<li>
    						<span>Language</span>
    						<div>
    							<?php echo $language_arr[$view_dt['it_5']]; ?>
    						</div>
    					</li>
    					<li>
    						<span>예산</span>
    						<div>
    							<?php echo number_format($view_dt['it_price']); ?>원
    						</div>
    					</li>
    				</ul>
				</div>
			</div>
		</div>
<?php
if ( $view_dt['ct_status'] != "취소" ) {
	if ( $member['mb_gubun'] == "3" ) {
		if ( $view_dt['it_gubun'] == "3" ) {
?>
		<form id="oform" name="oform" method="post" action="./voiceMypageOrderDetail_update.php">
		<input type="hidden" id="it_id" name="it_id" value="<?php echo $_REQUEST['it_id']; ?>">
		<input type="hidden" id="it_gubun" name="it_gubun" value="<?php echo $_REQUEST['it_gubun']; ?>">
		<input type="hidden" id="sch" name="sch" value="<?php echo $_REQUEST['sch']; ?>">
		<input type="hidden" id="sch_val" name="sch_val" value="<?php echo $_REQUEST['sch_val']; ?>">
		<input type="hidden" id="sod_status" name="sod_status" value="<?php echo $_REQUEST['sod_status']; ?>">
		<input type="hidden" id="page" name="page" value="<?php echo $_REQUEST['page']; ?>">
		<input type="hidden" id="od_id" name="od_id" value="<?php echo $view_dt['od_id']; ?>">
		<input type="hidden" id="ct_id" name="ct_id" value="<?php echo $view_dt['ct_id']; ?>">
		<input type="hidden" id="mode" name="mode" value="">
		<div class="voiceSampleSection form">
			<div style="padding:30px 50px;">
    			<div class="orderDetailView">
    				<a href="javascript:;" class="orderDetailViewCtrl">
    					<strong>답변</strong>
    				</a>
    			</div>
			</div>
			<ul style="margin-bottom:0;padding-top:0;transform:translateY(-20px);" class="orderDetailViewCont">
				<li>
					<ul>
						<li><span>내용</span><textarea rows="7" id="od_memo" name="od_memo" placeholder="가격 변동시 가격 변동 사유를 적어주세요.
최초 견적 금액으로 작업을 진행할 경우 '합의 '라고 적어주세요.
예  : 분량이 많아 가격을 인상하여 진행 부탁드립니다.
해당 카테고리의 경우 30만원에 작업이 가능하십니다."><?php echo $view_dt['od_memo']; ?></textarea></li>
						<li><span>견적금액</span><input type="text" id="od_cart_price" name="od_cart_price" placeholder="고객님의 예산에 합의하실경우 동일한 금액을 적어주세요." value="<?php echo $view_dt['od_cart_price'] > 0 ? $view_dt['od_cart_price'] : $view_dt['od_receipt_price']; ?>" numberOnly /></li>
					</ul>
        			<em style="font-style:normal;font-size:15px;color:#666;">견적금액은 회원에게 결제를 요청할 가격입니다. 견적금액을 확인 한 후, 거래 합의하기 버튼을 클릭해주세요 </em>
				</li>
			</ul>
		</div>
<?php
			if ( $od_status == "의뢰완료" || $od_status == "채택완료" || $od_status == "거래합의중" ) {
?>
		<div class="ctrler">
			<a id="submit_btn" class="vSave" style="cursor:pointer;"><?php echo ( $od_status == "거래합의중" ) ? "수정 내용 저장" : "거래 합의하기"; ?></a>
			<?php echo ( $od_status == "거래합의중" ) ? '<a id="cancel_btn" class="vCancel" style="cursor:pointer;">의뢰 취소하기</a>' : ''; ?>
		</div>
<?php
			}
?>
		</form>
<?php
		}
		if ( $od_status == "작업진행중" || $od_status == "작업완료" ) {
?>
		<div class="voiceDetailSection">
			<div style="padding:30px 50px;">
				<div class="orderDetailView">
    				<a href="javascript:;" class="orderDetailViewCtrl">
    					<strong><?php echo $view_dt['it_maker']; ?>님의 결제 내역</strong>
    				</a>

    				<ul class="orderDetailViewCont">
    					<li>
    						<span>결제일</span>
    						<div>
    							<?php echo $view_dt['od_receipt_time']; ?>
    						</div>
    					</li>
    					<li>
    						<span>결제 금액</span>
    						<div>
    							<?php echo number_format($view_dt['od_receipt_price']); ?>원
    						</div>
    					</li>
    					<li>
    						<span>결제 수단</span>
    						<div>
    							<?php echo $view_dt['od_settle_case']; ?>
    						</div>
    					</li>
    				</ul>
				</div>
			</div>
		</div>
<?php
			if ( $od_status == "작업진행중" || $od_status == "작업완료" ) {
				$sql = "SELECT * FROM ".$g5['g5_shop_order_voice_table']." WHERE od_id='".$view_dt['od_id']."' ORDER BY ov_id";
				$res11 = sql_query($sql);
				$row_cnt = sql_num_rows($res11);
				if ( $row_cnt > 0 ) {
?>
		<div class="voiceSampleSection form">
			<div style="padding:30px 50px;">
    			<div class="orderDetailView">
    				<a href="javascript:;" class="orderDetailViewCtrl">
    					<strong>작업 완료 파일</strong>
    				</a>
    				<ul class="orderDetailViewCont">
<?php
					for ($i=0; $row=sql_fetch_array($res11); $i++) {
?>
    					<li>
    						<span><?php echo $i+1; ?>차</span>
    						<div>
    							<?php echo $row['ov_voice_name']; ?>&nbsp;&nbsp;&nbsp;<a href="./download2.php?ov_id=<?php echo $row['ov_id']; ?>" class="downloadBtn">Download</a>
    						</div>
    					</li>
<?php
					}
?>
    				</ul>
    			</div>
			</div>
		</div>

<?php
				}
			}
			if ( $od_status == "작업진행중" ) {
?>
		<form id="oform3" name="oform3" method="post" action="./voiceMypageOrderDetail_update.php" enctype="multipart/form-data">
		<input type="hidden" id="it_id" name="it_id" value="<?php echo $_REQUEST['it_id']; ?>">
		<input type="hidden" id="it_gubun" name="it_gubun" value="<?php echo $_REQUEST['it_gubun']; ?>">
		<input type="hidden" id="sch" name="sch" value="<?php echo $_REQUEST['sch']; ?>">
		<input type="hidden" id="sch_val" name="sch_val" value="<?php echo $_REQUEST['sch_val']; ?>">
		<input type="hidden" id="sod_status" name="sod_status" value="<?php echo $_REQUEST['sod_status']; ?>">
		<input type="hidden" id="page" name="page" value="<?php echo $_REQUEST['page']; ?>">
		<input type="hidden" id="od_id" name="od_id" value="<?php echo $view_dt['od_id']; ?>">
		<input type="hidden" id="ct_id" name="ct_id" value="<?php echo $view_dt['ct_id']; ?>">
		<input type="hidden" id="mode" name="mode" value="voice_upload">
		<div class="voiceSampleSection form">
			<div style="padding:30px 50px">
    			<div class="orderDetailView">
    				<a href="javascript:;" class="orderDetailViewCtrl">
    					<strong>작업 완료 파일 등록</strong>
    				</a>
    			</div>
			</div>
			<ul style="margin-bottom:0;padding-top:0;transform:translateY(-20px);" class="orderDetailViewCont">
				<li>
					<ul id="file_list">
						<li>
							<span></span>
							<div class="fakeFile">
								<input type="hidden" name="del_file[]" value="">
								<input type="text" name="voice_name[]" value="" />
								<div><input type="file" name="voice[]" onChange="change_file(this)" /></div>
							</div>
						</li>
					</ul>
				</li>
				<li>
        			<div class="newSample">
        				<a id="add_btn" style="cursor:pointer;"><img src="../theme/basic/img/btn_plus.png" /><span>음성 추가하기</span></a>
        			</div>
				</li>
			</ul>
		</div>

		<div class="ctrler">
			<a id="voice_save" class="vSave" style="cursor:pointer;">저장</a>
			<a href="javascript:;" class="vCancel">취소</a>
		</div>
		</form>
<script type="text/javascript">
$(document).ready(function() {
	//'+cnt+'차
	$("#add_btn").click(function() {
		var cnt = eval($("#file_list > li").size() + " + 1");
		var str = '<span></span>';
		str += '<div class="fakeFile">';
		str += '<input type="hidden" name="del_file[]" value="">';
		str += '<input type="text" name="voice_name[]" value=""  />';
		str += '<div><input type="file" name="voice[]" onChange="change_file(this)" /></div>';
		str += '</div>';

		$("#file_list").append("<li>"+str+"</li>");
	});

	$("#voice_save").click(function(){
		var cnt = 0;
		$("#file_list > li").each(function (index, item) {
			if ( $("input[name='voice[]']:eq(" + index + ")").val() != "" ) {
				cnt ++;
			}
		});

		//alert(cnt);
		if ( cnt <= 0 ) {
			alert( "작업완료파일을 첨부해주세요." );
			return;
		}

		$("#oform3").submit();
	});
});

function change_file(obj) {
	//console.log("test");
	//console.log("TEst == >" + $(obj).parents("div").parents("div").children().next().attr("name"));
	$(obj).parents("div").parents("div").children().next().val($(obj).val());
}

</script>
<?php
			}
		}
	}
	else if ( $view_dt['od_cart_price'] > 0 || $view_dt['od_receipt_price'] > 0 ) {
		$tmp_date2 = date("y-m-d H:i", strtotime($view_dt['od_time']));

		if ( $view_dt['it_gubun'] == "3" ) {
?>

		<div class="voiceSampleSection form">
			<div style="padding:30px 50px;">
    			<div class="orderDetailView">
    				<a href="javascript:;" class="orderDetailViewCtrl">
    					<strong><?php echo $view_dt['it_origin']; ?>님의 답변</strong>
    					<span><?php echo $tmp_date2; ?>(<?php echo get_yoil($view_dt['od_time']); ?>)</span>
    				</a>
    				<ul class="orderDetailViewCont">
    					<li>
    						<span>내용</span>
    						<div>
    							<?php echo nl2br($view_dt['od_memo']); ?>
    						</div>
    					</li>
    					<li>
    						<span>견적 금액</span>
    						<div>
    							<?php echo $view_dt['od_cart_price'] > 0 ? number_format($view_dt['od_cart_price']) : number_format($view_dt['od_receipt_price']); ?>
    						</div>
    					</li>
    					<li>
    						견적금액에 합의하시면 바로 결제를 진행해 주시고 추가문의사항이 있으실경우 쪽지보내기를 이용해주세요.
    					</li>
    				</ul>
    			</div>
			</div>
		</div>
<?php
		}
		if ( $od_status == "거래합의중" || ( $member['mb_gubun'] != "3" && $od_status == "채택완료" && $view_dt['it_gubun'] == "2" ) ) {
			require_once(G5_SHOP_PATH.'/settle_'.$default['de_pg_service'].'.inc.php');
			require_once(G5_SHOP_PATH.'/settle_kakaopay.inc.php');

			if( $default['de_inicis_lpay_use'] ){   //이니시스 Lpay 사용시
				require_once(G5_SHOP_PATH.'/inicis/lpay_common.php');
			}

			// 결제대행사별 코드 include (스크립트 등)
			require_once(G5_SHOP_PATH.'/'.$default['de_pg_service'].'/orderform.1.php');

			if( $default['de_inicis_lpay_use'] ){   //이니시스 L.pay 사용시
				require_once(G5_SHOP_PATH.'/inicis/lpay_form.1.php');
			}

			if($is_kakaopay_use) {
				require_once(G5_SHOP_PATH.'/kakaopay/orderform.1.php');
			}

			$tot_sell_price = $view_dt['od_cart_price'];
			$send_cost = 0;
			$tot_price = $tot_sell_price + $send_cost;
	        $comm_tax_mny = 0; // 과세금액
			$comm_vat_mny = 0; // 부가세
			$comm_free_mny = 0; // 면세금액
			$tot_tax_mny = 0;

			$goods = $view_dt['it_name'];

			//$od_id = get_uniqid();
			set_session('ss_order_id', $view_dt['od_id']);
			set_session('ss_order_inicis_id', $view_dt['od_id']);
			$sw_direct = 1;

			// cart id 설정
			set_session('ss_cart_direct', $view_dt['ct_id']);

?>
		<form id="oform2" name="oform2" method="post" action="./voiceMypageOrderDetail_update.php">
		<input type="hidden" id="it_id" name="it_id" value="<?php echo $_REQUEST['it_id']; ?>">
		<input type="hidden" id="it_gubun" name="it_gubun" value="<?php echo $_REQUEST['it_gubun']; ?>">
		<input type="hidden" id="sch" name="sch" value="<?php echo $_REQUEST['sch']; ?>">
		<input type="hidden" id="sch_val" name="sch_val" value="<?php echo $_REQUEST['sch_val']; ?>">
		<input type="hidden" id="sod_status" name="sod_status" value="<?php echo $_REQUEST['sod_status']; ?>">
		<input type="hidden" id="page" name="page" value="<?php echo $_REQUEST['page']; ?>">
		<input type="hidden" id="od_id" name="od_id" value="<?php echo $view_dt['od_id']; ?>">
		<input type="hidden" id="ct_id" name="ct_id" value="<?php echo $view_dt['ct_id']; ?>">
		<input type="hidden" id="mode" name="mode" value="pay">
		<input type="hidden" name="sw_direct" value="1">
		<input type="hidden" name="od_price"    value="<?php echo $tot_price; ?>">
        <input type="hidden" name="org_od_price"    value="<?php echo $tot_price; ?>">
        <input type="hidden" name="od_send_cost" value="<?php echo $send_cost; ?>">
        <input type="hidden" name="od_send_cost2" value="0">
        <input type="hidden" name="item_coupon" value="0">
        <input type="hidden" name="od_coupon" value="0">
        <input type="hidden" name="od_send_coupon" value="0">
        <input type="hidden" name="od_goods_name" value="<?php echo $goods; ?>">
		<input type="hidden" name="od_name" value="<?php echo $member['mb_name']; ?>" id="od_name" required class="frm_input required" maxlength="20">
		<input type="hidden" name="od_tel" value="<?php echo $member['mb_hp']; ?>" id="od_tel" required class="frm_input required" maxlength="20">
		<input type="hidden" name="od_hp" value="<?php echo $member['mb_hp']; ?>" id="od_hp" class="frm_input" maxlength="20">
		<input type="hidden" name="od_zip" value="28921" id="od_zip" required class="frm_input required" size="8" maxlength="6" placeholder="우편번호">
		<input type="hidden" name="od_addr1" value="서울특별시 성동구 아차산로 7길" id="od_addr1" required class="frm_input frm_address required" size="60" placeholder="기본주소">
		<input type="hidden" name="od_addr2" value="15-1 3층 316호" id="od_addr2" class="frm_input frm_address" size="60" placeholder="상세주소">
		<input type="hidden" name="od_addr3" value="" id="od_addr3" class="frm_input frm_address" size="60" readonly="readonly" placeholder="참고항목">
		<input type="hidden" name="od_addr_jibeon" value="">
		<input type="hidden" name="od_email" value="<?php echo $member['mb_email']; ?>" id="od_email" required class="frm_input required" size="35" maxlength="100">
		<input type="hidden" name="od_b_name" value="<?php echo $member['mb_name']; ?>" id="od_b_name" required class="frm_input required" maxlength="20">
		<input type="hidden" name="od_b_tel" value="<?php echo $member['mb_hp']; ?>" id="od_b_tel" required class="frm_input required" maxlength="20">
		<input type="hidden" name="od_b_hp" value="<?php echo $member['mb_hp']; ?>" id="od_b_hp" class="frm_input" maxlength="20">
		<input type="hidden" name="od_b_zip" value="28921" id="od_b_zip" required class="frm_input required" size="8" maxlength="6" placeholder="우편번호">
		<input type="hidden" name="od_b_addr1" value="서울특별시 성동구 아차산로 7길" id="od_b_addr1" required class="frm_input frm_address required" size="60" placeholder="기본주소">
		<input type="hidden" name="od_b_addr2" value="15-1 3층 316호" id="od_b_addr2" class="frm_input frm_address" size="60" placeholder="상세주소">
		<input type="hidden" name="od_b_addr3" value="" id="od_b_addr3" readonly="readonly" class="frm_input frm_address" size="60" placeholder="참고항목">
		<input type="hidden" name="od_b_addr_jibeon" value="">
		<input type="hidden" name="od_memo" id="od_memo" value="">	
<?php
        // 결제대행사별 코드 include (결제대행사 정보 필드)
        require_once(G5_SHOP_PATH.'/'.$default['de_pg_service'].'/orderform.2.php');

        if($is_kakaopay_use) {
            require_once(G5_SHOP_PATH.'/kakaopay/orderform.2.php');
        }
?>
		<div id="od_pay_sl">
            <?php
            /*
            if (!$default['de_card_point'])
                echo '<p id="sod_frm_pt_alert"><strong>무통장입금</strong> 이외의 결제 수단으로 결제하시는 경우 포인트를 적립해드리지 않습니다.</p>';
             */

            $multi_settle = 0;
            $checked = '';

            $escrow_title = "";
            if ($default['de_escrow_use']) {
                $escrow_title = "에스크로<br>";
            }

            if ($is_kakaopay_use || $default['de_bank_use'] || $default['de_vbank_use'] || $default['de_iche_use'] || $default['de_card_use'] || $default['de_hp_use'] || $default['de_easy_pay_use'] || $default['de_inicis_lpay_use']) {
                echo '<fieldset id="sod_frm_paysel" class="sod_frm_paysel__">';
                echo '<legend>결제방법 선택</legend>';
            }

            // 카카오페이
            if($is_kakaopay_use) {
                $multi_settle++;
                echo '<input type="radio" id="od_settle_kakaopay" name="od_settle_case" value="KAKAOPAY" '.$checked.'> <label for="od_settle_kakaopay" class="kakaopay_icon lb_icon">KAKAOPAY</label>'.PHP_EOL;
                $checked = '';
            }

            // 무통장입금 사용
            if ($default['de_bank_use']) {
                $multi_settle++;
                echo '<input type="radio" id="od_settle_bank" name="od_settle_case" value="무통장" '.$checked.'> <label for="od_settle_bank" class="lb_icon bank_icon">무통장입금</label>'.PHP_EOL;
                $checked = '';
            }

            // 가상계좌 사용
            if ($default['de_vbank_use']) {
                $multi_settle++;
                echo '<input type="radio" id="od_settle_vbank" name="od_settle_case" value="가상계좌" '.$checked.'> <label for="od_settle_vbank" class="lb_icon vbank_icon">'.$escrow_title.'가상계좌</label>'.PHP_EOL;
                $checked = '';
            }

            // 계좌이체 사용
            if ($default['de_iche_use']) {
                $multi_settle++;
                echo '<input type="radio" id="od_settle_iche" name="od_settle_case" value="계좌이체" '.$checked.'> <label for="od_settle_iche" class="lb_icon iche_icon">'.$escrow_title.'계좌이체</label>'.PHP_EOL;
                $checked = '';
            }

            // 휴대폰 사용
            if ($default['de_hp_use']) {
                $multi_settle++;
                echo '<input type="radio" id="od_settle_hp" name="od_settle_case" value="휴대폰" '.$checked.'> <label for="od_settle_hp" class="lb_icon hp_icon">휴대폰</label>'.PHP_EOL;
                $checked = '';
            }

            // 신용카드 사용
            if ($default['de_card_use']) {
                $multi_settle++;
                echo '<input type="radio" id="od_settle_card" name="od_settle_case" value="신용카드" '.$checked.'> <label for="od_settle_card" class="lb_icon card_icon">신용카드</label>'.PHP_EOL;
                $checked = '';
            }

            // PG 간편결제
            if($default['de_easy_pay_use']) {
                switch($default['de_pg_service']) {
                    case 'lg':
                        $pg_easy_pay_name = 'PAYNOW';
                        break;
                    case 'inicis':
                        $pg_easy_pay_name = 'KPAY';
                        break;
                    default:
                        $pg_easy_pay_name = 'PAYCO';
                        break;
                }

                $multi_settle++;
                echo '<input type="radio" id="od_settle_easy_pay" name="od_settle_case" value="간편결제" '.$checked.'> <label for="od_settle_easy_pay" class="'.$pg_easy_pay_name.' lb_icon">'.$pg_easy_pay_name.'</label>'.PHP_EOL;
                $checked = '';
            }

            //이니시스 Lpay
            if($default['de_inicis_lpay_use']) {
                echo '<input type="radio" id="od_settle_inicislpay" data-case="lpay" name="od_settle_case" value="lpay" '.$checked.'> <label for="od_settle_inicislpay" class="inicis_lpay lb_icon">L.pay</label>'.PHP_EOL;
                $checked = '';
            }

            $temp_point = 0;
            // 회원이면서 포인트사용이면
            if ($is_member && $config['cf_use_point'])
            {
                // 포인트 결제 사용 포인트보다 회원의 포인트가 크다면
                if ($member['mb_point'] >= $default['de_settle_min_point'])
                {
                    $temp_point = (int)$default['de_settle_max_point'];

                    if($temp_point > (int)$tot_sell_price)
                        $temp_point = (int)$tot_sell_price;

                    if($temp_point > (int)$member['mb_point'])
                        $temp_point = (int)$member['mb_point'];

                    $point_unit = (int)$default['de_settle_point_unit'];
                    $temp_point = (int)((int)($temp_point / $point_unit) * $point_unit);
            ?>
            <div class="sod_frm_point">
                <div>
                    <label for="od_temp_point">사용 포인트(<?php echo $point_unit; ?>점 단위)</label>
                    <input type="hidden" name="max_temp_point" value="<?php echo $temp_point; ?>">
                    <input type="text" name="od_temp_point" value="0" id="od_temp_point"  size="7"> 점
                </div>
                <div id="sod_frm_pt">
                    <span><strong>보유포인트</strong><?php echo display_point($member['mb_point']); ?></span>
                    <span class="max_point_box"><strong>최대 사용 가능 포인트</strong><em id="use_max_point"><?php echo display_point($temp_point); ?></em></span>
                </div>
            </div>
            <?php
                $multi_settle++;
                }
            }

            if ($default['de_bank_use']) {
                // 은행계좌를 배열로 만든후
                $str = explode("\n", trim($default['de_bank_account']));
                if (count($str) <= 1)
                {
                    $bank_account = '<input type="hidden" name="od_bank_account" value="'.$str[0].'">'.$str[0].PHP_EOL;
                }
                else
                {
                    $bank_account = '<select name="od_bank_account" id="od_bank_account">'.PHP_EOL;
                    $bank_account .= '<option value="">선택하십시오.</option>';
                    for ($i=0; $i<count($str); $i++)
                    {
                        //$str[$i] = str_replace("\r", "", $str[$i]);
                        $str[$i] = trim($str[$i]);
                        $bank_account .= '<option value="'.$str[$i].'">'.$str[$i].'</option>'.PHP_EOL;
                    }
                    $bank_account .= '</select>'.PHP_EOL;
                }
                echo '<div id="settle_bank" style="display:none">';
                echo '<label for="od_bank_account" class="sound_only">입금할 계좌</label>';
                echo $bank_account;
                echo '<br><label for="od_deposit_name">입금자명</label> ';
                echo '<input type="text" name="od_deposit_name" id="od_deposit_name" size="10" maxlength="20">';
                echo '</div>';
                ?>

                <!--
                마크업 내용들이 none처리 되어있으니,
                세금계산서 / 현금영수증 시작(위에 675~ 680 지워주세요~)
                 690~ 스크립트 주석 풀어주세요~
              -->
              <!--세금계산서 / 현금영수증 마크업 시작-->

                <script type="text/javascript">
                // $(function(){
                //   //신용카드 에서만 안보이게
                //   $("#od_settle_card").on("click",function(){
                //     $("#tax_cash").hide();
                //   });
                //   $("#od_settle_iche,#od_settle_bank,#od_settle_vbank,#od_settle_hp,#od_settle_easy_pay,#od_settle_kakaopay").on("click",function(){
                //     $("#tax_cash").show();
                //   });
                // });

                </script>
                <div id="tax_cash"  style="display:none;">
                  <!--무통장일때, 계좌번호 노출-->
                  <div id="settle_bank">
                    <div class="orderDetailView">
                				<ul class="orderDetailViewCont">
                					<li>
                						<span>입금할 계좌</span>
                						<div><?php echo $bank_account;?></div>
                					</li>
                					<li>
                						<span>입금자명</span>
                						<div><input type="text" name="od_deposit_name" id="od_deposit_name" size="10" maxlength="20" class="input_100"></div>
                					</li>
                					<li>
                						견적금액에 합의하시면 바로 결제를 진행해 주시고 추가문의사항이 있으실경우 쪽지보내기를 이용해주세요.
                					</li>
                      	</ul>
                    </div>
                </div>
                    <!--//무통장일때, 계좌번호 노출-->

                        <div class="tax_cash_wrap">
                            <p class="tax_cash_title">세금계산서 / 현금영수증 신청</p>

                            <dl class="clearfix">
                              <dt>영수증 종류</dt>
                              <dd class="tax_cash_select">
                                <label><input type="radio" name="tax_cash_select" value="세금계산서"  data-target="tax">세금계산서</label>
                                <label><input type="radio" name="tax_cash_select" value="현금영수증" data-target="cash">현금영수증</label>
                                <label><input type="radio" name="tax_cash_select" value="신청안함"  data-target="none" checked>사용안함</label>
                              </dd>
                            </dl>
                            <script type="text/javascript">
                            $(function(){
                              $(".box_none").hide();
                              $(".tax_cash_select label input").change(function(){
                                $(".tax_cash_select label input").is(":checked")
                                  $(".box_none").hide();
                                  var target = $(this).attr('data-target');
                                  $("."+target).show();
                              });
                            });
                            </script>

                            <!--세금계산서 시작-->
                            <div class="tax_box tax box_none">
                              <dl class="clearfix">
                                <dt>사업장 정보선택</dt>
                                <dd>
                                  <label><input type="radio" name="tax_info" value="신규 정보 입력" data-target="new_info">신규정보 입력</label>
                                  <label><input type="radio" name="tax_info" value="최근 발행한 정보 사용" data-target="old_info">최근 발행한 정보 사용</label>
                                </dd>
                              </dl>

                              <script type="text/javascript">
                              $(function(){
                                $(".box_none").hide();
                                $(".tax_box label input").change(function(){
                                  $(".tax_box label input").is(":checked")
                                    $(".tax_box .box_none").hide();
                                    var target = $(this).attr('data-target');
                                    $("."+target).show();
                                });
                              });
                              </script>

                              <!--신규정보 입력-->
                              <div class="new_info box_none">
                                <dl class="clearfix">
                                  <dt>상호(기관)명</dt>
                                  <dd> <input type="text" name="" value="" class="input_100"> </dd>
                                </dl>
                                <dl class="clearfix">
                                  <dt>대표자명</dt>
                                  <dd><input type="text" name="" value="" class="input_100"> </dd>
                                </dl>
                                <dl class="clearfix">
                                  <dt>사업자등록번호</dt>
                                  <dd><input type="text" name="" value="" class="input_100"></dd>
                                </dl>
                                <dl class="clearfix">
                                  <dt>사업장 소재지</dt>
                                  <dd>
                                    <input type="text" name="" value="" class="input_150">
                                    <button type="button" name="button" class="btn_address">주소검색</button>
                                    <input type="text" name="" value="" class="input_100">
                                    <input type="text" name="" value="" class="input_100">
                                  </dd>
                                </dl>
                                <dl class="clearfix">
                                  <dt>업태</dt>
                                  <dd><input type="text" name="" value="" class="input_100"></dd>
                                </dl>
                                <dl class="clearfix">
                                  <dt>업종</dt>
                                  <dd><input type="text" name="" value="" class="input_100"></dd>
                                </dl>
                                <dl class="clearfix">
                                  <dt>당담자명</dt>
                                  <dd><input type="text" name="" value="" class="input_100"></dd>
                                </dl>
                                <dl class="clearfix">
                                  <dt>받는분 이메일</dt>
                                  <dd><input type="email" name="" value="" class="input_100"></dd>
                                </dl>
                              </div>

                              <!--기존정보 입력-->
                              <div class="old_info box_none">
                                <dl class="clearfix">
                                  <dt>상호(기관)명</dt>
                                  <dd> <input type="text" name="" value="" class="input_100" readonly> </dd>
                                </dl>
                                <dl class="clearfix">
                                  <dt>대표자명</dt>
                                  <dd><input type="text" name="" value="" class="input_100" readonly> </dd>
                                </dl>
                                <dl class="clearfix">
                                  <dt>사업자등록번호</dt>
                                  <dd><input type="text" name="" value="" class="input_100" readonly></dd>
                                </dl>
                                <dl class="clearfix">
                                  <dt>사업장 소재지</dt>
                                  <dd>
                                    <input type="text" name="" value="" class="input_150" readonly>
                                    <input type="text" name="" value="" class="input_100" readonly>
                                    <input type="text" name="" value="" class="input_100" readonly>
                                  </dd>
                                </dl>
                                <dl class="clearfix">
                                  <dt>업태</dt>
                                  <dd><input type="text" name="" value="" class="input_100" readonly></dd>
                                </dl>
                                <dl class="clearfix">
                                  <dt>업종</dt>
                                  <dd><input type="text" name="" value="" class="input_100" readonly></dd>
                                </dl>
                                <dl class="clearfix">
                                  <dt>당담자명</dt>
                                  <dd><input type="text" name="" value="" class="input_100" readonly></dd>
                                </dl>
                                <dl class="clearfix">
                                  <dt>받는분 이메일</dt>
                                  <dd><input type="email" name="" value="" class="input_100" readonly></dd>
                                </dl>
                              </div>
                              </div>


                            <!--현금영수증 시작-->
                            <div class="cash_box cash box_none">
                              <dl class="clearfix">
                                <dt>신청방법</dt>
                                <dd>
                                  <label><input type="radio" name="method" value="휴대폰번호" data-target="cell">휴대폰번호</label>
                                  <label><input type="radio" name="method" value="사업자등록번호" data-target="num">사업자등록번호</label>
                                  <label><input type="radio" name="method" value="현금영수증 카드번호" data-target="card">현금영수증 카드번호</label>
                                </dd>
                              </dl>

                              <script type="text/javascript">
                              $(function(){
                                $(".cash_box .box_none").hide();
                                $(".cash_box label input").change(function(){
                                  $(".cash_box label input").is(":checked")
                                    $(".cash_box .box_none").hide();
                                    var target = $(this).attr('data-target');
                                    $("."+target).show();
                                });
                              });
                              </script>

                              <dl class="clearfix cell box_none show">
                                <dt>휴대폰번호</dt>
                                <dd>
                                  <input type="text" name="" value="" class="input_150">
                                  -
                                  <input type="text" name="" value="" class="input_150">
                                  -
                                  <input type="text" name="" value="" class="input_150">
                                </dd>
                              </dl>
                              <dl class="clearfix num box_none">
                                <dt>사업자등록번호</dt>
                                <dd>
                                  <input type="text" name="" value="" class="input_150">
                                  -
                                  <input type="text" name="" value="" class="input_150">
                                  -
                                  <input type="text" name="" value="" class="input_150">
                                </dd>
                              </dl>
                              <dl class="clearfix card box_none">
                                <dt>현금영수증 카드번호</dt>
                                <dd>
                                  <input type="text" name="" value="" class="input_100px">
                                  -
                                  <input type="text" name="" value="" class="input_100px">
                                  -
                                  <input type="text" name="" value="" class="input_100px">
                                  -
                                  <input type="text" name="" value="" class="input_100px">
                                </dd>
                              </dl>
                            </div>
                            <p class="form_tail">* 입력된 영수증 종보는 증빙용 이외의 다른 용도로 이용되지 않습니다.</p>
                          </div>
                			</div>
                      <!--세금계산서 현금영수증 끝-->

                <?php
            }

            if ($is_kakaopay_use || $default['de_bank_use'] || $default['de_vbank_use'] || $default['de_iche_use'] || $default['de_card_use'] || $default['de_hp_use'] || $default['de_easy_pay_use'] || $default['de_inicis_lpay_use'] ) {
                echo '</fieldset>';
            }

            if ($multi_settle == 0)
                echo '<p>결제할 방법이 없습니다.<br>운영자에게 알려주시면 감사하겠습니다.</p>';
            ?>
            <div style="background-color:#fff;padding:5px 10px;border:1px solid #eceff4;margin-top:-1px;">신용카드 결제시 부가세(10%)가 결제금액에 추가됩니다.</div>
        </div>

		<div class="ctrler" style="padding-bottom:15px;">
			<a id="submit_btn2" class="vSave" onclick="forderform_check(document.oform2);" style="cursor:pointer;">결제하기</a>
			<a id="cancel_btn2" class="vCancel" style="cursor:pointer;">의뢰 취소 하기</a>
		</div>
		<div id="display_pay_process" style="display:none">
			<img src="<?php echo G5_URL; ?>/shop/img/loading.gif" alt="">
			<span>주문완료 중입니다. 잠시만 기다려 주십시오.</span>
		</div>
		</form>
<?php
		}//echo "od_status = ".$od_status;
		if ( ( $od_status == "거래합의중" && ( $view_dt['od_settle_case'] == "가상계좌" || $view_dt['od_settle_case'] == "무통장" ) ) || $od_status == "작업진행중" || $od_status == "작업완료" ) {
?>
		<div class="voiceDetailSection">
			<div style="padding:30px 50px;">
				<div class="orderDetailView">
    				<a href="javascript:;" class="orderDetailViewCtrl">
    					<strong><?php echo $view_dt['it_maker']; ?>님의 결제 내역</strong>
    				</a>

    				<ul class="orderDetailViewCont">
    					<li>
    						<span>결제일</span>
    						<div>
    							<?php echo $view_dt['od_receipt_time']; ?>
    						</div>
    					</li>
    					<li>
    						<span>결제 금액</span>
    						<div>
    							<?php echo number_format($view_dt['od_receipt_price']); ?>원
    						</div>
    					</li>
    					<li>
    						<span>결제 수단</span>
    						<div>
    							<?php echo $view_dt['od_settle_case']; ?>
								<?php
								if ( $view_dt['od_settle_case'] == "가상계좌" || $view_dt['od_settle_case'] == "무통장" ) {
									echo "&nbsp;[ ".$view_dt['od_bank_account']." ]";
								}
								?>
    						</div>
    					</li>
    				</ul>
				</div>
			</div>
		</div>
<?php
		}
		if ( $od_status == "작업진행중" || $od_status == "작업완료" ) {
			$sql = "SELECT * FROM ".$g5['g5_shop_order_voice_table']." WHERE od_id='".$view_dt['od_id']."' ORDER BY ov_id";
			$res11 = sql_query($sql);
			$row_cnt = sql_num_rows($res11);
			if ( $row_cnt > 0 ) {
?>
		<div class="voiceSampleSection form">
			<div style="padding:30px 50px;">
    			<div class="orderDetailView">
    				<a href="javascript:;" class="orderDetailViewCtrl">
    					<strong>작업 완료 파일</strong>
    				</a>
    				<ul class="orderDetailViewCont">
<?php
					for ($i=0; $row=sql_fetch_array($res11); $i++) {
?>
    					<li>
    						<span><?php echo $i+1; ?>차</span>
    						<div>
    							<?php echo $row['ov_voice_name']; ?>&nbsp;&nbsp;&nbsp;<a href="./download2.php?ov_id=<?php echo $row['ov_id']; ?>" class="downloadBtn">Download</a>
    						</div>
    					</li>
<?php
					}
?>
    				</ul>
    			</div>
			</div>
		</div>
<?php
			}
		}
		if ( $od_status == "작업진행중" && $member['mb_gubun'] != "3" ) {
?>
		<form id="oform4" name="oform4" method="post" action="./voiceMypageOrderDetail_update.php">
		<input type="hidden" id="it_id" name="it_id" value="<?php echo $_REQUEST['it_id']; ?>">
		<input type="hidden" id="it_gubun" name="it_gubun" value="<?php echo $_REQUEST['it_gubun']; ?>">
		<input type="hidden" id="sch" name="sch" value="<?php echo $_REQUEST['sch']; ?>">
		<input type="hidden" id="sch_val" name="sch_val" value="<?php echo $_REQUEST['sch_val']; ?>">
		<input type="hidden" id="sod_status" name="sod_status" value="<?php echo $_REQUEST['sod_status']; ?>">
		<input type="hidden" id="page" name="page" value="<?php echo $_REQUEST['page']; ?>">
		<input type="hidden" id="od_id" name="od_id" value="<?php echo $view_dt['od_id']; ?>">
		<input type="hidden" id="ct_id" name="ct_id" value="<?php echo $view_dt['ct_id']; ?>">
		<input type="hidden" id="mode" name="mode" value="complete">
		<div class="ctrler">
			작업이 완료었다면, 아래 작업 완료 버튼을 클릭하여 상태를 변경해주세요.
			<br /><br />
			<a id="complete_btn" class="vSave" style="cursor:pointer;">작업 완료</a>
		</div>
		</form>
<?php
		}
		if ( $od_status == "작업완료" ) {
?>
<!--
		<div class="ctrler">
			해당 거래에 대한 리뷰를 남겨주세요!
			<br /><br />
			<a class="vSave" style="cursor:pointer;">리뷰 작성하기</a>
		</div>
 -->
<?php
		}
	}
?>

<?php
}
?>
	</div>

<script type="text/javascript">
$(function(){
	$(".orderDetailViewCtrl").each(function(ctrlIdx){
		$(this).click(function(){
			if($(this).hasClass("on")){
				$(".orderDetailViewCont").eq(ctrlIdx).slideDown(500);
			} else {
				$(".orderDetailViewCont").eq(ctrlIdx).slideUp(500);
			};
			$(this).toggleClass("on");
		});
	});

	$("input[name=od_settle_case]").click(function() {
		if ( $(this).val() == "무통장" ) {
			$("#settle_bank").show();
		}
		else {
			$("#settle_bank").hide();
		}
	});

	$("#complete_btn").click(function() {
		if ( confirm( "작업 완료하시겠습니까?" ) ) {
			$("#oform4").submit();
		}
		return;
	});

	$("#cancel_btn").click(function() {
		if ( confirm( "의뢰 취소하시겠습니까?" ) ) {
			$("#mode").val("cancel");
			$("#oform").submit();
		}
		return;
	});

	$("#cancel_btn2").click(function() {
		if ( confirm( "의뢰 취소하시겠습니까?" ) ) {
			$("#mode").val("cancel");
			$("#oform2").submit();
		}
		return;
	});


	$("#submit_btn").click(function() {
		/*
		if ( $("#od_memo").val() == "" ) {
			alert( "내용을 입력해 주세요." );
			$("#od_memo").focus();
			return;
		}
		*/
		if ( $("#od_cart_price").val() == "" ) {
			alert( "견적금액을 입력해 주세요." );
			$("#od_cart_price").focus();
			return;
		}
		$(this).hide();

		$("#oform").submit();
	});
});


function forderform_check(f) {
	var settle_method = "";

	$("input[name=buyername]").val($("#od_name").val());
	$("input[name=buyeremail]").val($("#od_email").val());
	$("input[name=buyertel]").val($("#od_tel").val());
	$("input[name=recvname]").val($("#od_b_name").val());
	$("input[name=recvtel]").val($("#od_b_hp").val());
	$("input[name=recvpostnum]").val($("#od_b_zip").val());
	$("input[name=recvaddr]").val($("#od_b_addr1").val() + " " + $("#od_b_addr2").val());

	var cnt = 0;
	$('input[name="od_settle_case"]').each(function(i) {
		if ( $(this).is(":checked") == true ) {
			cnt ++;
		}
	});
	//console.log("log = " + cnt);
	if ( cnt <= 0 ) {
		alert( "결재수단을 선택해 주세요." );
		return;
	}
	if ( $('input[name="od_settle_case"]:checked').val() == "무통장" ) {
		if ( $("#od_deposit_name").val() == "" ) {
			alert( "입금자명을 입력해 주세요." );
			$("#od_deposit_name").focus();
			return;
		}
	}

	settle_method = $('input[name="od_settle_case"]:checked').val();

	switch(settle_method)
	{
		case "계좌이체":
			$("input[name=gopaymethod]").val("DirectBank");
			break;
		case "가상계좌":
			$("input[name=gopaymethod]").val("VBank");
			break;
		case "휴대폰":
			$("input[name=gopaymethod]").val("HPP");
			break;
		case "신용카드":
			$("input[name=gopaymethod]").val("Card");
			$("input[name=acceptmethod]").val($("input[name=acceptmethod]").val().replace(":useescrow", ""));
			break;
		case "간편결제":
			$("input[name=gopaymethod]").val("Kpay");
			break;
		case "lpay":
			$("input[name=gopaymethod]").val("onlylpay");
			$("input[name=acceptmethod]").val($("input[name=acceptmethod]").val()+":cardonly");
			break;
		default:
			$("input[name=gopaymethod]").val("무통장");
			break;
	}

	if ( settle_method == "신용카드" ) {
		//org_od_price , od_price, good_mny, price
		var vat = eval ( $("input[name=org_od_price]").val() + " + " + $("input[name=org_od_price]").val() + " * 0.1" );
		$("input[name=od_price]").val(vat);
		$("input[name=good_mny]").val(vat);
		$("input[name=price]").val(vat);
	}
	else {
		var vat = $("input[name=org_od_price]").val();
		$("input[name=od_price]").val(vat);
		$("input[name=good_mny]").val(vat);
		$("input[name=price]").val(vat);
	}
//alert(vat);return;
	if( $("input[name=gopaymethod]").val() != "무통장") {

		// 주문정보 임시저장
		var order_data = $(f).serialize();
		var save_result = "";
		$.ajax({
			type: "POST",
			data: order_data,
			url: g5_url+"/shop/ajax.orderdatasave.php",
			cache: false,
			async: false,
			success: function(data) {
				save_result = data;
			}
		});

		if(save_result) {
			alert(save_result);
			return false;
		}


		if(!make_signature(f))
			return false;

		paybtn(f);
	} else {
		f.submit();
	}
}
</script>


<?php
include_once('./voiceRight.php');
?>
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
