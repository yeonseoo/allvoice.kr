<?php
include_once('./_common.php');


if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/customerMypageOrderDetail04.php');
    return;
}

include_once('./_head.php');


?>

<!-- 성우상세 { -->

<div class="commonLocation">
	<ul>
		<li><img src="../theme/basic/img/img_home2.png" /></li>
		<li>MY PAGE</li>
		<li>합의 주문 내역</li>
		<li>합의 주문서 보기</li>
	</ul>
</div>


<div class="voiceMypage">
	<div class="voiceDetailInfo">
		<div class="voiceDetailSection">
			<div style="padding:30px 50px;">
				<div class="orderDetailView">
    				<a href="javascript:;" class="orderDetailViewCtrl">
    					<strong>admin님의 주문서</strong>
    					<span>의뢰일 19-03-05 11:10(화)</span>
    				</a>
    				
    				<ul class="orderDetailViewCont">
    					<li>
    						<span>상태</span>
    						<div>
    							<span class="orderStatus orderStatus01">작업완료</span>
    						</div>
    					</li>
    					<li>
    						<span>제목</span>
    						<div>
    							애니메이션 더빙 의뢰
    						</div>
    					</li>
    					<li>
    						<span>성명</span>
    						<div>
    							터닝메카드 주인공(남) 목소리 더빙을 의뢰합니다.
    						</div>
    					</li>
    					<li>
    						<span>대본</span>
    						<div>
    							대본내용내용내용내용내용
    							<div>
	    							첨부된 파일명.pdf&nbsp;&nbsp;&nbsp;<a href="javascript:;" class="downloadBtn">Download</a>
    							</div>
    						</div>
    					</li>
    					<li>
    						<span>마감시한</span>
    						<div>
    							19-04-05
    						</div>
    					</li>
    					<li>
    						<span>Category</span>
    						<div>
    							만화
    						</div>
    					</li>
    					<li>
    						<span>Gender</span>
    						<div>
    							남성
    						</div>
    					</li>
    					<li>
    						<span>Age</span>
    						<div>
    							유아
    						</div>
    					</li>
    					<li>
    						<span>Tone</span>
    						<div>
    							하이톤
    						</div>
    					</li>
    					<li>
    						<span>Language</span>
    						<div>
    							표준어
    						</div>
    					</li>
    					<li>
    						<span>예산</span>
    						<div>
    							200,000원
    						</div>
    					</li>
    				</ul>
				</div>
			</div>
		</div>
		
		<div class="voiceSampleSection form">
			<div style="padding:30px 50px;">
    			<div class="orderDetailView">
    				<a href="javascript:;" class="orderDetailViewCtrl">
    					<strong>admin님의 답변</strong>
    					<span>19-03-05 11:10(화)</span>
    				</a>
    				<ul class="orderDetailViewCont">
    					<li>
    						<span>내용</span>
    						<div>
    							해당 작업을 진행하도록 하겠습니다. <br />
    							결제 확인 후 작업 소요일은 3~5일 이내 입니다.  감사합니다. 
    						</div>
    					</li>
    					<li>
    						<span>견적 금액</span>
    						<div>
    							200,000 
    						</div>
    					</li>
    				</ul>
    			</div>
			</div>
		</div>
		
		
		<div class="voiceDetailSection">
			<div style="padding:30px 50px;">
				<div class="orderDetailView">
    				<a href="javascript:;" class="orderDetailViewCtrl">
    					<strong>admin님의 결제 내역</strong>
    				</a>
    				
    				<ul class="orderDetailViewCont">
    					<li>
    						<span>결제일</span>
    						<div>
    							19-03-31  12:00:00
    						</div>
    					</li>
    					<li>
    						<span>결제 금액</span>
    						<div>
    							200,000원
    						</div>
    					</li>
    					<li>
    						<span>결제 수단</span>
    						<div>
    							카드결제
    						</div>
    					</li>
    				</ul>
				</div>
			</div>
		</div>
		
		<div class="voiceSampleSection form">
			<div style="padding:30px 50px">
    			<div class="orderDetailView">
    				<a href="javascript:;" class="orderDetailViewCtrl">
    					<strong>작업 완료 파일</strong>
    				</a>
    				<ul class="orderDetailViewCont">
    					<li>
    						<span>1차</span>
    						<div>
    							첨부된 파일명.pdf&nbsp;&nbsp;&nbsp;<a href="javascript:;" class="downloadBtn">Download</a>
    						</div>
    					</li>
    					<li>
    						<span>2차</span>
    						<div>
    							첨부된 파일명.pdf&nbsp;&nbsp;&nbsp;<a href="javascript:;" class="downloadBtn">Download</a>
    						</div>
    					</li>
    					<li>
    						<span>3차</span>
    						<div>
    							첨부된 파일명.pdf&nbsp;&nbsp;&nbsp;<a href="javascript:;" class="downloadBtn">Download</a>
    						</div>
    					</li>
    				</ul>
    			</div>
			</div>
		</div>
		
		<div class="ctrler">
			해당 거래에 대한 리뷰를 남겨주세요!
			<br /><br />
			<a class="vSave" style="cursor:pointer;">리뷰 작성하기</a>
		</div>
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
});
</script>

	<div class="voiceProfile">
		<div>
			<img src="../theme/basic/img/voiceList/01.png" />
			<strong>회원이름(아이디)</strong>
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