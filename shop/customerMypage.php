<?php
include_once('./_common.php');


if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/customerMypage.php');
    return;
}

include_once('./_head.php');


?>

<!-- 성우상세 { -->

<div class="commonLocation">
	<ul>
		<li><img src="../theme/basic/img/img_home2.png" /></li>
		<li>MY PAGE</li>
	</ul>
</div>


<div class="voiceMypage">
	<div class="voiceDetailInfo">
		<div class="voiceDetailSection">
			<div class="voiceDetailTab tab3">
    			<ul>
    				<li class="on"><a href="javascript:;">최근 거래 내역</a></li>
    				<li><a href="javascript:;">합의 주문 내역</a></li>
    				<li><a href="javascript:;">작업 의뢰 주문 내역</a></li>
    			</ul>
			</div>
			<div>
    			<div class="tableSet02">
    				<table>
    					<colgroup>
    						<col width="100" />
    						<col width="*" />
    						<col width="180" />
    						<col width="100" />
    						<col width="100" />
    						<col width="100" />
    					</colgroup>
    					<thead>
    						<tr>
        						<th>상태</th>
        						<th>주문서번호</th>
        						<th>주문일시</th>
        						<th>주문금액</th>
        						<th>입금액</th>
        						<th>미입금액</th>
    						</tr>
    					</thead>
    					<tbody>
    						<tr>
    							<td><span class="orderStatus orderStatus01">입금완료</span></td>
    							<td><a href="javascript:;">2019011511093624</a></td>
    							<td>19-01-15 11:10 (화)</td>
    							<td>34,000원</td>
    							<td>25,000원</td>
    							<td>0원</td>
    						</tr>
    						<tr>
    							<td><span class="orderStatus orderStatus01">입금완료</span></td>
    							<td><a href="javascript:;">2019011511093624</a></td>
    							<td>19-01-15 11:10 (화)</td>
    							<td>34,000원</td>
    							<td>0원</td>
    							<td>0원</td>
    						</tr>
    						<tr>
    							<td><span class="orderStatus orderStatus01">입금완료</span></td>
    							<td><a href="javascript:;">2019011511093624</a></td>
    							<td>19-01-15 11:10 (화)</td>
    							<td>34,000원</td>
    							<td>0원</td>
    							<td>0원</td>
    						</tr>
    						<tr>
    							<td><span class="orderStatus orderStatus01">입금완료</span></td>
    							<td><a href="javascript:;">2019011511093624</a></td>
    							<td>19-01-15 11:10 (화)</td>
    							<td>34,000원</td>
    							<td>0원</td>
    							<td>0원</td>
    						</tr>
    						<tr>
    							<td><span class="orderStatus orderStatus01">입금완료</span></td>
    							<td><a href="javascript:;">2019011511093624</a></td>
    							<td>19-01-15 11:10 (화)</td>
    							<td>34,000원</td>
    							<td>0원</td>
    							<td>0원</td>
    						</tr>
    					</tbody>
    				</table>
    			</div>
    			<div class="more03">
    				<a href="/shop/customerMypageList01.php">MORE</a>
    			</div>
			</div>
		</div>
		
		<div class="voiceDetailSection">
			<div class="voiceDetailTab tab3">
    			<ul>
    				<li><a href="javascript:;">최근 거래 내역</a></li>
    				<li class="on"><a href="javascript:;">합의 주문 내역</a></li>
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
    						<col width="120" />
    						<col width="100" />
    						<col width="170" />
    					</colgroup>
    					<thead>
    						<tr>
        						<th>상태</th>
        						<th>제목</th>
        						<th>제안금액</th>
        						<th>확정금액</th>
        						<th>판매자</th>
        						<th>의뢰일</th>
    						</tr>
    					</thead>
    					<tbody>
    						<tr>
    							<td><span class="orderStatus orderStatus01">작업완료</span></td>
    							<td><a href="javascript:;">애니메이션 더빙도 가능할까요?애니메이션 더빙도 가능할까요?애니메이션 더빙도 가능할까요?</a></td>
    							<td>34,000원</td>
    							<td>34,000원</td>
    							<td>abcd1234</td>
    							<td>19-01-15 11:10 (화)</td>
    						</tr>
    						<tr>
    							<td><span class="orderStatus orderStatus02">작업진행중</span></td>
    							<td><a href="javascript:;">애니메이션 더빙도 가능할까요?애니메이션 더빙도 가능할까요?애니메이션 더빙도 가능할까요?</a></td>
    							<td>34,000원</td>
    							<td>34,000원</td>
    							<td>abcd1234</td>
    							<td>19-01-15 11:10 (화)</td>
    						</tr>
    						<tr>
    							<td><span class="orderStatus orderStatus03">거래합의중</span></td>
    							<td><a href="javascript:;">애니메이션 더빙도 가능할까요?애니메이션 더빙도 가능할까요?애니메이션 더빙도 가능할까요?</a></td>
    							<td>34,000원</td>
    							<td>34,000원</td>
    							<td>abcd1234</td>
    							<td>19-01-15 11:10 (화)</td>
    						</tr>
    						<tr>
    							<td><span class="orderStatus orderStatus04">의뢰완료</span></td>
    							<td><a href="javascript:;">애니메이션 더빙도 가능할까요?애니메이션 더빙도 가능할까요?애니메이션 더빙도 가능할까요?</a></td>
    							<td>34,000원</td>
    							<td>34,000원</td>
    							<td>abcd1234</td>
    							<td>19-01-15 11:10 (화)</td>
    						</tr>
    						<tr>
    							<td><span class="orderStatus orderStatus05">의뢰취소</span></td>
    							<td><a href="javascript:;">애니메이션 더빙도 가능할까요?애니메이션 더빙도 가능할까요?애니메이션 더빙도 가능할까요?</a></td>
    							<td>34,000원</td>
    							<td>34,000원</td>
    							<td>abcd1234</td>
    							<td>19-01-15 11:10 (화)</td>
    						</tr>
    					</tbody>
    				</table>
    			</div>
    			<div class="more03">
    				<a href="/shop/customerMypageList02.php">MORE</a>
    			</div>
			</div>
		</div>
		
		<div class="voiceDetailSection">
			<div class="voiceDetailTab tab3">
    			<ul>
    				<li><a href="javascript:;">최근 거래 내역</a></li>
    				<li><a href="javascript:;">합의 주문 내역</a></li>
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
    						<col width="110" />
    						<col width="110" />
    						<col width="170" />
    					</colgroup>
    					<thead>
    						<tr>
        						<th>상태</th>
        						<th>제목</th>
        						<th>금액</th>
        						<th>지원자 현황</th>
        						<th>확정 작업자</th>
        						<th>의뢰일</th>
    						</tr>
    					</thead>
    					<tbody>
    						<tr>
    							<td><span class="orderStatus orderStatus01">채택완료</span></td>
    							<td><a href="javascript:;">광고 더빙 성우분을 찾고있습니다.광고 더빙 성우분을 찾고있습니다.광고 더빙 성우분을 찾고있습니다.</a></td>
    							<td>34,000원</td>
    							<td>12명</td>
    							<td>abcd1234</td>
    							<td>19-01-15 11:10 (화)</td>
    						</tr>
    						<tr>
    							<td><span class="orderStatus orderStatus01">채택완료</span></td>
    							<td><a href="javascript:;">광고 더빙 성우분을 찾고있습니다.광고 더빙 성우분을 찾고있습니다.광고 더빙 성우분을 찾고있습니다.</a></td>
    							<td>34,000원</td>
    							<td>12명</td>
    							<td>-</td>
    							<td>19-01-15 11:10 (화)</td>
    						</tr>
    						<tr>
    							<td><span class="orderStatus orderStatus03">지원완료</span></td>
    							<td><a href="javascript:;">광고 더빙 성우분을 찾고있습니다.광고 더빙 성우분을 찾고있습니다.광고 더빙 성우분을 찾고있습니다.</a></td>
    							<td>34,000원</td>
    							<td>12명</td>
    							<td>-</td>
    							<td>19-01-15 11:10 (화)</td>
    						</tr>
    						<tr>
    							<td><span class="orderStatus orderStatus05">미채택</span></td>
    							<td><a href="javascript:;">광고 더빙 성우분을 찾고있습니다.광고 더빙 성우분을 찾고있습니다.광고 더빙 성우분을 찾고있습니다.</a></td>
    							<td>34,000원</td>
    							<td>12명</td>
    							<td>-</td>
    							<td>19-01-15 11:10 (화)</td>
    						</tr>
    						<tr>
    							<td><span class="orderStatus orderStatus05">미채택</span></td>
    							<td><a href="javascript:;">광고 더빙 성우분을 찾고있습니다.광고 더빙 성우분을 찾고있습니다.광고 더빙 성우분을 찾고있습니다.</a></td>
    							<td>34,000원</td>
    							<td>12명</td>
    							<td>-</td>
    							<td>19-01-15 11:10 (화)</td>
    						</tr>
    					</tbody>
    				</table>
    			</div>
    			<div class="more03">
    				<a href="/shop/customerMypageList03.php">MORE</a>
    			</div>
			</div>
		</div>
	</div>
	
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