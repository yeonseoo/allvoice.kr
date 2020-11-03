<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once(G5_THEME_PATH . '/head.sub.php');
include_once(G5_LIB_PATH . '/outlogin.lib.php');
include_once(G5_LIB_PATH . '/visit.lib.php');
include_once(G5_LIB_PATH . '/connect.lib.php');
include_once(G5_LIB_PATH . '/popular.lib.php');
include_once(G5_LIB_PATH . '/latest.lib.php');
?>

<div id="ttrxHeader">
    <div>
        <a href="/shop/"><img src="../theme/basic/img/mobile/img_logo.png"/></a>
        <div>
            <a href="../inbox/inbox_room_list.php" id="inboxRoomList"><img src="../theme/basic/img/mobile/btn_mobile_inbox.png"/><img src="../theme/basic/img/mobile/btn_mobile_inbox.png"/></a>
            <a href="javascript:;" id="searchToggle"><img src="../theme/basic/img/mobile/btn_searchOpen.png"/><img src="../theme/basic/img/mobile/btn_searchClose.png"/></a>
            <a href="javascript:;" id="gnbToggle"><img src="../theme/basic/img/mobile/btn_gnbOpen.png"/><img src="../theme/basic/img/mobile/btn_gnbClose.png"/></a>
        </div>
    </div>
</div>

<div id="searchPopCover"></div>
<div id="searchPop">
    <strong>성우찾기</strong>
    <form name="frmsearch1" action="<?php echo G5_SHOP_URL; ?>/search.php" onsubmit="return search_submit(this);">
        <input type="text" name="q" value="<?php echo stripslashes(get_text(get_search_string($q))); ?>" id="sch_str" required placeholder="찾으실 성우의 이름 또는 아이디를 입력하세요.">
        <input type="image" src="../theme/basic/img/mobile/btn_searchSubmit.png"/>
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

<div id="gnbPop">
    <div>
        <?php if ($is_member) { ?>
            <a href="/shop/voiceMypage.php">마이페이지</a>
            <a class="on" href="<?php echo G5_BBS_URL; ?>/logout.php?url=shop">로그아웃</a>
        <?php } else { ?>
            <a href="<?php echo G5_URL; ?>/bbs/login2.php">로그인</a>
            <a href="<?php echo G5_SHOP_URL; ?>/voiceSignup.php">회원가입</a>
        <?php } ?>
        <a href=<?php echo G5_SHOP_URL; ?>/after.php>보이스매칭</a>
        <a href="<?php echo G5_SHOP_URL; ?>/how.php">이용방법</a>
    </div>
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
                <a href="<?php echo G5_SHOP_URL; ?>/voiceList.php?cat=<?php echo $row['ca_id']; ?>"><?php echo $row['ca_name']; ?></a>
            </li>
            <?php
        }
        ?>

        <li>
            <a href="javascript:;" class="drop">작업의뢰 프로젝트</a>
            <ul>
                <?php
                //<?php echo G5_SHOP_URL; /voiceProject.php
                $sql = " select * from {$g5['g5_shop_category_table']} ";
                //if ($is_admin != 'super')
                //    $sql .= " where ca_mb_id = '{$member['mb_id']}' ";
                $sql .= " order by ca_order, ca_id ";
                $result = sql_query($sql);
                for ($i = 0; $row = sql_fetch_array($result); $i++) {
                    if ($row['ca_id'] == $_REQUEST['cat']) {
                        $catagory_name = $row['ca_name'];
                    }
                    ?>
                    <li><a href="<?php echo G5_SHOP_URL; ?>/voiceProject.php?cat=<?php echo $row['ca_id']; ?>" <?php echo ($row['ca_id'] == $_REQUEST['cat']) ? "class='on'" : ""; ?>><?php echo $row['ca_name']; ?></a></li>
                    <?php
                }
                ?>
            </ul>
        </li>
        <li>
            <a href="<?php echo G5_URL; ?>/bbs/faq.php">고객센터</a>
        </li>
    </ul>
</div>

<script type="text/javascript">
    $(function () {
        $("#gnbPop > ul > li > ul").slideUp(0);
        $("#searchToggle").click(function () {
            $("#searchPopCover").toggle();
            $("#searchPop").toggle();
            $(this).toggleClass("on");
            if ($(this).hasClass("on")) {
                $("html, body").css("overflow", "hidden");
                $("html, body").css("height", "100vh");
            } else {
                $("html, body").css("overflow", "auto");
                $("html, body").css("height", "auto");
            }

            $("#gnbToggle").removeClass("on");
            $("#gnbPop").hide();
        });
        $("#gnbToggle").click(function () {
            $("#gnbPop").toggle();
            $(this).toggleClass("on");
            if ($(this).hasClass("on")) {
                $("html, body").css("overflow", "hidden");
                $("html, body").css("height", "100vh");
            } else {
                $("html, body").css("overflow", "auto");
                $("html, body").css("height", "auto");
            }

            $("#searchToggle").removeClass("on");
            $("#searchPop").hide();
            $("#searchPopCover").hide();
        });

        $("#searchPopCover").click(function () {
            $("#searchToggle").removeClass("on");
            $("#searchPop").hide();
            $("#searchPopCover").hide();
        });

        $("#gnbPop > ul > li > a.drop").click(function () {
            if ($(this).hasClass("on")) {
                $(this).removeClass("on");
                $(this).next().slideUp(500);
            } else {
                $("#gnbPop > ul > li > a.drop").removeClass("on");
                $(this).addClass("on");
                $("#gnbPop > ul > li > ul").slideUp(500);
                $(this).next().slideDown(500);
            }
        });

        $("#inboxRoomList").click(function () {
            <?php
            if ($member['mb_order_block_yn'] == '1') {

                echo "alert('문의가 제한된 회원입니다.\\n올보이스 고객센터로 문의해 주세요.');";
                echo "return false;";

            }
            ?>
        });

    });
</script>