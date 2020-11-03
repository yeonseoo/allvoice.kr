<?php
include_once('./_common.php');


include_once(G5_MSHOP_PATH.'/_head.php');


?>

<!-- 성우상세 { -->

<div class="commonLocation">
	<ul>
		<li><img src="../theme/basic/img/img_home2.png" /></li>
		<li>MY PAGE</li>
		<li>합의 주문 내역</li>
	</ul>
</div>


<div class="voiceMypage">
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
				<li><a href="/shop/voiceProfile.php">프로필관리</a></li>
				<li><a href="/shop/voiceSample.php">샘플 음성 관리</a></li>
				<li><a href="/shop/voiceMypageList01.php">거래 내역 관리</a></li>
				<li><a href="/shop/voiceMypageList02.php">합의 주문 관리</a></li>
				<li><a href="/shop/voiceMypageList03.php">작업 의뢰 프로젝트 지원 내역</a></li>
				<li><a href="/bbs/memo.php" class="memoPop">메시지함</a></li>
				<li><a href="javascript:;">회원탈퇴</a></li>
			</ul>
		</section>
	</div>
	
	<div class="voiceDetailInfo">
		<div class="voiceDetailSection">
			<div style="padding:30px 50px;">
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
    						<tr>
    							<td><span class="orderStatus orderStatus01">작업완료</span></td>
    							<td><a href="javascript:;">애니메이션 더빙도 가능할까요?애니메이션 더빙도 가능할까요?애니메이션 더빙도 가능할까요?</a></td>
    							<td>34,000원</td>
    						</tr>
    						<tr>
    							<td><span class="orderStatus orderStatus02">작업진행중</span></td>
    							<td><a href="javascript:;">애니메이션 더빙도 가능할까요?애니메이션 더빙도 가능할까요?애니메이션 더빙도 가능할까요?</a></td>
    							<td>34,000원</td>
    						</tr>
    						<tr>
    							<td><span class="orderStatus orderStatus03">거래합의중</span></td>
    							<td><a href="javascript:;">애니메이션 더빙도 가능할까요?애니메이션 더빙도 가능할까요?애니메이션 더빙도 가능할까요?</a></td>
    							<td>34,000원</td>
    						</tr>
    						<tr>
    							<td><span class="orderStatus orderStatus04">의뢰완료</span></td>
    							<td><a href="javascript:;">애니메이션 더빙도 가능할까요?애니메이션 더빙도 가능할까요?애니메이션 더빙도 가능할까요?</a></td>
    							<td>34,000원</td>
    						</tr>
    						<tr>
    							<td><span class="orderStatus orderStatus05">의뢰취소</span></td>
    							<td><a href="javascript:;">애니메이션 더빙도 가능할까요?애니메이션 더빙도 가능할까요?애니메이션 더빙도 가능할까요?</a></td>
    							<td>34,000원</td>
    						</tr>
    					</tbody>
    				</table>
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
include_once(G5_MSHOP_PATH."/_tail.php");
?>