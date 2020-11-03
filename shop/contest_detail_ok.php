<?php
include_once('./_common.php');


if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/contest_detail_ok.php');
    return;
}

include_once(G5_PATH.'/head.sub1.php');
?>
<div  style="margin-top:-60px;">
<div class="contTop2 contestTopdetail" style="background: url(../img/sample2.png) no-repeat center center;">
<div class="inner">
	<span class="date">진행기간 2019.05.06 ~ 18</span>
	<strong>메이플스토리 신규캐릭터<br/>올보이스 오디션</strong>
	
	<span>넥슨에서 제작하는 메이플스토리 신규캐릭터 2명을 올보이스와함께 오디션을 진행합니다.<br/>
캐릭터 스타일은 귀여운궁수와 호걸타입의 캐릭터입니다.</span>
</div>
</div>
	<div>
<div class="ttrxHeader sub">
	<div>
		<a href="/shop/"><img src="/theme/basic/img/img_logo2.png" title=""></a>
	</div>
</div>

<!-- 성우상세 { -->



<script type="text/javascript">
$(function(){
	$("#contentsWrap > div").before("<div class='contTop2'>"+$(".contTop").html()+"</div>");
	$(".contTop").remove();
});
</script>

<div class="listWrap">
	<div class="listCont_fullnone">
		
		<!-- 캐릭터 -->
		<div class="contest_sec_wrap">
        	
            <div class="sec_edit_wrap">
            	<div class="img_edit">
                <img src="../img/sample.png">
                </div>
                <div class="text_edit">
                <h5>아르페우스 (귀여운 궁수 타입)</h5>
                <p>아르페우스는 궁수형 타입의 캐릭터입니다. 평소에는 자신의 모습을 숨기며 살아가지만 전투에는 광범위한 공격으로 팀원들을 돕는 타격캐릭터입니다.
전투중의 모습을 본 사람이라면 모두가 반해버릴 미모소유자로 털털하고 귀여운 캐릭터입니다.</p>
                </div>
            </div>
            <!-- sec1 -->
           <div class="Player_wrap">
           	<div class="player_name"><span>1등</span> 후보 <img src="/img/no1.png" alt=""/></div>
				<div class="tagPlayer">
					<!--div>
						<strong><?php echo $row['mv_title']; ?></strong>
						<span><?php echo $category_arr[$row['mv_cat']]; ?></span>
						<span><?php echo $gender_arr[$row['mv_gen']]; ?></span>
						<span><?php echo $age_arr[$row['mv_age']]; ?></span>
						<span><?php echo $style_arr[$row['mv_sty']]; ?></span>
						<span><?php echo $tone_arr[$row['mv_ton']]; ?></span>
						<span><?php echo $language_arr[$row['mv_lan']]; ?></span>
					</div-->
                    <div>
						<strong>30대 초반, 진중한 남자</strong>
                        <p class="vote_count"><i class="xi-package"></i>현재 득표수 : 000</p>
					</div>
					<div>
						<div class="audioPlayer" id="player01">
							<audio controls src="<?php echo $audio_url; ?>"></audio>
						</div>
					</div>
				</div>
<p class="vote_btn_wrap"><p class="vote_btn_end">투표 완료</p></p>

</div>
 <!-- //sec1 -->
 <!-- sec1 -->
           <div class="Player_wrap">
           	<div class="player_name"><img src="/img/icon1.png" alt=""/> 후보2 </div>
				<div class="tagPlayer">
					<!--div>
						<strong><?php echo $row['mv_title']; ?></strong>
						<span><?php echo $category_arr[$row['mv_cat']]; ?></span>
						<span><?php echo $gender_arr[$row['mv_gen']]; ?></span>
						<span><?php echo $age_arr[$row['mv_age']]; ?></span>
						<span><?php echo $style_arr[$row['mv_sty']]; ?></span>
						<span><?php echo $tone_arr[$row['mv_ton']]; ?></span>
						<span><?php echo $language_arr[$row['mv_lan']]; ?></span>
					</div-->
                    <div>
						<strong>30대 초반, 진중한 남자</strong>
                        <p class="vote_count"><i class="xi-package"></i>현재 득표수 : 000</p>
					</div>
					<div>
						<div class="audioPlayer" id="player01">
							<audio controls src="<?php echo $audio_url; ?>"></audio>
						</div>
					</div>
				</div>
<p class="vote_btn_wrap"><p class="vote_btn_end">투표 완료</p></p>

</div>
 <!-- //sec1 -->
        </div>
		<!--//캐릭터 -->
        
       <!-- 캐릭터 -->
		<div class="contest_sec_wrap">
        	
            <div class="sec_edit_wrap">
            	<div class="img_edit">
                <img src="../img/sample.png">
                </div>
                <div class="text_edit">
                <h5>아르페우스 (귀여운 궁수 타입)</h5>
                <p>아르페우스는 궁수형 타입의 캐릭터입니다. 평소에는 자신의 모습을 숨기며 살아가지만 전투에는 광범위한 공격으로 팀원들을 돕는 타격캐릭터입니다.
전투중의 모습을 본 사람이라면 모두가 반해버릴 미모소유자로 털털하고 귀여운 캐릭터입니다.</p>
                </div>
            </div>
            <!-- sec1 -->
           <div class="Player_wrap">
           	<div class="player_name"><span>1등</span> 후보 <img src="/img/no1.png" alt=""/></div>
				<div class="tagPlayer">
					<!--div>
						<strong><?php echo $row['mv_title']; ?></strong>
						<span><?php echo $category_arr[$row['mv_cat']]; ?></span>
						<span><?php echo $gender_arr[$row['mv_gen']]; ?></span>
						<span><?php echo $age_arr[$row['mv_age']]; ?></span>
						<span><?php echo $style_arr[$row['mv_sty']]; ?></span>
						<span><?php echo $tone_arr[$row['mv_ton']]; ?></span>
						<span><?php echo $language_arr[$row['mv_lan']]; ?></span>
					</div-->
                    <div>
						<strong>30대 초반, 진중한 남자</strong>
                        <p class="vote_count"><i class="xi-package"></i>현재 득표수 : 000</p>
					</div>
					<div>
						<div class="audioPlayer" id="player01">
							<audio controls src="<?php echo $audio_url; ?>"></audio>
						</div>
					</div>
				</div>
<p class="vote_btn_wrap"><p class="vote_btn_end">투표 완료</p></p>

</div>
 <!-- //sec1 -->
 <!-- sec1 -->
           <div class="Player_wrap">
           	<div class="player_name"><img src="/img/icon1.png" alt=""/> 후보2 </div>
				<div class="tagPlayer">
					<!--div>
						<strong><?php echo $row['mv_title']; ?></strong>
						<span><?php echo $category_arr[$row['mv_cat']]; ?></span>
						<span><?php echo $gender_arr[$row['mv_gen']]; ?></span>
						<span><?php echo $age_arr[$row['mv_age']]; ?></span>
						<span><?php echo $style_arr[$row['mv_sty']]; ?></span>
						<span><?php echo $tone_arr[$row['mv_ton']]; ?></span>
						<span><?php echo $language_arr[$row['mv_lan']]; ?></span>
					</div-->
                    <div>
						<strong>30대 초반, 진중한 남자</strong>
                        <p class="vote_count"><i class="xi-package"></i>현재 득표수 : 000</p>
					</div>
					<div>
						<div class="audioPlayer" id="player01">
							<audio controls src="<?php echo $audio_url; ?>"></audio>
						</div>
					</div>
				</div>
<p class="vote_btn_wrap"><p class="vote_btn_end">투표 완료</p></p>

</div>
 <!-- //sec1 -->
        </div>
		<!--//캐릭터 -->
	<script type="text/javascript">
$(function(){
	maudio({
	    obj:'audio',
	    fastStep:10
	});


	var dragFlag = false;
	$(".progress-bar").on("mousedown",function(){
		dragFlag = true;
	});

	$("*").on("mouseup",function(){
		dragFlag = false;
	});

	$(".progress-bar").on("click",function(){
		dragFlag = false;
		if(!$(this).parent().parent().hasClass("playing")) $(this).parent().find(".play").click();
	});

	$(".progress-bar").on("mousemove",function(event){
		var thisBar = $(this);
		var thisPass = $(this).find(".progress-pass");
		if(dragFlag){
			thisPass.css({
				"width" : ((event.pageX - 162) / thisBar.outerWidth() * 100) + "%"
			})
		}
	});
});
</script>	

<!--div class="bo_fx" style="width:880px;margin:0 auto;text-align:right;">
                <p><a href="/shop/contest.php" class="btn_b02 btn">목록</a></p>
            </div-->
		
	</div>
</div>

<!-- } 성우상세 끝 -->

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