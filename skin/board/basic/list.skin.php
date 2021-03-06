<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<?php if($_GET[bo_table] == "notice"){ ?>
<div class="contTop" style="opacity:0;">
	<strong>고객센터 - 공지사항</strong>
	<hr />
	<span>올보이스에의 다양한 소식을 만나보세요.</span>
</div>

<script type="text/javascript">
$(function(){
	$("#contentsWrap > div:first-child").before("<div class='contTop4'>"+$(".contTop").html()+"</div>");
	$(".contTop").remove();
});
</script>
<?php } ?>

<?php if($_GET[bo_table] == "qa"){ ?>
<div class="contTop" style="opacity:0;">
	<strong>고객센터 - 문의하기</strong>
	<hr />
	<span>1:1 문의를 통해 더 자세한 궁금증을 해결해보세요.</span>
</div>

<script type="text/javascript">
$(function(){
	$("#contentsWrap > div:first-child").before("<div class='contTop4'>"+$(".contTop").html()+"</div>");
	$(".contTop").remove();
});
</script>
<?php } ?>

<div class="listInfo">
	<div class="listOrder" style="float:left;">
		<ul>
			<li><a href="/bbs/faq.php">자주하는질문</a></li>
			<li><a href="/bbs/board.php?bo_table=qa"<?php if($_GET[bo_table] == "qa"){?> class="on"<?php } ?>>문의하기</a></li>
			<li><a href="/bbs/board.php?bo_table=notice"<?php if($_GET[bo_table] == "notice"){?> class="on"<?php } ?>>공지사항</a></li>
		</ul>
	</div>
</div>


<!-- 게시판 목록 시작 { -->
<div id="bo_list" style="width:<?php echo $width; ?>">

    <form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

    <div class="tableSet01" style="background-color:#fff;">
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
        for ($i=0; $i<count($list); $i++) {
         ?>
        <tr>
        	<td>
        		<a href="<?php echo $list[$i]['href'] ?>">
                	<?php if($list[$i]['ca_name'] != ""){ ?><span class="bo_v_cate"><?php echo $list[$i]['ca_name']; // 분류 출력 끝 ?></span>&nbsp;&nbsp;<?php } ?><?php echo $list[$i]['subject'] ?>
                </a>
            </td>
            <td><?php echo $list[$i]['datetime2'] ?></td>
            <td><?php echo $list[$i]['name'] ?></td>

        </tr>
        <?php } ?>
        <!--
        <?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">게시물이 없습니다.</td></tr>'; } ?>
         -->
        </tbody>
        </table>
    </div>

    <?php if ($list_href || $is_checkbox || $write_href) { ?>
    <div class="bo_fx">
        <?php if ($list_href || $write_href) { ?>
        <ul class="btn_bo_user">
            <?php if ($is_checkbox) { ?>
            <!-- <li><button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class="btn btn_admin"><i class="fa fa-trash-o" aria-hidden="true"></i> 선택삭제</button></li>
            <li><button type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value" class="btn btn_admin"><i class="fa fa-files-o" aria-hidden="true"></i> 선택복사</button></li>
            <li><button type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value" class="btn btn_admin"><i class="fa fa-arrows" aria-hidden="true"></i> 선택이동</button></li> -->
            <?php } ?>
            <?php if ($list_href) { ?><li><a href="<?php echo $list_href ?>" class="btn_b01 btn"><i class="fa fa-list" aria-hidden="true"></i> 목록</a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02 btn"><i class="fa fa-pencil" aria-hidden="true"></i> 글쓰기</a></li><?php } ?>
        </ul>
        <?php } ?>
    </div>
    <?php } ?>

    </form>
</div>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>



<!-- 페이지 -->
<?php echo $write_pages;  ?>


<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = "./board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == "copy")
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->
