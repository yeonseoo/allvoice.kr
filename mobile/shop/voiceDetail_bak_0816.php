<?php
include_once('./_common.php');

include_once(G5_MSHOP_PATH.'/_head.php');


$sql = " select * from {$g5['g5_shop_category_table']} ";
//if ($is_admin != 'super')
//    $sql .= " where ca_mb_id = '{$member['mb_id']}' ";
$sql .= " order by ca_order, ca_id ";
$result = sql_query($sql);
$dt = NULL;
for ($i=0; $row=sql_fetch_array($result); $i++)
{
	$dt[$row['ca_id']] = $row['ca_1'];
	$category_arr[$row['ca_id']] = $row['ca_name'];
}

if ($_REQUEST['mb_id']) {
	$where = " WHERE mb_id='".$_REQUEST['mb_id']."' ";
}
else {
	$where = " WHERE mb_no='".$_REQUEST['it_id']."' ";
}

$sql = "SELECT * FROM ".$g5['member_table']." ".$where." ";
$mem_dt = sql_fetch($sql);

$_REQUEST['mb_id'] = $mem_dt['mb_id'];

$row = sql_fetch ( "SELECT b.* FROM ".$g5['g5_shop_cart_table']." AS a JOIN ".$g5['g5_shop_item_table']." AS b ON a.it_id=b.it_id JOIN ".$g5['g5_shop_order_table']." AS c ON a.od_id=c.od_id WHERE b.it_maker='".$member['mb_id']."' AND b.it_origin='".$_REQUEST['mb_id']."' AND c.od_status IN ('작업진행중') " );
//print_r($row);
if ( $row['it_id'] ) {
	$bizId = "allvoice";
	$mmdd = date("md");
	$secure = "67aec2b09241800da27133ea01d58a4d676034feb3a0c0a4dd2f907458c26c74";
	$secureCode = hash("sha256", $bizId.$mmdd.$secure);
	//echo $secureCode;
	$s_url = "https://bizapi.callmix.co.kr/biz050/BZV100?secureCode=".$secureCode."&bizId=".$bizId."&monthDay=".$mmdd."&selGbn=3&reqCnt=1";
	//echo $s_url;
	//$vno_str = file_get_contents($s_url);
	if (function_exists('curl_init')) {
		// curl 리소스를 초기화
		$ch = curl_init();

		// url을 설정
		curl_setopt($ch, CURLOPT_URL, $s_url);

		// 헤더는 제외하고 content 만 받음
		curl_setopt($ch, CURLOPT_HEADER, 0);

		// 응답 값을 브라우저에 표시하지 말고 값을 리턴
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// 브라우저처럼 보이기 위해 user agent 사용
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0');

		$vno_str = curl_exec($ch);

		// 리소스 해제를 위해 세션 연결 닫음
		curl_close($ch);
	} else {
	// curl 라이브러리가 설치 되지 않음. 다른 방법 알아볼 것
	}
	$vno_arr = json_decode($vno_str);
	//echo $vno_str;
	//print_r($vno_arr->vnList);
	if ( $vno_arr->resCd == "SUCCESS" ) {
		$vno = $vno_arr->vnList[0]->vn;
		//echo "<br>vn = ".$vno_arr->vnList[0]->vn."<br>";
		//https://bizapi.callmix.co.kr/biz050/BZV210?secureCode= 378767ad6a190b3ea595225a0f52109d6c15c72df9b4ceba55bf4fbb8bf936e1&bizId=aaa&mo nthDay=0519&tkGbn=1&rn=021231234&vn=05041231234&brNm=맛있는치킨
		$s2_url = "https://bizapi.callmix.co.kr/biz050/BZV210?secureCode=".$secureCode."&bizId=".$bizId."&monthDay=".$mmdd."&tkGbn=1&rn=".str_replace("-","",$mem_dt['mb_hp'])."&vn=".$vno."&brNm=".$mem_dt['mb_id'];
		//echo $s2_url;
		if (function_exists('curl_init')) {
			// curl 리소스를 초기화
			$ch = curl_init();

			// url을 설정
			curl_setopt($ch, CURLOPT_URL, $s2_url);

			// 헤더는 제외하고 content 만 받음
			curl_setopt($ch, CURLOPT_HEADER, 0);

			// 응답 값을 브라우저에 표시하지 말고 값을 리턴
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			// 브라우저처럼 보이기 위해 user agent 사용
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0');

			$vno_res_str = curl_exec($ch);

			// 리소스 해제를 위해 세션 연결 닫음
			curl_close($ch);
		}
		$vno_res = json_decode($vno_res_str);
		//print_r($vno_res);print_r($vno);
		if ( $vno_res->resCd == "SUCCESS" ) {
			$vtel = $vno;
		}
	}

}

$mb_dir = substr($mem_dt['mb_id'],0,2);
$icon_url = G5_DATA_URL.'/member_image/'.$mb_dir.'/'.$mem_dt['mb_id'].'.gif';
$icon_url = is_file(G5_DATA_PATH.'/member_image/'.$mb_dir.'/'.$mem_dt['mb_id'].'.gif') ? $icon_url : "../theme/basic/img/profileSample.jpg";
$gen_img_url = $mem_dt['mb_sex'] == "m" ? "../theme/basic/img/img_male.png" : "../theme/basic/img/img_female.png";
?>

<!-- 성우상세 { -->


<div class="voiceDetail">
	<div class="voiceProfile">
		<div>
			<img src="<?php echo $icon_url; ?>" />
			<img src="<?php echo $gen_img_url; ?>" />
			<strong><?php echo $mem_dt['mb_name']; ?>(<?php echo $mem_dt['mb_id']; ?>)</strong>
			<i class="status01"><?php echo ( $mem_dt['mb_state'] == 2 ) ? "부재중" : "작업가능"; ?></i>
			<b>연락 가능 시간<span><?php echo $mem_dt['mb_8']; ?></span></b>
			<span><img src="../theme/basic/img/bg_call.png" /><?php echo $vtel ? $vtel : "(결제 후 통화가능)"; ?></span>
			<div>
				<b>리뷰 평점</b>
				<img src="img/s_star<?php echo $mem_dt['it_use_avg'] <= 0 ? "1" : intval($mem_dt['it_use_avg']); ?>.png" width="100" />
				<!--em class="star01"></em-->
			</div>
		</div>
		<hr />
		<!--
		<ul>
			<li><a href="javascript:;"><img src="../theme/basic/img/btn_pSns01.png" /></a></li>
			<li><a href="javascript:;"><img src="../theme/basic/img/btn_pSns02.png" /></a></li>
			<li><a href="javascript:;"><img src="../theme/basic/img/btn_pSns03.png" /></a></li>
			<li><a href="javascript:;"><img src="../theme/basic/img/btn_pSns04.png" /></a></li>
		</ul>
		 -->
	</div>
	<div class="profileOption">
		<a href="javascript:;" class="sendAgree">바로 문의하기</a>
		<a href="javascript:;" class="sendMassage memoPop"><img src="../theme/basic/img/btn_pPost.png" />쪽지보내기</a>
	</div>


<script type="text/javascript">
$(function(){
	var optTop = $(".profileOption").offset().top;
	console.log(optTop);
	$(window).scroll(function(){
		if(optTop <= $(window).scrollTop()){
			$(".profileOption").addClass("on");
			$(".voiceDetailInfo").addClass("on");
		} else {
			$(".profileOption").removeClass("on");
			$(".voiceDetailInfo").removeClass("on");
		}
	});
});
</script>


	<div class="voiceDetailInfo">
		<div class="voiceDetailSection">
			<div class="voiceDetailTab">
    			<ul>
    				<li class="on"><a href="javascript:;">프로필</a></li>
    				<li><a href="javascript:;">샘플음성</a></li>
    				<li><a href="javascript:;">리뷰</a></li>
    				<li><a href="javascript:;">응원메시지</a></li>
    				<li><a href="javascript:;">취소 및 환불</a></li>
    			</ul>
			</div>

			<div class="voiceDetailProfile">
				<strong><?php echo $mem_dt['mb_title']; ?></strong>
				<hr>
				<p>
<i>자기소개</i><br />
<?php echo nl2br($mem_dt['mb_profile']); ?><br /><br />
<i>출신극회 및 입시년도</i><br />
<?php echo $mem_dt['mb_9']; ?><br /><br />
<i>녹음장비 및 마이크 모델명</i><br />
<?php echo $mem_dt['mb_10']; ?><br /><br />
<i>주요작품 및 클라이언트</i><br />
<?php echo nl2br($mem_dt['mb_memo']); ?>
				</p>
			</div>
		</div>

		<div class="voiceDetailSection">
			<div class="voiceDetailTab">
    			<ul>
    				<li><a href="javascript:;">프로필</a></li>
    				<li class="on"><a href="javascript:;">샘플음성</a></li>
    				<li><a href="javascript:;">리뷰</a></li>
    				<li><a href="javascript:;">응원메시지</a></li>
    				<li><a href="javascript:;">취소 및 환불</a></li>
    			</ul>
			</div>

			<div class="voiceDetailProfile">

<script type="text/javascript">
$(function(){
	//var h = '<audio controls src="../theme/basic/img/audio-test-01.mp3"></audio>'
	//$('.audioPlayer').html(h);
	maudio({
	    obj:'audio',
	    fastStep:10
	});


});
</script>
<?php
$qry = "SELECT * FROM ".$g5['member_voice']." WHERE mb_id='".$_REQUEST['mb_id']."' ORDER BY mv_no DESC ";
//echo $qry;
$res = sql_query($qry);
$row_cnt = sql_num_rows($res);
for ($i=0; $row=sql_fetch_array($res); $i++) {
	$mb_dir = substr($mem_dt['mb_id'],0,2);
	$audio_url = G5_DATA_URL.'/member_voice/'.$mb_dir.'/'.$row['mv_voice'];
?>
				<div class="tagPlayer">
					<div>
						<strong><?php echo $row['mv_title']; ?></strong>
						<span><?php echo $category_arr[$row['mv_cat']]; ?></span>
						<span><?php echo $gender_arr[$row['mv_gen']]; ?></span>
						<span><?php echo $age_arr[$row['mv_age']]; ?></span>
						<span><?php echo $style_arr[$row['mv_sty']]; ?></span>
						<span><?php echo $tone_arr[$row['mv_ton']]; ?></span>
						<span><?php echo $language_arr[$row['mv_lan']]; ?></span>
					</div>
					<div>
						<div class="audioPlayer" id="player01">
							<audio controls src="<?php echo $audio_url; ?>"></audio>
						</div>
					</div>
				</div>
<?php
}
?>

			</div>
		</div>


		<div class="voiceDetailSection">
			<div class="voiceDetailTab">
    			<ul>
    				<li><a href="javascript:;">프로필</a></li>
    				<li><a href="javascript:;">샘플음성</a></li>
    				<li class="on"><a href="javascript:;">리뷰</a></li>
    				<li><a href="javascript:;">응원메시지</a></li>
    				<li><a href="javascript:;">취소 및 환불</a></li>
    			</ul>
			</div>
<?php
$it_id = $mem_dt['mb_no'];
?>
			<div>
    			<div id="itemuse"><?php include_once(G5_SHOP_PATH.'/itemuse.php'); ?></div>

    			<!--div class="voiceLv">
    				<strong>고객평점</strong>
    				<em class="star02"></em>
    				<span>120개의 평가</span>
    			</div>

    			<div class="listBoard">
    				<a href="javascript:;">
    					<strong>너무 만족스럽습니다.</strong>
    					<p>
    						내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용
    					</p>
    					<span>홍길동</span>
    					<b>19-01-10</b>
    					<em class="star03"></em>
    				</a>

    				<a href="javascript:;">
    					<strong>너무 만족스럽습니다.</strong>
    					<p>
    						내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용
    					</p>
    					<span>홍길동</span>
    					<b>19-01-10</b>
    					<em class="star03"></em>
    				</a>

    				<a href="javascript:;">
    					<strong>너무 만족스럽습니다.</strong>
    					<p>
    						내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용
    					</p>
    					<span>홍길동</span>
    					<b>19-01-10</b>
    					<em class="star03"></em>
    				</a>

    				<a href="javascript:;">
    					<strong>너무 만족스럽습니다.</strong>
    					<p>
    						내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용
    					</p>
    					<span>홍길동</span>
    					<b>19-01-10</b>
    					<em class="star03"></em>
    				</a>

    				<a href="javascript:;">
    					<strong>너무 만족스럽습니다.</strong>
    					<p>
    						내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용
    					</p>
    					<span>홍길동</span>
    					<b>19-01-10</b>
    					<em class="star03"></em>
    				</a>
    			</div>


    			<div class="ttrxPaging">
        			<a href="javascript:;"><img src="../theme/basic/img/btn_listPrev.png" /></a>
        			<ul>
        				<li><a href="javascript:;">1</a></li>
        				<li><a href="javascript:;">2</a></li>
        				<li><a href="javascript:;">3</a></li>
        				<li><a href="javascript:;">4</a></li>
        				<li><a href="javascript:;">5</a></li>
        				<li><a href="javascript:;">6</a></li>
        				<li><a href="javascript:;">7</a></li>
        				<li><a href="javascript:;">8</a></li>
        				<li><a href="javascript:;">9</a></li>
        				<li><a href="javascript:;">10</a></li>
        			</ul>
        			<a href="javascript:;"><img src="../theme/basic/img/btn_listNext.png" /></a>
        		</div>

    			<div class="tableWrite">
    				<?php $itemuse_form = "./itemuseform.php?it_id=1553055184"; ?>
    				<a href="<?php echo $itemuse_form; ?>" class="reviewTable">구매 후기 작성</a>
    			</div-->
			</div>

		</div>

		<div class="voiceDetailSection">
			<div class="voiceDetailTab">
    			<ul>
    				<li><a href="javascript:;">프로필</a></li>
    				<li><a href="javascript:;">샘플음성</a></li>
    				<li><a href="javascript:;">리뷰</a></li>
    				<li class="on"><a href="javascript:;">응원메시지</a></li>
    				<li><a href="javascript:;">취소 및 환불</a></li>
    			</ul>
			</div>

			<div>
				<div id="itemqa"><?php include_once(G5_SHOP_PATH.'/itemqa.php'); ?></div>

    			<!--div class="listBoard">
    				<a href="javascript:;">
    					<strong>너무 만족스럽습니다.</strong>
    					<p>
    						내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용
    					</p>
    					<span>홍길동</span>
    					<b>19-01-10</b>
    				</a>

    				<a href="javascript:;">
    					<strong>너무 만족스럽습니다.</strong>
    					<p>
    						내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용
    					</p>
    					<span>홍길동</span>
    					<b>19-01-10</b>
    				</a>

    				<a href="javascript:;">
    					<strong>너무 만족스럽습니다.</strong>
    					<p>
    						내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용
    					</p>
    					<span>홍길동</span>
    					<b>19-01-10</b>
    				</a>

    				<a href="javascript:;">
    					<strong>너무 만족스럽습니다.</strong>
    					<p>
    						내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용
    					</p>
    					<span>홍길동</span>
    					<b>19-01-10</b>
    				</a>

    				<a href="javascript:;">
    					<strong>너무 만족스럽습니다.</strong>
    					<p>
    						내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용
    					</p>
    					<span>홍길동</span>
    					<b>19-01-10</b>
    				</a>
    			</div>

    			<div class="ttrxPaging">
        			<a href="javascript:;"><img src="../theme/basic/img/btn_listPrev.png" /></a>
        			<ul>
        				<li><a href="javascript:;">1</a></li>
        				<li><a href="javascript:;">2</a></li>
        				<li><a href="javascript:;">3</a></li>
        				<li><a href="javascript:;">4</a></li>
        				<li><a href="javascript:;">5</a></li>
        				<li><a href="javascript:;">6</a></li>
        				<li><a href="javascript:;">7</a></li>
        				<li><a href="javascript:;">8</a></li>
        				<li><a href="javascript:;">9</a></li>
        				<li><a href="javascript:;">10</a></li>
        			</ul>
        			<a href="javascript:;"><img src="../theme/basic/img/btn_listNext.png" /></a>
        		</div>

    			<div class="tableWrite">
    				<a href="/bbs/memo_form.php" class="newMassage">메시지 작성</a>
    			</div-->
			</div>

		</div>

		<div class="voiceDetailSection">
			<div class="voiceDetailTab">
    			<ul>
    				<li><a href="javascript:;">프로필</a></li>
    				<li><a href="javascript:;">샘플음성</a></li>
    				<li><a href="javascript:;">리뷰</a></li>
    				<li><a href="javascript:;">응원메시지</a></li>
    				<li class="on"><a href="javascript:;">취소 및 환불</a></li>
    			</ul>
			</div>

			<div class="voiceDetailProfile">
				<?php echo $default['de_change_content']; ?>
				<!--
				<strong>수정 및 재진행 안내</strong>
				<p>
                                작업일수가 지나지않은경우에는 수정횟수 제한이없습니다.<br />
                                작업일수가 지난이후의 수정요청은 추가요금이 발생합니다.<br /><br />
				</p>
				<strong>취소 및 환불 규정</strong>
				<p>
                    <span>가. 기본 환불 규정</span><br />
                    1. 전문가와 의뢰인의 상호 협의하에 청약 철회 및 환불이 가능합니다.<br />
                    2. 작업 시작 이후의 청약 철회 시, 진행된 작업량 또는 작업 일수를 산정한 금액을 공제한 부분 환불이 가능합니다.<br />
                    (ex. 30%의 작업 완료 시, 의뢰인은 결제 금액의 최대 70%까지 환불을 요구할 수 있습니다.)<br /><br />
                    [환불 가이드라인]<br />
                    1. 기획 단계에서 청약 철회 : 결제 금액의 최대 80%까지 환불 가능<br />
                    2. 녹음 완료 후 청약 철회 : 결제 금액의 최대 20%까지 환불 가능<br /><br />
                    <span>나. 전문가 책임 사유</span><br />
                    1. 소비자 피해 보상 규정에 의거하여 작업물의 멸실 및 전문가 책임으로 인한 피해 발생 시, 전액 환불합니다.<br />
                    2. 작업 기간 미준수, 작업 태만 및 이에 상응하는 전문가 책임으로 인한 청약 철회 시, 환불이 가능합니다.<br /><br />
                    <span>다. 의뢰인 책임 사유</span><br />
					작업이 시작되면단순 변심 또는 의뢰인 책임 사유로 인한 전액 환불이 가능합니다.
				</p>
				 -->
			</div>
		</div>
	</div>



</div>

<style type="text/css">
.orderForm > ul > li > textarea{font-size:12px;}
</style>

<div id="orderPopupCover"></div>
<div id="orderPopup">
<form id="fitemform" name="fitemform" action="./voiceDetail_update.php" method="post" enctype="MULTIPART/FORM-DATA" autocomplete="off">
<input type="hidden" name="cat" value="<?php echo $_REQUEST['cat']; ?>">
<input type="hidden" name="mb_id" value="<?php echo $_REQUEST['mb_id']; ?>">
	<div class="orderForm">
		<strong>바로 문의하기</strong>
		<ul>
			<li class="full"><span>*제목</span><input type="text" id="it_name" name="it_name" value="" /></li>
			<li class="full"><span>*설명</span><textarea rows="3" id="it_explan" name="it_explan" ></textarea></li>
			<li class="full">
				<span>*대본<br />(스크립트)</span><textarea rows="7" id="it_explan2" name="it_explan2" placeholder="최종 완성된 대본을
직접 입력하시거나
파일로 첨부해주세요."></textarea>
			</li>
			<li class="full">
				<span>&nbsp;</span>
				<div class="fakeFile">
					<input type="text" id="it_7_name" value="" />
					<div><input type="file" id="it_7" name="it_7" /></div>
				</div>
			</li>
			<li><span>*마감시한</span><input type="date" id="it_view_time" name="it_view_time" /></li>
			<li>
				<span>*카테고리</span>
				<span class="slcWrap">
					<select id="ca_id" name="ca_id">
						<option value="">1차 카테고리(선택)</option>
						<?php echo conv_selected_option($category_select, ''); ?>
					</select>
				</span>
			</li>
			<li>
				<span>*예산</span>
				<input type="text" id="it_price" name="it_price" numberOnly value="" /><i>※ 최저가격 <span id="ch_pr"></span>원 이상으로 작성해주세요</i><i>※ 광고 작업의 경우 공중파 광고는 기본금액 25만원 이상으로 적어주시기 바랍니다</i>
			</li>
			<li>
				<span>스타일</span>
				<span class="slcWrap">
					<select id="it_3" name="it_3">
						<option value="">스타일(선택)</option>
						<?php echo conv_selected_option($style_select, ''); ?>
					</select>
				</span>
			</li>
			<li>
				<span>톤</span>
				<span class="slcWrap">
					<select id="it_4" name="it_4">
						<option value="">톤(선택)</option>
						<?php echo conv_selected_option($tone_select, ''); ?>
					</select>
				</span>
			</li>
			<li>
				<span>연령</span>
				<span class="slcWrap">
					<select id="it_2" name="it_2">
						<option value="">연령(선택)</option>
						<?php echo conv_selected_option($age_select, ''); ?>
					</select>
				</span>
			</li>
			<li>
				<span>언어</span>
				<span class="slcWrap">
					<select id="it_5" name="it_5">
						<option value="">언어(선택)</option>
						<?php echo conv_selected_option($language_select, ''); ?>
					</select>
				</span>
			</li>
			<li>
				<span>성별</span>
				<span class="slcWrap">
					<select id="it_1" name="it_1">
						<option value="">성별(선택)</option>
						<?php echo conv_selected_option($gender_select, ''); ?>
					</select>
				</span>
			</li>
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
var dt = new Array();
<?php
foreach ($dt as $key => $val) {
	echo "dt[".$key."] = '".$val."';\n";
}
?>
$(function(){
	$(".sendAgree").click(function(){
		$("#orderPopupCover").show();
		$("#orderPopup").show();
	});

	$(".orderForm > a,.vCancel").click(function(){
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

	$(window).scroll(function(){
		if($(window).scrollTop() >= 473){
			$(".profileOption").addClass("on");
			$("#ttrxFooter").addClass("on");
			//voiceDetailInfo
		} else {
			$(".profileOption").removeClass("on");
			$("#ttrxFooter").removeClass("on");
		}
	});

	$(".listBoard a > div").slideUp(0);
	$(".listBoard a").click(function(){
		if($(this).hasClass("on")){
			$(this).children("div").slideUp(500);
		} else {
			$(this).children("div").slideDown(500);
		}
	});

	$(".reviewTable").click(function(){
        window.open(this.href, "itemuse_form", "width=810,height=680,scrollbars=1");
        return false;
    });

	$("#ca_id").change(function() {
		$("#ch_pr").text( number_format(dt[$(this).val()]) );
	});

	$("#submit_btn").click(function() {
		if ( $("#it_name").val() == "" ) {
			alert("제목을 입력해 주세요.");
			$("#it_name").focus();
			return;
		}
		if ( $("#it_explan").val() == "" ) {
			alert("설명을 입력해 주세요.");
			$("#it_explan").focus();
			return;
		}
		/*
		if ( $("#it_explan2").val() == "" ) {
			alert("대본샘플을 입력해 주세요.");
			$("#it_explan2").focus();
			return;
		}
		*/
		if ( $("#it_6").val() == "" ) {
			alert("대본분량을 입력해 주세요.");
			$("#it_6").focus();
			return;
		}
		if ( $("#ca_id").val() == "" ) {
			alert("카테고리를 선택해 주세요.");
			$("#ca_id").focus();
			return;
		}
		if ( $("#it_price").val() == "" ) {
			alert("예산을 입력해 주세요.");
			$("#it_price").focus();
			return;
		}
		/*if ( $("#it_price").val() < dt[$("#ca_id").val()] ) {
			alert("예산을 "+number_format(dt[$("#ca_id").val()])+"원 이상으로 입력해 주세요.");
			$("#it_price").focus();
			return;
		}*/
		if ( $("#it_view_time").val() == "" ) {
			alert("노출기간을 입력해 주세요.");
			$("#it_view_time").focus();
			return;
		}

		$("#fitemform").submit();
	});
/*
	$(".sendMassage, .newMassage").click(function(){
        window.open(this.href, "itemuse_form", "width=810,height=550,scrollbars=1");
        return false;
    });
*/
});
</script>


<style type="text/css">
#memoCover{position:fixed;top:0;left:0;width:100%;height:100%;background-color:rgba(0,0,0,0.5);display:none;z-index:5000;}
#memoPop{position:fixed;top:10vh;left:5vw;width:90vw;height:80vh;display:none;z-index:5100;}
#memoPop > a{position:absolute;top:0;right:-10px;color:#fff;font-family: sans-serif;display:block;padding:10px;font-size:20px;font-weight:bold;line-height:28px;}
#memoPop > div{width:100%;height:calc(80vh - 48px);margin-top:48px;border:0;overflow-y:scroll;-webkit-overflow-scrolling: touch;}
#memoPop > div > iframe{width:100%;height:100%;}
</style>

<div id="memoCover"></div>
<div id="memoPop">
	<a href="javascript:;">Ⅹ</a>
<?php
if ( $member['mb_id'] ) {
?>
	<div>
		<iframe src="../bbs/memo_form.php?me_recv_mb_id=<?php echo $mem_dt['mb_id']; ?>"></iframe>
	</div>
<?php
}
?>
</div>
<script type="text/javascript">
$(function(){
	var loadCnt = 0;
	//http://allvoice.kr/bbs/password_lost.php
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
