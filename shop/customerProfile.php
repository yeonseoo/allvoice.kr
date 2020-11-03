<?php
include_once('./_common.php');


if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/customerProfile.php');
    return;
}

include_once('./_head.php');


?>

<!-- 성우상세 { -->

<div class="commonLocation">
	<ul>
		<li><img src="../theme/basic/img/img_home2.png" /></li>
		<li>MY PAGE</li>
		<li>프로필관리</li>
	</ul>
</div>


<div class="voiceMypage">
	<div class="voiceDetailInfo">
		<div class="voiceSampleSection form">
			<ul>
				<li>
					<ul style="margin-bottom:0;">
						<li style="margin-bottom:0;">
							<span>프로필사진</span><div class="fakeFile" style="margin-top:0;">
								<input type="text" />
								<div><input type="file" /></div>
							</div>
						</li>
					</ul>
				</li>
				
			</ul>
		</div>
		<div class="ctrler">
			<a href="javascript:;" class="vSave">확인</a>
			<a href="javascript:;" class="vCancel">취소</a>
		</div>
	</div>
	
	<div class="voiceProfile">
		<div>
			<img src="../theme/basic/img/voiceList/01.png" />
			<strong>이용신(sin1111)</strong>
			<ul>
				<li>연락처</li>
				<li>010-1234-5678</li>
				<li>이메일</li>
				<li>test@test.com</li>
				<li>최종 접속 일시</li>
				<li>2019.02.20 00:00:06</li>
			</ul>
			<a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php">내 정보 수정</a>
		</div>
		<section>
			<ul>
				<li><a href="/shop/customerProfile.php">프로필 사진 관리</a></li>
				<li><a href="/shop/customerMypageList01.php">거래내역</a></li>
				<li><a href="/shop/customerMypageList02.php">합의 주문 의뢰 내역</a></li>
				<li><a href="/shop/customerMypageList03.php">작업 의뢰 프로젝트 내역</a></li>
				<li><a href="/bbs/memo.php" class="memoPop">메시지함</a></li>
				<li><a href="javascript:;">회원탈퇴</a></li>
			</ul>
		</section>
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