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
			<li><a href="?" <?php if(!$mode) echo 'class="on"'?>>프로젝트 진행중</a></li>
			<li><a href="?mode=end"  <?php if($mode=="end") echo 'class="on"'?>>선정된 목소리 듣기</a></li>
		</ul>
	</div>

<?php
$sql_common = " from AV_PR ";

$today = date('Y-m-d', G5_SERVER_TIME);

if ($mode=="end") {
	$sql_search = " where (1) and to_date < '{$today}' ";
}else{
	$sql_search = " where (1) and ( fr_date <= '{$today}' and to_date >= '{$today}'  ) ";
}

if (!$sst) {
    $sst  = "pr_id";
    $sod = "desc";
}
$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt
            {$sql_common}
            {$sql_search}
            {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
            {$sql_common}
            {$sql_search}
            {$sql_order}
            limit {$from_record}, {$rows} ";
$result = sql_query($sql);

//echo $sql;

?>

	<div class="listCont_full">




		<ul class="listData_new">
			<?php
			for ($i=0; $row=sql_fetch_array($result); $i++) {
				$thumb = get_app_thumbnail("AV_PR", $row['pr_id'], 636, 350, 0);
				
				$vote_email = get_cookie('ck_pr_id_'.$row['pr_id']);
			?>
			<li>
    			<a href="#layer1" class="btn-layer" data-id="<?php echo $row['pr_id']?>" data-vote="<?php echo $vote_email?>">
					<?php
					if($thumb['src']){
					?>
    				<img src="<?php echo $thumb['src']?>" title="">
					<?php } ?>
    			</a>
    			<div>
        			<strong><?php echo get_text($row['pr_subject']) ?></strong>
        			<p><?php echo nl2br($row['pr_info']) ?></p>
					<p class="date"><img src="/img/time.png" title=""> <strong class="color">진행기간</strong> <strong><?php echo $row['fr_date']; ?>~<?php echo $row['to_date']; ?></strong></p>
                    <p class="btn_wrap"><a href="#layer1" class="btn-layer" data-id="<?php echo $row['pr_id']?>" data-vote="<?php echo $vote_email?>" ><?php if(!$mode=="end") echo "참가하기" ?><?php if($mode=="end") echo "결과보기" ?></a></p>
                    
                    


    			</div>
			</li>
			<?php
			}
			?>
		</ul>

		<div class="ttrxPaging1">
			<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, '?mode='.$mode.$qstr.'&amp;page=');?>
		</div>


		<!-- <div class="ttrxPaging1"><ul>
<li class="on"><a href="#">1</a></li>
<li><a href="#">2</a></li>
<li><a href="#">3</a></li>
<li><a href="#">4</a></li>
</ul>
</div> -->












</div>
</div>

</div>

<style type="text/css">
.pop-container .pop-btn-wrap button.blue-btn {
    border: 1px solid #5f6edc;
    color: #5f6edc;
    font-size: 16px;
    padding: 10px 20px;
    margin: 0 2px;
    width: 40%;
    display: inline-block;
    overflow: hidden;
    position: relative;
}
.pop-container .pop-btn-wrap button.blue-btn{
    border: 1px solid #5f6edc;
    color: #fff;
    background: #5f6edc;
}	
</style>
<!-- } 성우상세 끝 -->
<!-- layer -->
<div class="dim-layer">
    <div class="dimBg"></div>
    <div id="layer1" class="pop-layer">
        <div class="pop-container">
			
				<form name="fpoll" id="fpoll" action="./contest_detail.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="pr_id" id="pr_id">

                <!--content //-->
                <p class="pop-title">투표에 참여하시겠습니까?</p>
                <p>참여해주신분 중, 추첨을 통하여 소정의 상품을 증정합니다.  <br/>'상품, 이벤트 안내를 위한 이메일을 입력해주세요.</p>
                <p class="input_wrap">
				<input type="text" style="width:25%;" name="email_1" required> @ 
				<select name="email_select" onchange="email_check()">
				<option>선택하기</option>
				<option value='empal.com' <?if($my_email[1]=="empal.com"){?>selected<?}?>>empal.com</option>
                          <option value='hotmail.com' <?if($my_email[1]=="hotmail.com"){?>selected<?}?>>hotmail.com</option>
                          <option value="naver.com" <?if($my_email[1]=="naver.com"){?>selected<?}?>>naver.com</option>
                          <option value="chol.com" <?if($my_email[1]=="chol.com"){?>selected<?}?>>chol.com</option>
                          <option value="dreamwiz.com" <?if($my_email[1]=="dreamwiz.com"){?>selected<?}?>>dreamwiz.com</option>
                          <option value="empal.com" <?if($my_email[1]=="empal.com"){?>selected<?}?>>empal.com</option>
                          <option value="freechal.com" <?if($my_email[1]=="freechal.com"){?>selected<?}?>>freechal.com</option>
                          <option value="gmail.com" <?if($my_email[1]=="gmail.com"){?>selected<?}?>>gmail.com</option>
                          <option value="hanafos.com" <?if($my_email[1]=="hanafos.com"){?>selected<?}?>>hanafos.com</option>
                          <option value="hanmail.net" <?if($my_email[1]=="hanmail.net"){?>selected<?}?>>hanmail.net</option>
                          <option value="hanmir.com" <?if($my_email[1]=="hanmir.com"){?>selected<?}?>>hanmir.net</option>
                          <option value="hitel.net" <?if($my_email[1]=="hitel.net"){?>selected<?}?>>hitel.net</option>
                          <option value="hotmail.com" <?if($my_email[1]=="hotmail.com"){?>selected<?}?>>hotmail.com</option>
                          <option value="korea.com" <?if($my_email[1]=="korea.com"){?>selected<?}?>>korea.com</option>
                          <option value="lycos.co.kr" <?if($my_email[1]=="lycos.co.kr"){?>selected<?}?>>lycos.co.kr</option>
                          <option value="nate.com" <?if($my_email[1]=="nate.com"){?>selected<?}?>>nate.com</option>
                          <option value="netian.com" <?if($my_email[1]=="netian.com"){?>selected<?}?>>netian.com</option>
                          <option value="paran.com" <?if($my_email[1]=="paran.com"){?>selected<?}?>>paran.com</option>
                          <option value="yahoo.co.kr" <?if($my_email[1]=="yahoo.co.kr"){?>selected<?}?>>yahoo.co.kr</option>
                          <option value=''>직접 입력</option>
				</select> 
				<input name="email_2" id="email_2" type="text" style="width:35%;" required></p>
                <p class="pop-btn-wrap">
					<!-- <a href="contest_detail.php" class="blue-btn">OK</a> -->
                	 <button type="submit" class="blue-btn">OK</button>
                </p>

                <div class="pop-btn-close">
                    <a href="#!" class="btn-layerClose"><i class="xi-close-min xi-2x"></i></a>
                </div>
                <!--// content-->

				</form>

        </div>
     </div>

</div></div></div>
        <!-- //layer -->
       <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

				<script type="text/javascript">
				<!--
					function email_check(){
						var f=document.fpoll;
						if(f.email_select.value!=""){
							f.email_2.value=f.email_select.value;
						}else{
							f.email_2.value="";
							f.email_2.focus();
						}
					}
				//-->
				</script>

<script>
    $('.btn-layer').click(function(){

		var vote_email = $(this).attr('data-vote');
		var pr_id = $(this).attr('data-id');

		<?php
		if ($mode=="end") {
		?>
		var url = "contest_detail.php?pr_id="+pr_id;
		location.href=url;
		<?php
		}else{
		?>

		if(vote_email){ //쿠키에 이메일이 있는경우//
			var url = "contest_detail.php?pr_id="+pr_id;
			location.href=url;
		}else{

			$("body").addClass("fixed");
			$("html").addClass("fixed");
			var $href = $(this).attr('href');

			layer_popup($href, pr_id);
		}
		//alert(pr_id);

		<?php } ?>

    });
    function layer_popup(el, pr_id){

		
		$("#pr_id").val(pr_id);

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
