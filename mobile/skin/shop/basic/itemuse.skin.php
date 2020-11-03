<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
    			<div class="voiceLv">
    				<strong>고객평점</strong>
    				<!--em class="star02"></em-->
					<img src="img/s_star<?php echo $mem_dt['it_use_avg'] <= 0 ? "5" : intval($mem_dt['it_use_avg']); ?>.png"  width="70"/>
    				<span><?php echo $total_count; ?>개의 평가</span>
    			</div>
    			
    			<div class="listBoard">
    <?php
    $thumbnail_width = 500;

    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $is_num     = $total_count - ($page - 1) * $rows - $i;
        $is_star    = get_star($row['is_score']);
        $is_name    = get_text($row['is_name']);
        $is_subject = conv_subject($row['is_subject'],50,"…");
        //$is_content = ($row['wr_content']);
        $is_content = get_view_thumbnail(conv_content($row['is_content'], 1), $thumbnail_width);
        $is_reply_name = !empty($row['is_reply_name']) ? get_text($row['is_reply_name']) : '';
        $is_reply_subject = !empty($row['is_reply_subject']) ? conv_subject($row['is_reply_subject'],50,"…") : '';
        $is_reply_content = !empty($row['is_reply_content']) ? get_view_thumbnail(conv_content($row['is_reply_content'], 1), $thumbnail_width) : '';
        $is_time    = substr($row['is_time'], 2, 8);
        $is_href    = './itemuselist.php?bo_table=itemuse&amp;wr_id='.$row['wr_id'];

        $hash = md5($row['is_id'].$row['is_time'].$row['is_ip']);

        //if ($i == 0) echo '<ol id="sit_use_ol">';
    ?>
    				<a href="javascript:;">
    					<strong><?php echo $is_subject; ?></strong>
    					<div>
    						<?php echo nl2br($is_content); // 사용후기 내용 ?>


                <?php /*if( $is_reply_subject ){  //  사용후기 답변 내용이 있다면 ?>
                <div class="sit_use_reply">
                    <div class="use_reply_icon">답변</div>
                    <div class="use_reply_tit">
                        <?php echo $is_reply_subject; // 답변 제목 ?>
                    </div>
                    <div class="use_reply_name">
                        <?php echo $is_reply_name; // 답변자 이름 ?>
                    </div>
                    <div class="use_reply_p">
                        <?php echo $is_reply_content; // 답변 내용 ?>
                    </div>
                </div>
                <?php } //end if */?>
    					</div>
    					<span><?php echo $is_name; ?></span>
    					<b><?php echo $is_time; ?></b>
    					<!--em class="star03"></em-->
						<img src="img/s_star<?php echo $is_star <= 0 ? "1" : intval($is_star); ?>.png" width="70" />
    				</a>
                <?php if ($is_admin || $row['mb_id'] == $member['mb_id']) { ?>
                <div class="sit_use_cmd">
                    <a href="<?php echo $itemuse_form."&amp;is_id={$row['is_id']}&amp;w=u"; ?>" class="itemuse_form btn01" onclick="return false;">수정</a>
                    <a href="<?php echo $itemuse_formupdate."&amp;is_id={$row['is_id']}&amp;w=d&amp;hash={$hash}"; ?>" class="itemuse_delete btn01">삭제</a>
                </div>
                <?php } ?>
    				

    <?php 
	}

    if (!$i) echo '<p class="sit_empty">리뷰가 없습니다.</p>';
    ?>


    			</div>
    			
    			
<?php
echo itemuse_page($config['cf_mobile_pages'], $page, $total_page, "./itemuse.php?it_id=$it_id&amp;page=", "");
?>
        		
    			<div class="tableWrite">
    				<a href="<?php echo $itemuse_form; ?>" class="reviewTable itemuse_form">리뷰 작성</a>
    			</div>


<script>
$(function(){
    $(".itemuse_form").click(function(){
        window.open(this.href, "itemuse_form", "width=810,height=680,scrollbars=1");
        return false;
    });

    $(".itemuse_delete").click(function(){
        if (confirm("정말 삭제 하시겠습니까?\n\n삭제후에는 되돌릴수 없습니다.")) {
            return true;
        } else {
            return false;
        }
    });

    $(".sit_use_li_title").click(function(){
        var $con = $(this).siblings(".sit_use_con");
        if($con.is(":visible")) {
            $con.slideUp();
        } else {
            $(".sit_use_con:visible").hide();
            $con.slideDown(
                function() {
                    // 이미지 리사이즈
                    $con.viewimageresize2();
                }
            );
        }
    });

    $(".pg_page").click(function(){
        $("#itemuse").load($(this).attr("href"));
        return false;
    });

    $("a#itemuse_list").on("click", function() {
        window.opener.location.href = this.href;
        self.close();
        return false;
    });
});
</script>
<!-- } 상품 사용후기 끝 -->