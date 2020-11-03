<?php
include_once('./_common.php');

if(!$pr_id)
	alert('프로젝트 고유번호가 넘어오지 않았습니다.', 'contest.php');


$today = date('Y-m-d', G5_SERVER_TIME);


if ($tmp_pr_id = get_cookie('ck_pr_id_'.$pr_id)) {
	$vote_email = $tmp_pr_id;
}else{
	$vote_email = $email_1."@".$email_2;
	set_cookie('ck_pr_id_'.$pr_id, $vote_email, 86400 * 365 * 10);
}

$sql = " select * from AV_PR where pr_id = '{$pr_id}' ";
$pr = sql_fetch($sql);

if($pr['to_date'] < $today){
	$mode = "end";
}

$thumb_bg = get_app_thumbnail("AV_PR", $pr['pr_id'], 1920, 556, 0);

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/contest_detail.php');
    return;
}

include_once(G5_PATH.'/head.sub1.php');
?>
<div  style="margin-top:-60px;">
<div class="contTop2 contestTopdetail" style="background: url('<?php echo $thumb_bg['src']?>') no-repeat center center;">
<div class="contTop_bg">
<div class="inner">
	<span class="date">진행기간 <?php echo $pr['fr_date']; ?>~<?php echo $pr['to_date']; ?></span>
	<strong><?php echo nl2br($pr['pr_subject']) ?></strong>
	
	<span><?php echo nl2br($pr['pr_info']) ?></span>
</div>
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


<?php
$sql = " select * from AV_CR where (1) and pr_id = '{$pr_id}' order by cr_id desc ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {

	$thumb = get_app_thumbnail("AV_CR", $row['cr_id'], 636, 350, 0);
?>
		<!-- 캐릭터 -->
		<div class="contest_sec_wrap">
        	
            <div class="sec_edit_wrap">
            	<div class="img_edit">
					<?php
					if($thumb['src']){
					?>
    				<img src="<?php echo $thumb['src']?>" title="">
					<?php } ?>
                </div>
                <div class="text_edit">
                <h5><?php echo $row['cr_subject'] ?></h5>
                <p><?php echo nl2br($row['cr_info']) ?></p>
                </div>
            </div>
            <!-- sec1 -->

			<?php
			if($mode=="end")
				$sql = " select * from AV_CN where (1) and cr_id = '{$row['cr_id']}' order by cn_vote desc, cn_id asc limit 0,1 ";
			else
				$sql = " select * from AV_CN where (1) and cr_id = '{$row['cr_id']}' order by cn_vote desc, cn_id asc ";

			$result_cn = sql_query($sql);
			for ($m=0; $cn=sql_fetch_array($result_cn); $m++) {

				$file = sql_fetch("select * from g5_board_file where bo_table='AV_CN' and wr_id='{$cn['cn_id']}' and bf_no='0' "); 

				$sql = " select * from AV_VOTE where cn_id = '{$cn['cn_id']}' and vote_email = '$vote_email' ";
				$check_vote = sql_fetch($sql);
			?>
           <div class="Player_wrap">
			<?php
				if($m==0){
			?>
           	<div class="player_name"><span>1등</span> 후보 <img src="/img/no1.png" alt=""/></div>
			<?php
				}else{
			?>
			<div class="player_name"><img src="/img/icon1.png" alt=""/> 후보<?php echo $m+1?> </div>
			<?php } ?>
				<div class="tagPlayer">
                    <div>
						<strong><?php echo get_text($cn['cn_name']) ?></strong>
                        <p class="vote_count"><i class="xi-package"></i>현재 득표수 : <?php echo $cn['cn_vote'] ?></p>
					</div>
					<div>
						<div class="audioPlayer" id="player01">
							<audio controls src="/data/AV_CN/<?php echo $file['bf_file']?>"></audio>
						</div>
					</div>
				</div>
				<?php
				if($check_vote['vote_email'] || $mode=="end"){
				?>
				<p class="vote_btn_wrap"><p class="vote_btn_end">투표 완료</p></p>
				<?php
				}else{
				?>
				<p class="vote_btn_wrap" id="vote_<?php echo $cn['cn_id']?>"><a href="#layer2" data-vote-id="<?php echo $cn['cn_id']?>" class="btn-layer vote_btn">투표 참여하기</a></p>
				<?php } ?>

</div>
			<?php } ?>
 <!-- //sec1 -->
	 
</div>
<!--//캐릭터 -->
<?php 
}
?>
         
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
<!-- layer -->
<div class="dim-layer">
    <div class="dimBg"></div>
     
        <div id="layer2" class="pop-layer">
        <div class="pop-container">
            
                <!--content //-->
                <p class="pop-title">투표가 완료되었습니다</p>
                <p>투표가 완료되었습니다</p>
                
                <p class="pop-btn-wrap">
                	 <a href="contest_detail.php?pr_id=<?php echo $pr_id?>" class="btn-layer blue-btn">확인</a>
                </p>

                <div class="pop-btn-close">
                    <a href="#" class="btn-layerClose"><i class="xi-close-min xi-2x"></i></a>
                </div>
                <!--// content-->
           
        </div>
    </div>
</div></div></div>
        <!-- //layer -->
       <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>  
<script>
    $('.btn-layer').click(function(){

		var cn_id = $(this).attr('data-vote-id');
		var $href = $(this).attr('href');

			$.ajax({
				url:'./contest_ajax.php',
				type:'post',
				dataType: 'json',
				data:{
					cn_id:cn_id, vote_email:'<?php echo $vote_email?>' 
				},
				success:function(data){
					if(data.result=="1"){
						$("body").addClass("fixed");
						$("html").addClass("fixed");
						layer_popup($href);

						//$("#vote_"+cn_id).html("<p class='vote_btn_end'>투표 완료</p>");
					}
				},
				error: function (request, status, error) {
					console.log('code: '+request.status+"\n"+'message: '+request.responseText+"\n"+'error: '+error);
				}
			});


		//var cn_id = $(this).attr('data-vote-id');
		//$("#vote_"+cn_id).html("<p class='vote_btn_end'>투표 완료</p>");
		
    });
    function layer_popup(el){

		var url = "contest_detail.php?pr_id=<?php echo $pr_id?>";

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

			location.href=url;

            return false;
        });

        $('.dim-layer .dimBg').click(function(){
            $('.dim-layer').fadeOut();

			location.href=url;

            return false;
        });

    }

     
    </script>
<?php
include_once("./_tail.php");
?>