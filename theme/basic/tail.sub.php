<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<?php if ($is_admin == 'super') {  ?><!-- <div style='float:left; text-align:center;'>RUN TIME : <?php echo get_microtime()-$begin_time; ?><br></div> --><?php }  ?>

<!-- Mirae Log Analysis Script Ver 1.0   -->
<script TYPE="text/javascript">
var mi_adkey = "olvfe";
var mi_is_defender = "";
var mi_dt=new Date(),mi_y=mi_dt.getFullYear(),mi_m=mi_dt.getMonth()+1,mi_d=mi_dt.getDate(),mi_h=mi_dt.getHours();
var mi_date=""+mi_y+(mi_m<=9?"0":"")+mi_m+(mi_d<=9?"0":"")+mi_d+(mi_h<=9?"0":"")+mi_h;
var mi_script = "<scr"+"ipt "+"type='text/javascr"+"ipt' src='//log1.toup.net/mirae_log.js?t="+mi_date+"' async='true'></scr"+"ipt>"; 
document.writeln(mi_script);
</script>
<!-- Mirae Log Analysis Script END  -->

<!-- ie6,7에서 사이드뷰가 게시판 목록에서 아래 사이드뷰에 가려지는 현상 수정 -->
<!--[if lte IE 7]>
<script>
$(function() {
    var $sv_use = $(".sv_use");
    var count = $sv_use.length;

    $sv_use.each(function() {
        $(this).css("z-index", count);
        $(this).css("position", "relative");
        count = count - 1;
    });
});
</script>
<![endif]-->

</body>
</html>
<?php echo html_end(); // HTML 마지막 처리 함수 : 반드시 넣어주시기 바랍니다. ?>