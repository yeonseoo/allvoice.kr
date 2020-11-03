<?php
include_once('./_common.php');


if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/contest.php');
    return;
}


include_once(G5_PATH.'/head.sub1.php');


?>
<div id="contentsWrap" style="margin-top:-40px;background:#fff;">
	<div>
<div class="ttrxHeader sub">
	<div>
		<a href="/shop/"><img src="/theme/basic/img/img_logo2.png" title=""></a>
	</div>
</div>

<!-- 성우상세 { -->
<div class="contTop" style="opacity:0;">
	<strong>캐릭터 보이스<br/>프로젝트</strong>

	<span>프로젝트의 목소리를 함께 골라주세요!<br/>
투표결과를 반영하여 목소리의 주인공이 결정됩니다.</span>
</div>

<script type="text/javascript">
$(function(){
	$("#contentsWrap > div").before("<div class='contTop2 contestTop'><div class='inner'>"+$(".contTop").html()+"</div></div>");
	$(".contTop").remove();
});
</script>

	<div class="listContest">
		<ul>
			<li><a href="" class="on">프로젝트 진행중</a></li>
			<li><a href="">프로젝트 종료</a></li>
		</ul>
	</div>



	<div class="listCont_full">




		<ul class="listData_new">
			<li>
    			<a href="contest_detail.php">
    				<img src="/img/sample.png" title="">
    			</a>
    			<div>
        			<strong>메이플스토리 신규캐릭터 올보이스 오디션</strong>
        			<p>넥슨에서 제작하는 메이플스토리 신규캐릭터 2명을 올보이스와함께  오디션을 진행합니다. 캐릭터 스타일은 귀여운궁수와 호걸타입의 캐릭터입니다.    </p>
					<p class="date"><img src="/img/time.png" title=""> <strong class="color">진행기간</strong> <strong>2019.05.06~08</strong></p>
                    <p class="btn_wrap"><a href="#layer1" class="btn-layer" >참가하기</a></p>
    			</div>
			</li>
			<li>
    			<a href="contest_detail.php">
    				<img src="/img/sample.png" title="">
    			</a>
    			<div>
        			<strong>메이플스토리 신규캐릭터 올보이스 오디션</strong>
        			<p>넥슨에서 제작하는 메이플스토리 신규캐릭터 2명을 올보이스와함께  오디션을 진행합니다. 캐릭터 스타일은 귀여운궁수와 호걸타입의 캐릭터입니다.    </p>
					<p class="date"><i class="xi-calendar-list"></i> <strong class="color">투표기간</strong> <strong>2019.05.06~08</strong></p>
                    <p class="btn_wrap"><a href="#layer1" class="btn-layer" >참가하기</a></p>
    			</div>
			</li>
			<li>
    			<a href="contest_detail.php">
    				<img src="/img/sample.png" title="">
    			</a>
    			<div>
        			<strong>메이플스토리 신규캐릭터 올보이스 오디션</strong>
        			<p>넥슨에서 제작하는 메이플스토리 신규캐릭터 2명을 올보이스와함께  오디션을 진행합니다. 캐릭터 스타일은 귀여운궁수와 호걸타입의 캐릭터입니다.    </p>
					<p class="date"><i class="xi-calendar-list"></i> <strong class="color">진행기간</strong> <strong>2019.05.06~08</strong></p>
                    <p class="btn_wrap"><a href="#layer1" class="btn-layer" >참가하기</a></p>
    			</div>
			</li>
			<li>
    			<a href="contest_detail.php">
    				<img src="/img/sample.png" title="">
    			</a>
    			<div>
        			<strong>메이플스토리 신규캐릭터 올보이스 오디션</strong>
        			<p>넥슨에서 제작하는 메이플스토리 신규캐릭터 2명을 올보이스와함께  오디션을 진행합니다. 캐릭터 스타일은 귀여운궁수와 호걸타입의 캐릭터입니다.    </p>
					<p class="date"><i class="xi-calendar-list"></i> <strong class="color">진행기간</strong> <strong>2019.05.06~08</strong></p>
                    <p class="btn_wrap"><a href="#layer1" class="btn-layer" >참가하기</a></p>
    			</div>
			</li>
			<li>
    			<a href="contest_detail.php">
    				<img src="/img/sample.png" title="">
    			</a>
    			<div>
        			<strong>메이플스토리 신규캐릭터 올보이스 오디션</strong>
        			<p>넥슨에서 제작하는 메이플스토리 신규캐릭터 2명을 올보이스와함께  오디션을 진행합니다. 캐릭터 스타일은 귀여운궁수와 호걸타입의 캐릭터입니다.    </p>
					<p class="date"><i class="xi-calendar-list"></i> <strong class="color">진행기간</strong> <strong>2019.05.06~08</strong></p>
                    <p class="btn_wrap"><a href="#layer1" class="btn-layer" >참가하기</a></p>
    			</div>
			</li>


		</ul>


		<div class="ttrxPaging1"><ul>
<li class="on"><a href="#">1</a></li>
<li><a href="#">2</a></li>
<li><a href="#">3</a></li>
<li><a href="#">4</a></li>
</ul>
</div>












</div>
</div>

</div>


<!-- } 성우상세 끝 -->
<!-- layer -->
<div class="dim-layer">
    <div class="dimBg"></div>
    <div id="layer1" class="pop-layer">
        <div class="pop-container">

                <!--content //-->
                <p class="pop-title">투표에 참여하시겠습니까?</p>
                <p>참여해주신분 중, 추첨을 통하여 소정의 상품을 증정합니다.  <br/>'상품, 이벤트 안내를 위한 이메일을 입력해주세요.</p>
                <p class="input_wrap"><input type="text" style="width:25%;"> @ <select><option>선택하기</option></select> <input type="text" style="width:35%;"></p>
                <p class="pop-btn-wrap">
                	 <a href="contest_detail.php" class="blue-btn">OK</a>
                </p>

                <div class="pop-btn-close">
                    <a href="#!" class="btn-layerClose"><i class="xi-close-min xi-2x"></i></a>
                </div>
                <!--// content-->

        </div>
     </div>

</div></div></div>
        <!-- //layer -->
       <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
    $('.btn-layer').click(function(){
		$("body").addClass("fixed");
		$("html").addClass("fixed");
        var $href = $(this).attr('href');
        layer_popup($href);

    });
    function layer_popup(el){

        var $el = $(el);

 		$('.dimBg').fadeIn();
        $('.dim-layer').fadeIn();
 		$el.fadeIn();
        var $elWidth = ~~($el.outerWidth()),
            $elHeight = ~~($el.outerHeight()),
            docWidth = $(document).width(),
            docHeight = $(document).height();

        if ($elHeight < docHeight || $elWidth < docWidth) {
            $el.css({
                marginTop: -$elHeight /2,
                marginLeft: -$elWidth/2
            })
        } else {
            $el.css({top: 0, left: 0});
        }

        $el.find('a.btn-layerClose').click(function(){
			$("body").removeClass("fixed");
			$("html").removeClass("fixed");
            $('.dimBg').fadeOut();
        	$('.dim-layer').fadeOut();
 			$el.fadeOut();
            return false;
        });

        $('.dim-layer .dimBg').click(function(){
            $('.dim-layer').fadeOut();
            return false;
        });

    }


    </script>
<?php
include_once("./_tail.php");
?>
