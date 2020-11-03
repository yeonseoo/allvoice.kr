<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$faq_skin_url.'/style.css">', 0);
?>

<!-- FAQ 시작 { -->
<?php
// 상단 HTML
echo '<div id="faq_hhtml">'.conv_content($fm['fm_mobile_head_html'], 1).'</div>';
?>

<style type="text/css">
.listInfo{}
.listOrder ul li{width:33.3%;}
.listOrder ul li a{text-align:center;}
</style>

<div class="contTop5">
	<strong>고객센터 - 자주하는 질문</strong>
	<hr />
	<span>올보이스 이용시 궁금한점을 해결해 드립니다.</span>
</div>

<div class="listInfo" style="display:block;">
	<div class="listOrder" style="float:none;">
		<ul>
			<li><a href="/bbs/faq.php" class="on">자주하는질문</a></li>
			<li><a href="/bbs/board.php?bo_table=qa">문의하기</a></li>
			<li><a href="/bbs/board.php?bo_table=notice">공지사항</a></li>
		</ul>
	</div>
</div>

<div class="voiceFaqList">
	<ul>
		<?php
        foreach($faq_list as $key=>$v){
            if(empty($v))
                continue;
        ?>
        <li>
        	<?php
                $faqSubject = $v['fa_subject'];
                $faqSubject = str_replace("<p>","",$faqSubject);
                $faqSubject = str_replace("</p>","",$faqSubject);
                $faqSubject = trim($faqSubject);
        	?>
        	<span>Q</span><a href="javascript:;"><?php echo $faqSubject; ?></a><div><div>
        		<?php echo conv_content($v['fa_content'], 1); ?>
        	</div></div>
        </li>
        <?php
        }
        ?>
	</ul>
</div>

<script type="text/javascript">
$(function(){
	$(".voiceFaqList li > a").each(function(){
		$(this).click(function(){
    		if($(this).hasClass("on")){
        		$(this).next().slideUp(500);
        		$(this).removeClass("on");
    		} else {
        		$(".voiceFaqList li > div").slideUp(500);
    			$(this).next().slideDown(500);
    			$(".voiceFaqList li > a").removeClass("on");
    			$(this).addClass("on");
    		}
		});
	});
});
</script>

<?php echo get_paging($page_rows, $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>

<?php
// 하단 HTML
echo '<div id="faq_thtml">'.conv_content($fm['fm_mobile_tail_html'], 1).'</div>';
?>


<!-- } FAQ 끝 -->

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<script>
$(function() {
    $(".closer_btn").on("click", function() {
        $(this).closest(".con_inner").slideToggle();
    });
});

function faq_open(el)
{
    var $con = $(el).closest("li").find(".con_inner");

    if($con.is(":visible")) {
        $con.slideUp();
    } else {
        $("#faq_con .con_inner:visible").css("display", "none");

        $con.slideDown(
            function() {
                // 이미지 리사이즈
                $con.viewimageresize2();
            }
        );
    }

    return false;
}
</script>