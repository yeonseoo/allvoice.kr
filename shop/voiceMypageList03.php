<?php
include_once('./_common.php');


if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/voiceMypageList03.php');
    return;
}

include_once('./_head.php');


?>

<!-- 성우상세 { -->

<div class="commonLocation">
	<ul>
		<li><img src="../theme/basic/img/img_home2.png" /></li>
		<li>MY PAGE</li>
		<li>작업 의뢰 프로젝트 지원 내역</li>
	</ul>
</div>


<div class="voiceMypage">
	<div class="voiceDetailInfo">
		<div class="voiceDetailSection">
			<div style="padding:30px 50px;">
    			<div class="tableSet02">
    				<table>
    					<colgroup>
    						<col width="100" />
    						<col width="*" />
    						<col width="110" />
    						<col width="170" />
    						<col width="170" />
    					</colgroup>
    					<thead>
    						<tr>
        						<th>상태</th>
        						<th>제목</th>
        						<th>금액</th>
        						<th>마감일</th>
        						<th>의뢰일</th>
    						</tr>
    					</thead>
    					<tbody>
    						<tr>
    							<td><span class="orderStatus orderStatus01">진행중</span></td>
    							<td><a href="javascript:;">광고 더빙 성우분을 찾고있습니다.광고 더빙 성우분을 찾고있습니다.광고 더빙 성우분을 찾고있습니다.</a></td>
    							<td>34,000원</td>
    							<td>19-01-15 11:10 (화)</td>
    							<td>19-01-15 11:10 (화)</td>
    						</tr>
    						<tr>
    							<td><span class="orderStatus orderStatus01">진행중</span></td>
    							<td><a href="javascript:;">광고 더빙 성우분을 찾고있습니다.광고 더빙 성우분을 찾고있습니다.광고 더빙 성우분을 찾고있습니다.</a></td>
    							<td>34,000원</td>
    							<td>19-01-15 11:10 (화)</td>
    							<td>19-01-15 11:10 (화)</td>
    						</tr>
    						<tr>
    							<td><span class="orderStatus orderStatus03">등록대기</span></td>
    							<td><a href="javascript:;">광고 더빙 성우분을 찾고있습니다.광고 더빙 성우분을 찾고있습니다.광고 더빙 성우분을 찾고있습니다.</a></td>
    							<td>34,000원</td>
    							<td>19-01-15 11:10 (화)</td>
    							<td>19-01-15 11:10 (화)</td>
    						</tr>
    						<tr>
    							<td><span class="orderStatus orderStatus04">마감</span></td>
    							<td><a href="javascript:;">광고 더빙 성우분을 찾고있습니다.광고 더빙 성우분을 찾고있습니다.광고 더빙 성우분을 찾고있습니다.</a></td>
    							<td>34,000원</td>
    							<td>19-01-15 11:10 (화)</td>
    							<td>19-01-15 11:10 (화)</td>
    						</tr>
    						<tr>
    							<td><span class="orderStatus orderStatus05">등록취소</span></td>
    							<td><a href="javascript:;">광고 더빙 성우분을 찾고있습니다.광고 더빙 성우분을 찾고있습니다.광고 더빙 성우분을 찾고있습니다.</a></td>
    							<td>34,000원</td>
    							<td>19-01-15 11:10 (화)</td>
    							<td>19-01-15 11:10 (화)</td>
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