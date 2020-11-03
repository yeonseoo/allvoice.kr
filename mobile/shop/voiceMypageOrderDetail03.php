<?php
include_once('./_common.php');



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
	<?php
include_once('./voiceRight.php');
?>

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
    							<span class="orderStatus orderStatus02">작업진행중</span>
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
    					<strong>답변</strong>
    					<span>19-03-05 11:10(화)</span>
    				</a>
    			</div>
			</div>
			<ul style="margin-bottom:0;padding-top:0;transform:translateY(-20px);" class="orderDetailViewCont">
				<li>
					<ul>
						<li><span>내용</span><textarea rows="7"></textarea></li>
						<li><span>견적금액</span><input type="text" /></li>
					</ul>
				</li>
			</ul>
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
    			</div>
			</div>
			<ul style="margin-bottom:0;padding-top:0;transform:translateY(-20px);" class="orderDetailViewCont">
				<li>
					<ul>
						<li>
							<span>1차</span>
							<div class="fakeFile">
								<input type="text"  />
								<div><input type="file" /></div>
							</div>
						</li>
					</ul>
				</li>
				<li>
        			<div class="newSample">
        				<a href="javascript:;"><img src="../theme/basic/img/btn_plus.png" /><span>음성 추가하기</span></a>
        			</div>
				</li>
			</ul>
		</div>
		
		<div class="ctrler">
			<a class="vSave" style="cursor:pointer;">저장</a>
			<a href="javascript:;" class="vCancel">취소</a>
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