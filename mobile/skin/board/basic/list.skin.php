<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 2;

if ($is_checkbox) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<!-- 게시판 목록 시작 -->

<?php if($_GET[bo_table] == "notice"){ ?>
<div class="contTop4">
	<strong>고객센터 - 공지사항</strong>
	<hr />
	<span>올보이스에의 다양한 소식을 만나보세요.</span>
</div>
<?php } ?>

<?php if($_GET[bo_table] == "qa"){ ?>
<div class="contTop4">
	<strong>고객센터 - 문의하기</strong>
	<hr />
	<span>1:1 문의를 통해 더 자세한 궁금증을 해결해보세요.</span>
</div>
<?php } ?>

<style type="text/css">
.listInfo{}
.listOrder ul li{width:33.3%;}
.listOrder ul li a{text-align:center;}
.tableSet01{width:calc(100% - 30px);margin:0 15px;}
</style>

<div class="listInfo" style="display:block;">
	<div class="listOrder" style="float:none;">
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

    <div class="tableSet01">
    				<table>
    					<colgroup>
    					<?php if($_GET["bo_table"] == "qa"){ ?>
    						<col width="60" />
    						<col width="*" />
    						<col width="60" />
    					<?php } else { ?>
    						<col width="*" />
    						<col width="60" />
    						<col width="60" />
    					<?php } ?>
    					</colgroup>
    					<thead>
    						<tr>
    							<?php if($_GET["bo_table"] == "qa"){ ?>
    								<th>분류</th>
        							<th>제목</th>
        							<th>작성자</th>
    							<?php } else { ?>
        							<th>제목</th>
    								<th>작성일</th>
        							<th>작성자</th>
    							<?php } ?>
    							
    						</tr>
    					</thead>
    					<tbody>
        <?php
        for ($i=0; $i<count($list); $i++) {
         ?>
        <tr>
        	<?php if($_GET["bo_table"] == "qa"){ ?>
        		<td><span class="bo_v_cate"><?php echo $list[$i]['ca_name']; // 분류 출력 끝 ?></span></td>
            	<td style="text-align:left;">
            		<a href="<?php echo $list[$i]['href'] ?>">
                    	<?php echo $list[$i]['subject'] ?>
                    </a>
                </td>
                <td><?php echo $list[$i]['name'] ?></td>
        	<?php } else { ?>
            	<td>
            		<a href="<?php echo $list[$i]['href'] ?>">
                    	<?php echo $list[$i]['subject'] ?>
                    </a>
                </td>
                <td><?php echo $list[$i]['datetime2'] ?></td>
                <td><?php echo $list[$i]['name'] ?></td>
        	<?php } ?>
            

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
            <!-- 
            <li><button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class="btn btn_admin"><i class="fa fa-trash-o" aria-hidden="true"></i> 선택삭제</button></li>
            <li><button type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value" class="btn btn_admin"><i class="fa fa-files-o" aria-hidden="true"></i> 선택복사</button></li>
            <li><button type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value" class="btn btn_admin"><i class="fa fa-arrows" aria-hidden="true"></i> 선택이동</button></li>
             -->
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
<?php echo $write_pages; ?>

<fieldset id="bo_sch">
    <legend>게시물 검색</legend>

    <form name="fsearch" method="get">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sop" value="and">
    <label for="sfl" class="sound_only">검색대상</label>
    <select name="sfl" id="sfl">
        <option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
        <option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
        <option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
        <option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option>
        <option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option>
        <option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
        <option value="wr_name,0"<?php echo get_selected($sfl, 'wr_name,0'); ?>>글쓴이(코)</option>
    </select>
    <input name="stx" value="<?php echo stripslashes($stx) ?>" placeholder="검색어(필수)" required id="stx" class="sch_input" size="15" maxlength="20">
    <button type="submit" value="검색" class="sch_btn"><i class="fa fa-search" aria-hidden="true"></i> <span class="sound_only">검색</span></button>
    </form>
</fieldset>

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

    if (sw == 'copy')
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
<!-- 게시판 목록 끝 -->
