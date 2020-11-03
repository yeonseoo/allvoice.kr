<?php
include_once('./_common.php');


if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/voiceProfile.php');
    return;
}

include_once('./_head.php');

//print_r($member);
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
	<form name="fmember" id="fmember" action="./voiceProfile_update.php" onsubmit="return fmember_submit(this);" method="post" enctype="multipart/form-data">
	<div class="voiceDetailInfo">
		<div class="voiceSampleSection form">
			<ul>
				<li>
					<ul>
						<li><span for="mb_sexm">성별</span><input type="radio" id="mb_sexm" name="mb_sex" value="m" <?php echo $member['mb_sex'] == "m" || $member['mb_sex'] == "" ? "checked" : "";?> /><label for="mb_sexm"> 남성</label><input type="radio" id="mb_sexf" name="mb_sex" value="f" <?php echo $member['mb_sex'] == "f" ? "checked" : "";?> /><label for="mb_sexf"> 여성</label></li>
						<li><span for="mb_state1">상태</span><input type="radio" id="mb_state1" name="mb_state" value="1" <?php echo $member['mb_state'] == "1" || $member['mb_state'] == "" ? "checked" : "";?> /><label for="mb_state1"> 작업가능</label><input type="radio" id="mb_state2" name="mb_state" value="2" <?php echo $member['mb_state'] == "2" ? "checked" : "";?> /><label for="mb_state2"> 부재중</label></li>
						<li><span>제목</span><input type="text" id="mb_title" name="mb_title" value="<?php echo $member['mb_title']?>" placeholder="프로필 제목" /></li>
						<li><span>연락가능시간</span><input type="text" id="mb_8" name="mb_8" value="<?php echo $member['mb_8']?>" placeholder="연락가능시간을 기입해주세요. ex) 월~목 10:00~18:00" /></li>
						<li><span>출신극회 및 입사년도</span><input type="text" id="mb_9" name="mb_9" value="<?php echo $member['mb_9']?>" placeholder="성우님의 출신 극회와 입사년도를 기입해주세요." /></li>
						<li><span>자기소개</span><textarea rows="7" id="mb_profile" name="mb_profile" placeholder="고객에게 제공할 성우님의 소개글를 작성해주세요."><?php echo $member['mb_profile']?></textarea></li>
						<li><span>녹음장비</span><input type="text" id="mb_10" name="mb_10" value="<?php echo $member['mb_10']?>" placeholder="사용하시는 녹음 파일 명칭 및 마이크 종류 등을 작성해주세요." /></li>
						<li><span>주요작품 및 클라이언트</span><textarea rows="7" id="mb_memo" name="mb_memo" placeholder="성우님의 경력사항을 작성해주세요."><?php echo $member['mb_memo']?></textarea></li>
						<li>
							<span>프로필사진</span><div class="fakeFile" style="margin-top:0;">
								<input type="text" readonly="readonly" class="file-name" />
								<div><input type="file" name="mb_img" id="mb_img" class="file-upload" onchange="changeValue(this)" /></div>
							</div>
						</li>
					</ul>
				</li>
				
			</ul>
		</div>
		<div class="ctrler">
			<a class="vSave" style="cursor:pointer;">확인</a>
			<a href="javascript:;" class="vCancel">취소</a>
		</div>
	</div>
	</form>

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

	$(".vSave").click(function(){
		$("#fmember").submit();
	});


});

function fmember_submit (obj) {
	return true;
}

function changeValue(obj){
	//alert(obj.value);
	$(".file-name").val(obj.value);
}

</script>

<!-- } 성우상세 끝 -->

<?php
include_once("./_tail.php");
?>