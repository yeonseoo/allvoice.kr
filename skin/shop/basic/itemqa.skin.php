<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 상품문의 목록 시작 { -->
<section id="sit_qa_list">
    <div class="tableSet01">
		<table>
			<colgroup>
				<col width="*" />
				<col width="170" />
				<col width="170" />
			</colgroup>
			<thead>
				<tr>
					<th>제목</th>
					<th>작성일</th>
					<th>작성자</th>
				</tr>
			</thead>
			<tbody>
                <?php
                $thumbnail_width = 500;
                $iq_num     = $total_count - ($page - 1) * $rows;
            
                for ($i=0; $row=sql_fetch_array($result); $i++)
                {
                    $iq_name    = get_text($row['iq_name']);
                    $iq_subject = conv_subject($row['iq_subject'],50,"…");
            
                    $is_secret = false;
                    if($row['iq_secret']) {
                        $iq_subject .= ' <img src="'.G5_SHOP_SKIN_URL.'/img/icon_secret.gif" alt="비밀글">';
            
                        if($is_admin || $member['mb_id' ] == $row['mb_id']) {
                            $iq_question = get_view_thumbnail(conv_content($row['iq_question'], 1), $thumbnail_width);
                        } else {
                            $iq_question = '비밀글로 보호된 문의입니다.';
                            $is_secret = true;
                        }
                    } else {
                        $iq_question = get_view_thumbnail(conv_content($row['iq_question'], 1), $thumbnail_width);
                    }
                    $iq_time    = substr($row['iq_time'], 2, 8);
            
                    $hash = md5($row['iq_id'].$row['iq_time'].$row['iq_ip']);
            
                    $iq_stats = '';
                    $iq_style = '';
                    $iq_answer = '';
            
                    if ($row['iq_answer'])
                    {
                        $iq_answer = get_view_thumbnail(conv_content($row['iq_answer'], 1), $thumbnail_width);
                        $iq_stats = '답변완료';
                        $iq_style = 'sit_qaa_done';
                        $is_answer = true;
                    } else {
                        $iq_stats = '답변대기';
                        $iq_style = 'sit_qaa_yet';
                        $iq_answer = '답변이 등록되지 않았습니다.';
                        $is_answer = false;
                    }
            
                    //if ($i == 0) echo '<ol id="sit_qa_ol">';
                ?>
                <tr class="sit_qa_li_title2" data-no="<?php echo $i; ?>">
    				<td><?php echo $iq_subject; ?></td>
    				<td><?php echo $iq_time; ?></td>
    				<td><?php echo $iq_name; ?></td>
    			</tr>
    			<tr>
    				<td colspan="3" style="height:0;border-bottom:0;"><div id="sit_qa_con_<?php echo $i; ?>" class="sit_qa_con" style="margin-top:0;">
        					<div class="sit_qa_p" style="margin:0;">
        						<div class="sit_qa_qaq" style="text-align:left;">
        							<strong class="sound_only">내용</strong>
        							<?php echo $iq_question; // 상품 문의 내용 ?>
        						</div>
        					</div>
        
        					<?php if ($is_admin || ($row['mb_id'] == $member['mb_id'] && !$is_answer)) { ?>
        					<div class="sit_qa_cmd" style="margin-top:10px;">
        						<a href="<?php echo $itemqa_form."&amp;iq_id={$row['iq_id']}&amp;w=u"; ?>" class="itemqa_form  blueBtn" onclick="return false;">수정</a>
        						<a href="<?php echo $itemqa_formupdate."&amp;iq_id={$row['iq_id']}&amp;w=d&amp;hash={$hash}"; ?>" class="itemqa_delete  blueBtn">삭제</a>
        						<!-- <button type="button" onclick="javascript:itemqa_update(<?php echo $i; ?>);" class="btn01">수정</button>
        						<button type="button" onclick="javascript:itemqa_delete(fitemqa_password<?php echo $i; ?>, <?php echo $i; ?>);" class="btn01">삭제</button> -->
        					</div>
        					<?php } ?>
        				</div></td>
    			</tr>
                <?php
                    $iq_num--;
                }
                ?>
			</tbody>
		</table>
	</div>
	
	<div class="tableWrite">
		<a href="<?php echo $itemqa_form; ?>" class="newMassage">메시지 작성</a>
	</div>
</section>

<?php
echo itemqa_page($config['cf_write_pages'], $page, $total_page, "./itemqa.php?it_id=$it_id&amp;page=", "");
?>


<script>
$(function(){
    $(".itemqa_form").click(function(){
        window.open(this.href, "itemqa_form", "width=810,height=680,scrollbars=1");
        return false;
    });

    $(".itemqa_delete").click(function(){
        return confirm("정말 삭제 하시겠습니까?\n\n삭제후에는 되돌릴수 없습니다.");
    });

    $(".sit_qa_li_title2").click(function(){
        var $con = $("#sit_qa_con_"+$(this).data("no"));

        if($con.is(":visible")) {
            $con.slideUp();
        } else {
            $(".sit_qa_con:visible").hide();
			//alert ( "test = > "+$con.attr("id"));
            $con.slideDown(
                function() {
                    // 이미지 리사이즈
                    $con.viewimageresize2();
                }
            );
        }
    });

    $(".qa_page").click(function(){
        $("#itemqa").load($(this).attr("href"));
        return false;
    });
});
</script>
<!-- } 상품문의 목록 끝 -->