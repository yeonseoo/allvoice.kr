<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MSHOP_PATH.'/shop.tail.php');
    return;
}

$admin = get_admin("super");

// 사용자 화면 우측과 하단을 담당하는 페이지입니다.
// 우측, 하단 화면을 꾸미려면 이 파일을 수정합니다.
?>
	</div>
</div>
    <!-- } 콘텐츠 끝 -->

<!-- 하단 시작 { -->



<div id="ttrxFooter">
	<div>
		<img src="../theme/basic/img/img_footerLogo.png" />
		<div id="ttrxFooterInfo">
			<p>
				회사명 : 올보이스(주) ALLVOICE&nbsp;&nbsp;대표자명 : 오신성  사업자등록번호 : 845-86-011-81&nbsp;&nbsp;통신판매업신고번호 : 제 2018-서울성동-162<br />
				주소 : 서울특별시 마포구 성암로330 DMC첨단산업센터 316-2호&nbsp;&nbsp;연락처 : 1544 2055&nbsp;&nbsp;이메일 : allvoice@naver.com
			</p>
			<span>Copyright&copy; Allvoice co., Ltd. All rights reserved.</span>
		</div>
		<div id="ttrxFooterEtc">
			<ul>
				<li><a href="https://twitter.com/allvoice1?s=09" target="_blank"><img src="../theme/basic/img/img_sns01.png" /></a></li>
				<li><a href="https://www.instagram.com/allvoice02/" target="_blank"><img src="../theme/basic/img/img_sns02.png" /></a></li>
				<li><a href="https://www.youtube.com/channel/UC6yula2661gXB73CYwvvjww?view_as=subscriber" target="_blank"><img src="../theme/basic/img/img_sns03.png" /></a></li>
			</ul>
			<div>
    			<a href="<?php echo G5_SHOP_URL; ?>/how.php">이용안내</a> ㅣ
    			<a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=provision">이용약관</a> ㅣ
    			<a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=privacy">개인정보처리방침</a> ㅣ
    			<b class="cs_center"><a href="<?php echo G5_BBS_URL; ?>/faq.php">고객만족센터</a></b>
    			<!--
    			<?php echo get_device_change_url(); ?>
    			-->
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$(function(){
	$(".fixedRight a:last-child").click(function(){
		$("html, body").animate({
			scrollTop : 0
		},500);
	});
});
</script>

<div class="fixedRight">
  <div class="call_type">
    <h2>고객센터</h2>
    <p>1544-2055</p>
  </div>
	<a href="http://pf.kakao.com/_JxiIxgj/chat" target="_blank"><img src="../theme/basic/img/btn_kakao.png" /></a>
	<a href="javascript:;"><img src="../theme/basic/img/btn_gotoTop.png" /></a>
</div>





<?php
$sec = get_microtime() - $begin_time;
$file = $_SERVER['SCRIPT_NAME'];

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<script src="<?php echo G5_JS_URL; ?>/sns.js"></script>
<!-- } 하단 끝 -->

<?php
include_once(G5_THEME_PATH.'/tail.sub.php');
?>
