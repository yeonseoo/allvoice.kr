﻿<?php
include_once('./_common.php');

// 작업의뢰 프로젝트가 없는경우
if (!$_REQUEST['it_id'])
    alert_close('선택하신 작업의뢰프로젝트가 없습니다.');

include_once(G5_MSHOP_PATH.'/_head.php');

$_REQUEST['page'] = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
if ($_REQUEST['page'] < 1) { $_REQUEST['page'] = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$_REQUEST['orderby'] = isset($_REQUEST['orderby']) ? $_REQUEST['orderby'] : "a.it_id DESC";
$_REQUEST['cat'] = isset($_REQUEST['cat']) ? $_REQUEST['cat'] : "10";

include_once('./_head.php');

$sql = "SELECT * FROM ".$g5['g5_shop_cart_table']." WHERE it_id='".$_REQUEST['it_id']."' AND mb_id='".$member['mb_id']."' AND ct_select='1' AND ct_status NOT IN ('취소','지원취소') ";
//echo $sql;
$cart_dt = sql_fetch($sql);

$qry = "SELECT a.*, b.ca_name, c.mb_name, IFNULL(d.cnt,0) cnt FROM ".$g5['g5_shop_item_table']." AS a JOIN ".$g5['g5_shop_category_table']." AS b ON a.ca_id=b.ca_id JOIN ".$g5['member_table']." AS c ON a.it_maker=c.mb_id LEFT JOIN (SELECT it_id, COUNT(*) AS cnt FROM ".$g5['g5_shop_cart_table']." WHERE ct_select='1' AND ct_status NOT IN ('취소','지원취소') GROUP BY it_id) d ON a.it_id=d.it_id WHERE a.it_id='".$_REQUEST['it_id']."' ";
$view_dt = sql_fetch($qry);
//print_r($qry);
//echo "test";exit;
// 채택이 된 경우 
if ( $view_dt['it_maker'] != $member['mb_id'] && $view_dt['it_gubun'] != "1" )
    alert_close('선택하신 작업의뢰프로젝트가 없습니다.');

// 마감시한이 지난 경우
if ( $view_dt['it_maker'] != $member['mb_id'] && $view_dt['it_view_time'] < date("Y-m-d H:i:s") )
    alert_close('선택하신 작업의뢰프로젝트가 없습니다.');

$mb_dir = substr($view_dt['it_maker'],0,2);
$icon_url = G5_DATA_URL.'/member_image/'.$mb_dir.'/'.$view_dt['it_maker'].'.gif';
$icon_url = is_file(G5_DATA_PATH.'/member_image/'.$mb_dir.'/'.$view_dt['it_maker'].'.gif') ? $icon_url : "/theme/basic/img/profileSample.jpg";
?>

<!-- 성우상세 { -->


<div class="voiceDetail">
	<div class="voiceProfile on">
		<div>
			<img src="<?php echo $icon_url; ?>" />
			<strong><?php echo $view_dt['mb_name']; ?>(<?php echo $view_dt['it_maker']; ?>)</strong>
		</div>
		<hr />
	</div>
	<div class="profileOption">
		<a href="javascript:;" class="sendMassage memoPop" style="width:100%;"><img src="../theme/basic/img/btn_pPost.png" />쪽지보내기</a>
	</div>
	
	<div class="voiceDetailInfo">
		<div class="voiceDetailSection">
			<div class="voiceDetailTab tab3">
    			<ul>
    				<li class="on"><a href="javascript:;">상세 정보</a></li>
    				<li><a href="javascript:;">지원자 현황</a></li>
					<li><a href="javascript:;">취소 및 환불규정</a></li>
    			</ul>
			</div>
			
			<div class="voiceDetailProfile">
				<span><?php echo $view_dt['ca_name']; ?> / <?php echo $gender_arr[$view_dt['it_1']]; ?> / <?php echo $age_arr[$view_dt['it_2']]; ?> / <?php echo $style_arr[$view_dt['it_3']]; ?> / <?php echo $tone_arr[$view_dt['it_4']]; ?> / <?php echo $language_arr[$view_dt['it_5']]; ?> / <?php echo $script_arr[$view_dt['it_6']]; ?></span>
				<strong><?php echo $view_dt['it_name']; ?></strong>
				<hr>
				<p>
                    <i>마감일</i><br />
                    <?php echo $view_dt['it_view_time']; ?><br /><br />
                    <i>지원자</i><br />
                    <?php echo $view_dt['cnt']; ?> 명
                </p>
				<hr>
				<p>
                     <?php echo nl2br($view_dt['it_explan']); ?>
				</p>
				<hr>
				<p>
    				<i>샘플 문장</i><br />
    				<?php echo nl2br($view_dt['it_explan2']); ?>
				</p>
				<hr>
				<div class="pdfDown">
					<span style="line-height:30px;">대본 스크립트 : <?php echo $view_dt['it_8']; ?></span>
					<?php if ( $member['mb_gubun'] == "3" || $view_dt['it_maker'] == $member['mb_id'] ) { ?><a href="<?php if ( $_set_device ) { ?>#download_functions|download_url$<?php echo G5_SHOP_URL; ?>/download.php?it_id=<?php echo $view_dt['it_id']; ?>|download_name$<?php echo $view_dt['it_8']; ?><?php } else { ?>./download.php?it_id=<?php echo $view_dt['it_id']; ?><?php } ?>" class="downloadBtn">Download</a><?php } ?>
				</div>
				<hr>
				<div class="projectApply">
					<span>금액 <?php echo number_format($view_dt['it_price']); ?> 원</span>
<?php
// 성우회원인 경우에만 지원하기 / 지원취소 버튼이 보임
// 채택이 되기전 / 마감일이 되기전까지만
if ( $member['mb_gubun'] == "3" && $view_dt['it_view_time'] >= date("Y-m-d H:i:s") && $view_dt['it_gubun'] == 1 ) {
	if ( !$cart_dt['ct_id'] ) {
?>
					<div class="btnGetAgree">
    					<a href="javascript:;">지원하기</a>
    				</div>
<?php
	}
	else {
?>
    				<div class="btnGetNotAgree">
    					<a href="javascript:;">지원취소</a>
    				</div>
<?php
	}
}
?>
				</div>
			</div>
		</div>
		
		<div class="voiceDetailSection">
			<div class="voiceDetailTab tab3">
    			<ul>
    				<li><a href="javascript:;">상세 정보</a></li>
    				<li class="on"><a href="javascript:;">지원자 현황</a></li>
					<li><a href="javascript:;">취소 및 환불규정</a></li>
    			</ul>
			</div>
			
			<div>
    			<div class="voiceLv">
    				<i>해당 프로젝트에 <em><?php echo $view_dt['cnt']; ?></em>명이 지원하였습니다.</i>
    			</div>
    			<br /><br />
<?php
// 작업의뢰프로젝트에 의뢰한 회원만 보이도록 제한
if ( $view_dt['it_maker'] == $member['mb_id'] ) {
	$qry = "SELECT a.*, c.mb_name FROM ".$g5['g5_shop_cart_table']." AS a JOIN ".$g5['g5_shop_order_table']." AS b ON a.od_id=b.od_id JOIN ".$g5['member_table']." AS c ON a.mb_id=c.mb_id WHERE a.it_id='".$_REQUEST['it_id']."' AND ct_select='1' AND ct_status NOT IN ('취소','지원취소') ORDER BY ct_id DESC ";
	//echo $qry;
	$res = sql_query($qry);
	$row_cnt = sql_num_rows($res);

	if ( $row_cnt > 0 ) {
?>

<script type="text/javascript">
$(function(){
	//$('.mediPlayer').mediaPlayer();
});
</script>
<?php
	}
?>
    			<div class="listDataApplyer">
            		<ul>
<?php

	for ($i=0; $row=sql_fetch_array($res); $i++) {
		$mb_dir = substr($row['mb_id'],0,2);
		$icon_url = G5_DATA_URL.'/member_image/'.$mb_dir.'/'.$row['mb_id'].'.gif';
		$icon_url = is_file(G5_DATA_PATH.'/member_image/'.$mb_dir.'/'.$row['mb_id'].'.gif') ? $icon_url : "../theme/basic/img/profileSample.jpg";
		$audio_url = G5_DATA_URL.'/order/'.$row['od_id'].'/'.$row['ct_option'];
?>
                		<li>
                			<div class="circularPlayerWrap">
								<a href="/shop/voiceDetail.php?mb_id=<?php echo $row['mb_id']; ?>"><span><img src="<?php echo $icon_url ?>" /></span><?php echo $row['mb_name']; ?></a>
								<!-- 
								<div class="mediPlayer">
									<audio class="listen" preload="none" src="<?php echo $audio_url ?>"></audio>
								</div>
								 -->
							</div>
							<p>
								<a href="<?php if ( $_set_device ) { ?>#download_functions|download_url$<?php echo G5_SHOP_URL; ?>/download3.php?ct_id=<?php echo $row['ct_id']; ?>|download_name$<?php echo $row['ct_option']; ?><?php } else { ?>./download3.php?ct_id=<?php echo $row['ct_id']; ?><?php } ?>" class="downloadBtn2" style="cursor:pointer;">샘플다운로드</a>
                    			<a data-id="<?php echo $row['od_id']; ?>" data-name="<?php echo $row['mb_name']; ?>" data-origin="<?php echo $row['mb_id']; ?>" class="downloadBtn confirm_btn" style="cursor:pointer;">채택하기</a>
							</p>
                		</li>
                		<!--li>
                			<a href="/shop/voiceDetail.php"><img src="../theme/basic/img/voiceList/01.png" />이용신</a>
                			<a href="javascript:;" class="downloadBtn">채택하기</a>
                		</li-->
<?php
	}
?>
                	</ul>
        		</div>
<?php
}
?>
    		</div>
		</div>
		<div class="voiceDetailSection">
			<div class="voiceDetailTab tab3">
    			<ul>
    				<li><a href="javascript:;">상세 정보</a></li>
    				<li><a href="javascript:;">지원자 현황</a></li>
    				<li class="on"><a href="javascript:;">취소 및 환불규정</a></li>
    			</ul>
			</div>
			
			<div>
<?php echo $default['de_change_content']; ?>
			</div>
		</div>
	</div>
</div>


<div id="orderPopupCover"></div>
<div id="orderPopup" style="height:auto;top:50%;transform:translateY(-50%);">
<form id="fitemform" name="fitemform" action="./voiceProjectDetail_update.php" method="post" enctype="MULTIPART/FORM-DATA" autocomplete="off">
<input type="hidden" name="it_id" value="<?php echo $_REQUEST['it_id']; ?>">
<input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>">
<input type="hidden" name="orderby" value="<?php echo $_REQUEST['orderby']; ?>">
<input type="hidden" name="cat" value="<?php echo $_REQUEST['cat']; ?>">
	<div class="orderForm">
		<strong>프로젝트 지원하기</strong>
		<ul style="height:auto;overflow:hidden;">
			<li class="full"><span>샘플음성</span><div class="fakeFile" style="margin-top:0;">
								<input type="text" id="ct_option_name" name="ct_option_name" />
								<div><input type="file" id="ct_option" name="ct_option" /></div>
							</div></li>
		</ul>
		<div class="ctrler">
			<a id="submit_btn" class="vSave" style="cursor:pointer;">확인</a>
			<a href="javascript:;" class="vCancel">취소</a>
		</div>
    	<a href="javascript:;">Ⅹ</a>
	</div>
</form>
</div>

<script type="text/javascript">
$(function(){
	$(".confirm_btn").click(function() {
		if ( confirm( $(this).data("name") + "님을 채택하시겠습니까?" ) ) {
			location.href="./voiceProjectDetail_update.php?mode=confirm&od_id="+$(this).data("id")+"&it_id=<?php echo $_REQUEST['it_id']; ?>&page=<?php echo $_REQUEST['page']; ?>&cat=<?php echo $_REQUEST['cat']; ?>&orderby=<?php echo $_REQUEST['orderby']; ?>&origin="+$(this).data("origin");
			return;
		}
		return;
	});

	$(".btnGetNotAgree").click(function() {
		if ( confirm( "<?php echo $view_dt['it_name']; ?> 지원내역을 취소하시겠습니까?" ) ) {
			location.href="./voiceProjectDetail_update.php?mode=cancel&it_id=<?php echo $_REQUEST['it_id']; ?>&page=<?php echo $_REQUEST['page']; ?>&cat=<?php echo $_REQUEST['cat']; ?>&orderby=<?php echo $_REQUEST['orderby']; ?>";
			return;
		}
		return;
	});

	$(".btnGetAgree a").click(function(){
		$("#orderPopupCover").show();
		$("#orderPopup").show();
	});

	$(".orderForm > a").click(function(){
		$("#orderPopupCover").hide();
		$("#orderPopup").hide();
	});

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

	$("#ct_option").change(function() {
		$("#ct_option_name").val($(this).val());
	});

	$("#submit_btn").click(function() {
		if ( $("#ct_option").val() == "" ) {
			alert("샘플파일을 입력해 주세요.");
			$("#ct_option").focus();
			return;
		}
		$(this).hide();

		$("#fitemform").submit();
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
<?php
if ( $member['mb_id'] ) {
?>
		<iframe src="/bbs/memo_form.php?me_recv_mb_id=<?php echo $view_dt['it_maker']; ?>"></iframe>
<?php
}
?>
	</div>
</div>
    
<script type="text/javascript">
$(function(){
	var loadCnt = 0;
	//<?php echo G5_BBS_URL ?>/password_lost.php
	$(".memoPop").attr("href","javascript:;");
	$(".memoPop").click(function(){
		<?php
		if ( $member['mb_id'] ) {
		?>
		$("#memoCover").show();
		$("#memoPop").show();
		<?php
		}
		else {
		?>
		alert("회원만 이용하실 수 있습니다.");
		<?php
		}
		?>
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