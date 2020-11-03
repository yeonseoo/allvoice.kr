<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MSHOP_PATH . '/shop.head.php');
    return;
}

include_once(G5_THEME_PATH . '/head.sub.php');
include_once(G5_LIB_PATH . '/outlogin.lib.php');
include_once(G5_LIB_PATH . '/poll.lib.php');
include_once(G5_LIB_PATH . '/visit.lib.php');
include_once(G5_LIB_PATH . '/connect.lib.php');
include_once(G5_LIB_PATH . '/popular.lib.php');
include_once(G5_LIB_PATH . '/latest.lib.php');

?>

<!-- 상단 시작 { -->

<div class="ttrxHeader sub">
    <div>
        <a href="/shop/"><img src="../theme/basic/img/img_logo2.png"/></a>
        <div>
            <div class="ttrxSearchEngine">
                <form name="frmsearch1" action="<?php echo G5_SHOP_URL; ?>/search.php"
                      onsubmit="return search_submit(this);">

                    <input type="text" name="q" value="<?php echo stripslashes(get_text(get_search_string($q))); ?>"
                           id="sch_str" required placeholder="성우찾기">
                    <input type="image" src="../theme/basic/img/btn_search2.png"/>

                </form>
                <script>
                    function search_submit(f) {
                        if (f.q.value.length < 2) {
                            alert("검색어는 두글자 이상 입력하십시오.");
                            f.q.select();
                            f.q.focus();
                            return false;
                        }
                        return true;
                    }
                </script>
            </div>

            <span>
        		<a href="<?php echo G5_SHOP_URL; ?>/how.php">이용방법</a>
        		<a href="<?php echo G5_SHOP_URL; ?>/after.php">보이스매칭</a>
        	</span>

            <ul>
                <?php if ($is_member) { ?>
                    <li><a href="/shop/inboxMessage.php" id = "head_message">1:1 채팅</a></li>
                    <li><a href="/shop/voiceMypage.php">마이페이지</a></li>
                    <li><a href="<?php echo G5_BBS_URL; ?>/logout.php?url=shop">로그아웃</a></li>
                    <!--li><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php">정보수정</a></li-->

                    <?php if ($is_admin) { ?>
                        <li><a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/">관리자</a></li>
                    <?php } ?>
                <?php } else { ?>
                    <li><a href="<?php echo G5_URL; ?>/bbs/login2.php">로그인</a></li>
                    <li><a href="<?php echo G5_SHOP_URL; ?>/voiceSignup.php">회원가입</a></li>
                <?php } ?>
            </ul>

        </div>

    </div>
</div>

<div id="subCate">
    <div id="subCateDep01">
        <div>
            <ul>
                <?php
                $sql = " select * from {$g5['g5_shop_category_table']} ";
                //if ($is_admin != 'super')
                //    $sql .= " where ca_mb_id = '{$member['mb_id']}' ";
                $sql .= " order by ca_order, ca_id ";
                $result = sql_query($sql);
                for ($i = 0; $row = sql_fetch_array($result); $i++) {
                    $len = strlen($row['ca_id']) / 2 - 1;

                    $nbsp = "";
                    for ($i = 0; $i < $len; $i++)
                        $nbsp .= "&nbsp;&nbsp;&nbsp;";

                    $category_select .= "<option value=\"{$row['ca_id']}\">$nbsp{$row['ca_name']}</option>\n";

                    $script .= "ca_use['{$row['ca_id']}'] = {$row['ca_use']};\n";
                    $script .= "ca_stock_qty['{$row['ca_id']}'] = {$row['ca_stock_qty']};\n";
                    //$script .= "ca_explan_html['$row[ca_id]'] = $row[ca_explan_html];\n";
                    $script .= "ca_sell_email['{$row['ca_id']}'] = '{$row['ca_sell_email']}';\n";
                    ?>
                    <li>
                        <a href="<?php echo G5_SHOP_URL; ?>/voiceList_f.php?cat=<?php echo $row['ca_id']; ?>" <?php echo ($row['ca_id'] == $_REQUEST['cat']) ? "class='on'" : ""; ?>><?php echo $row['ca_name']; ?></a>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <span class="border_right_none"><a href="<?php echo G5_SHOP_URL; ?>/voiceProject.php">등록된 오디션</a></span>
            <!-- <a href="<?php echo G5_URL; ?>/bbs/faq.php">고객센터</a> -->
        </div>
    </div>
    <!--
	<div class="subCateDep02">
		<div>
    		<ul>
    			<li><a href="/shop/voiceList.php">카테고리명01</a></li>
    			<li><a href="/shop/voiceList.php">카테고리명02</a></li>
    			<li><a href="/shop/voiceList.php" class="on">카테고리명03</a></li>
    			<li><a href="/shop/voiceList.php">카테고리명04</a></li>
    			<li><a href="/shop/voiceList.php">카테고리명05</a></li>
    			<li><a href="/shop/voiceList.php">카테고리명06</a></li>
    			<li><a href="/shop/voiceList.php">카테고리명07</a></li>
    			<li><a href="/shop/voiceList.php">카테고리명08</a></li>
    			<li><a href="/shop/voiceList.php">카테고리명09</a></li>
    		</ul>
		</div>
	</div>
     -->
</div>

<script type="text/javascript">
    $(function () {
        //$(".subCateDep02 > div > ul > li").css("width",(100 / $(".subCateDep02 > div > ul > li").length) + "%");
    });
</script>

<div id="contentsWrap">
    <div>
        <!-- } 상단 끝 -->
