<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가


?>


<div id="ttrxFooter">
	<div>
		<a href="https://twitter.com/allvoice1?s=09" target="_blank"><img src="../theme/basic/img/mobile/img_sns01.png" /></a>
		<a href="https://www.instagram.com/allvoice02/" target="_blank"><img src="../theme/basic/img/mobile/img_sns02.png" /></a>
		<a href="https://www.youtube.com/channel/UC6yula2661gXB73CYwvvjww?view_as=subscriber" target="_blank"><img src="../theme/basic/img/mobile/img_sns03.png" /></a>
	</div>
	<div>
		<a href="<?php echo G5_SHOP_URL; ?>/how.php">이용안내</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=provision">이용약관</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=privacy">개인정보처리방침</a>&nbsp;|&nbsp;&nbsp;<a href="<?php echo G5_BBS_URL; ?>/faq.php">고객만족센터</a>
	</div>

	<p>
		<img src="../theme/basic/img/mobile/img_footerLogo.png" />
		회사명 : 올보이스(주) ALLVOICE&nbsp;&nbsp;대표자명 : 오신성<br />
		사업자등록번호 : 845-86-011-81<br />
		통신판매업신고번호 : 제 2018-서울성동-162<br />
		주소 : 서울특별시 마포구 성암로 330 DMC첨단산업센터 316-2호<br />
		연락처 : 1544 2055<br />
		이메일 : allvoice@naver.com<br />
		<span>Copyright&copy; Allvoice co., Ltd. All rights reserved.</span>
	</p>

</div>

<script type="text/javascript">
$(function(){
	$(".listData2 div.maudio .audio-control a.play").each(function(){
		//$(this).css("top",(($(this).parent().parent().prev().outerHeight() + 52) * -1) + "px");
	});
});
</script>


<?php
$sec = get_microtime() - $begin_time;
$file = $_SERVER['SCRIPT_NAME'];

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<script src="<?php echo G5_JS_URL; ?>/sns.js"></script>

<?php
include_once(G5_THEME_PATH.'/tail.sub.php');
?>
