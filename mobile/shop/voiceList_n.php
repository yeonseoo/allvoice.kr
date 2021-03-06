<?php
include_once('./_common.php');

// include_once(G5_MSHOP_PATH . '/_head.php');

if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH . '/shop.head.php');
    return;
}

include_once(G5_THEME_PATH . '/head.sub.php');
include_once(G5_LIB_PATH . '/latest.lib.php');
include_once(G5_LIB_PATH . '/outlogin.lib.php');
include_once(G5_LIB_PATH . '/poll.lib.php');
include_once(G5_LIB_PATH . '/visit.lib.php');
include_once(G5_LIB_PATH . '/connect.lib.php');
include_once(G5_LIB_PATH . '/popular.lib.php');


//===== 상단 메뉴 카테고리 =====//
$menu_cat = isset($_GET['cat']) ? $_GET['cat'] : "1";

//===== 검색 조건 ====//
// 이름
$search_name = isset($_GET['search_name']) ? $_GET['search_name'] : "";
// 카테고리
$search_cat = isset($_GET['search_cat']) ? $_GET['search_cat'] : "";
// 성별
$search_gen = isset($_GET['search_gen']) ? $_GET['search_gen'] : "";
// 나이대
$search_age = isset($_GET['search_age']) ? $_GET['search_age'] : "";
// 스타일
$search_style = isset($_GET['search_style']) ? $_GET['search_style'] : "";
// 톤
$search_ton = isset($_GET['search_ton']) ? $_GET['search_ton'] : "";
// 언어
$search_lan = isset($_GET['search_lan']) ? $_GET['search_lan'] : "";

// 검색 조건에 카테고리 값이 있으면..
if (!empty($search_cat)) {
    $menu_cat = $search_cat;
}

//===== 쿼리 조건 =====//
if (1 < $menu_cat) {
    $whereCategory .= " WHERE mv_cat=" . $menu_cat;
} else {
    $whereCategory .= " WHERE mv_cat > 1";
}

$condition = "WHERE";

if (1 < $menu_cat) {
    $condition .= " a.mv_cat=" . $menu_cat;
} else {
    $condition .= " a.mv_cat > 1";
}

if (!empty($search_name)) {
    $condition .= " AND b.mb_name like " . "'%$search_name%'";
}

if (!empty($search_gen)) {
    $condition .= " AND a.mv_gen='$search_gen' ";
}
if (!empty($search_age)) {
    $condition .= " AND a.mv_age='$search_age' ";
}
if (!empty($search_style)) {
    $condition .= " AND a.mv_sty='$search_style' ";
}
if (!empty($search_ton)) {
    $condition .= " AND a.mv_ton='$search_ton' ";
}
if (!empty($search_lan)) {
    $condition .= " AND a.mv_lan='$search_lan' ";
}

$qry = "SELECT a.*, b.mb_name, b.it_use_avg, c.cnt FROM " . $g5['member_voice'] . " a 
        JOIN " . $g5['member_table'] . " b ON a.mb_id=b.mb_id 
        inner join ( select MAX(mv_no) as max_mv_no FROM g5_member_voice $whereCategory GROUP BY mb_id) as d on a.mv_no = d.max_mv_no
        LEFT JOIN ( SELECT COUNT(*) cnt, mb_id FROM g5_shop_order WHERE od_status IN ('작업진행중','작업완료') GROUP BY mb_id ) c ON a.mb_id=c.mb_id        
        $condition  AND b.mb_gubun = '4' GROUP BY a.mb_id ORDER BY  a.mv_no DESC, a.mb_id ASC, a.mv_no ASC";

$rowVoiceList = sql_query($qry);
?>

<!--
<head>
    <meta charset="utf-8">
    <title>협회성우 리스트</title>
    <meta name="author" content="Your Name">
    <meta name="description" content="Example description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/allvoice.css">
    <link rel="stylesheet" href="css/ttrx_layout_m.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/horizontal.css">
</head>


<head>
    <meta charset="utf-8">
    <title>협회성우 리스트</title>
    <meta name="author" content="Your Name">
    <meta name="description" content="Example description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
-->

<body class="base">
<div class="allWrap">
    <header class="subHd voiceList">
        <div class="listTit">
            <div class="left">
                <a href="/shop/"><img src="../theme/basic/images/logo-2.png" srcset="../theme/basic/images/logo-2.png 1x, ../theme/basic/images/logo-2@2x.png 2x"></a>
            </div>
            <div class="midd">
                <a href="#a" class="topPopShow">일반 성우<img src="../theme/basic/images/chevron-down.svg"></a>
            </div>
            <div class="right schIcon">
                <!--
                <a href="/shop/"><img src="../theme/basic/images/search.svg"></a>
                <a href="/shop/search.php">찾기</a>
                -->
                <a href="/shop/search2.php">샘플검색</a>

            </div>
        </div>
        <div class="frame" id="basic">
            <ul class="clearfix">
                <li value="1"><a href="/shop/voiceList_n.php?cat=1">전체</a></li>
                <li value="10"><a href="/shop/voiceList_n.php?cat=10">광고</a></li>
                <li value="11"><a href="/shop/voiceList_n.php?cat=11">홍보</a></li>
                <li value="12"><a href="/shop/voiceList_n.php?cat=12">방송</a></li>
                <li value="13"><a href="/shop/voiceList_n.php?cat=13">만화</a></li>
                <li value="14"><a href="/shop/voiceList_n.php?cat=14">게임</a></li>
                <li value="15"><a href="/shop/voiceList_n.php?cat=15">영화예고</a></li>
                <li value="16"><a href="/shop/voiceList_n.php?cat=16">이벤트</a></li>
                <li value="17"><a href="/shop/voiceList_n.php?cat=17">오디오북,교재</a></li>
                <li value="18"><a href="/shop/voiceList_n.php?cat=18">기기음성,성대모사</a></li>
                <li value="19"><a href="/shop/voiceList_n.php?cat=19">ARS,안내멘트</a></li>
                <li value="20"><a href="/shop/voiceList_n.php?cat=20">홈쇼핑</a></li>
                <li></li>
                <!--
                <li value="1">전체</li>
                <li value="10">광고</li>
                <li value="11">홍보</li>
                <li value="12">방송</li>
                <li value="13">만화</li>
                <li value="14">게임</li>
                <li value="15">영화예고</li>
                <li value="16">이벤트</li>
                <li value="17">오디오북,교재</li>
                <li value="18">기기음성,성대모사</li>
                <li value="19">ARS,안내멘트</li>
                <li value="20">홈쇼핑</li>
                <li value="21">비상업용</li>
                -->
            </ul>
        </div>
    </header>

    <main class="subWrap topLine">
        <div class="listBox">
            <table>
                <col style="width: 60px">
                <col style="width: auto">
                <col style="width: 45px">
                <col style="width: 45px">
                </colgroup>
                <tbody>
                <?php
                for ($i = 0; $row = sql_fetch_array($rowVoiceList); $i++) {
                    $mb_dir = substr($row['mb_id'], 0, 2);
                    $icon_url = G5_DATA_URL . '/member_image/' . $mb_dir . '/' . $row['mb_id'] . '.gif';
                    $icon_url = is_file(G5_DATA_PATH . '/member_image/' . $mb_dir . '/' . $row['mb_id'] . '.gif') ? $icon_url : "/theme/basic/img/profileSample.jpg";
                    $audio_url = G5_DATA_URL . '/member_voice/' . $mb_dir . '/' . $row['mv_voice'];
                    ?>
                    <tr class="list">
                        <td>
                            <div class="thum">
                                <img src="<?php echo $icon_url; ?>" srcset="<?php echo $icon_url; ?> 1x, <?php echo $icon_url; ?> 2x">
                            </div>
                        </td>
                        <td class="infoTxt">
                            <!--
                            <p><b class="listName"><?php echo $row['mb_name']; ?></b><span>CJE&M</span><span>2003</span></p>
                            -->
                            <p><b class="listName"><?php echo $row['mb_name']; ?></b><span></span><span></span></p>
                            <p class="ellip"><?php echo $row['mv_title']; ?></p>
                        </td>
                        <td class="">
                            <span class="arr1" value="<?php echo $audio_url; ?>">▶
                                <!--
                                <audio src="<?php echo $audio_url; ?>"></audio>
                                -->
                            </span>
                        </td>
                        <td class="svgImg">
                            <span class="contShow" onclick="contShow2('<?php echo $icon_url; ?>', '<?php echo $row['mb_id']; ?>', '<?php echo $row['mb_name']; ?>');">
                                <img src="../theme/basic/images/ellipsis-h.svg">
                            </span>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="btnWrap">
            <button class="moreBtn mb_100"> 더보기</button>
        </div>
    </main>

    <div class="quicMenu">

        <ul>
            <li>
                <a href="<?php echo G5_SHOP_URL; ?>/voiceProject.php">
                    <p><img src="../theme/basic/images/briefcase.svg" class="imgSvg"></p>
                    <p>오디션</p>
                </a>
            </li>
            <li>
                <a href="#" onclick="tempMessage();">
                    <p><img src="../theme/basic/images/heart.svg" class="imgSvg"></p>
                    <p>관심리스트</p>
                </a>
            </li>
            <li>
                <a href="../inbox/inbox_room_list.php">
                    <p><img src="../theme/basic/images/chatbubble.svg" class="imgSvg"></p>
                    <p>채팅</p>
                </a>
            </li>
            <li>
                <a href="<?php echo G5_SHOP_URL; ?>/voiceMypage.php">
                    <p><img src="../theme/basic/images/person.svg" class="imgSvg"></p>
                    <p>마이페이지</p>
                </a>
            </li>
        </ul>


        <button class="top" onClick="scrollToTop()">
            <img src="../theme/basic/images/button_a.png" srcset="../theme/basic/images/button_a.png 1x, ../theme/basic/images/button_a@2x.png 2x">
        </button>

        <!--
        <button class="back">
            <img src="../theme/basic/images/button_arrow_back.png" srcset="../theme/basic/images/button_arrow_back.png 1x, ../theme/basic/images/button_arrow_back@2x.png 2x">
        </button>
        -->

        <button class="gokakao" onClick="location.href='https://pf.kakao.com/_JxiIxgj/chat'">
            <img src="../theme/basic/images/button_kakao_1.png" srcset="../theme/basic/images/button_kakao_1.png 1x, ../theme/basic/images/button_kakao_1@2x.png 2x">
        </button>
    </div>

    <!--성우를 찾고 있나요 팝업-->
    <div class="topPop">
        <div class="topPopBox">
            <button class="closeBtn"><img src="../theme/basic/images/close.svg"></button>
            <span class="popTit">성우를 찾고 있나요?</span>
            <div class="voiceItem">
                <ul>
                    <li>
                        <a href="./voiceList.php">
                            <p><img src="../theme/basic/images/icon_pro_gray.png" srcset="../theme/basic/images/icon_pro_gray.png 1x, ../theme/basic/images/icon_pro_gray@2x.png 2x"></p>
                            <small>협회성우</small>
                        </a>
                    </li>
                    <li>
                        <a href="./voiceList_n.php">
                            <p><img src="../theme/basic/images/icon_semipro_gray.png" srcset="../theme/basic/images/icon_semipro_gray.png 1x, ../theme/basic/images/icon_semipro_gray@2x.png 2x"></p>
                            <small>비협회성우</small>
                        </a>
                    </li>
                    <li>
                        <a href="./voiceList_f.php">
                            <p><img src="../theme/basic/images/icon_foreigner_gray.png" srcset="../theme/basic/images/icon_foreigner_gray.png 1x, ../theme/basic/images/icon_foreigner_gray@2x.png 2x"></p>
                            <small>외국어 성우</small>
                        </a>
                    </li>
                    <!--
                    <li>
                        <a href="./voiceList.php">
                            <p><img src="../theme/basic/images/icon_audio_gray.png" srcset="../theme/basic/images/icon_audio_gray.png 1x, ../theme/basic/images/icon_audio_gray@2x.png 2x"></p>
                            <small>엔지니어</small>
                        </a>
                    </li>
                    -->
                </ul>
            </div>
        </div>
        <div class="topPopBg"></div>
    </div>

    <!--성우정보 팝업-->
    <div class="bottomPop">
        <div class="btmPopBox">
            <div class="listBox detail">
                <table>
                    <caption class="blind">성우 리스트</caption>
                    <colgroup>
                        <col style="width: 60px">
                        <col style="width: auto">
                        <col style="width: 45px">
                    </colgroup>
                    <tbody>
                    <tr class="listDetail">
                        <td>
                            <div class="thum">
                                <!--
                                <img id="voiceImgUrl" src="../theme/basic/images/photo/_114.png" srcset="../theme/basic/images/photo/_114.png 1x, ../theme/basic/images/photo/_114@2x.png 2x">
                                -->
                                <img id="voiceImgUrl" src="" srcset="">
                            </div>
                        </td>
                        <td class="infoTxt">
                            <!--
                            <p><b class="listName" id="voiceNick">이용신</b><span>CJE&M</span><span>2003</span></p>
                            -->
                            <p><b class="listName" id="voiceNick"></b><span></span><span></span></p>
                            <!--
                            <p class="ellip">검색된 샘플 오디오 설명 노출 검색된 샘플 오디오 설명 노출</p>
                            -->
                        </td>
                        <!--
                        <td class="svgImg">
                            <span><img src="../theme/basic/images/heart_off.svg" class="likeOn"></span>
                        </td>
                        -->
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="link">
                <a id="voiceActorInfo" href="#a">성우정보</a>
                <a id="inboxInquiry" href="#a">1:1 채팅 문의</a>
                <!--
                <a id="recordingInquiry" href="#a">의뢰하기</a>
                -->
                <a id="moreSample" href="#a">샘플더듣기</a>
            </div>

            <div class="btnWrap topLine">
                <button class="mb_100 grayTxt closeTxt"> 닫기</button>
            </div>
        </div>
        <div class="btmPopBg"></div>
    </div>

</div>

<script type="text/javascript" src="<?php echo G5_JS_URL; ?>/jquery-3.4.1.js"></script>
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script src="<?php echo G5_JS_URL; ?>/slick.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo G5_JS_URL; ?>/allvoice.js" type="text/javascript" charset="utf-8"></script>
<!-- Scripts -->
<script src="<?php echo G5_JS_URL; ?>/vendor/plugins.js"></script>
<script src="<?php echo G5_JS_URL; ?>/sly.min.js"></script>
<script src="<?php echo G5_JS_URL; ?>/horizontal.js"></script>

<!-- Google Analytics -->
<script>
    var _gaq = [['_setAccount', 'UA-838758-7'], ['_trackPageview']];

    (function (d, t) {
        var g = d.createElement(t), s = d.getElementsByTagName(t)[0];
        g.src = ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js';
        s.parentNode.insertBefore(g, s)
    }(document, 'script'));
</script>

<script type="text/javascript">

    $(document).ready(function () {
        console.log("ready!");

        const audio = new Audio();

        /*
        maudio({
            obj:'audio',
            fastStep:10
        });
         */

        let categoryIndex = 0;
        if (<?php echo isset($_REQUEST['cat']) ? $_REQUEST['cat'] : "0" ?>) {
            categoryIndex = <?php echo isset($_REQUEST['cat']) ? $_REQUEST['cat'] : "0" ?>;
        }

        $("ul.tabs li:first a").removeClass("active").show();
        //$("ul.tabs li a").removeClass("active");
        $('.clearfix > li').eq(0).removeClass("active");

        switch (categoryIndex) {
            case 1:
                $('.clearfix > li').eq(0).attr("class", "active");
                break;
            case 10:
                $('.clearfix > li').eq(1).attr("class", "active");
                break;
            case 11:
                $('.clearfix > li').eq(2).attr("class", "active");
                break;
            case 12:
                $('.clearfix > li').eq(3).attr("class", "active");
                break;
            case 13:
                $('.clearfix > li').eq(4).attr("class", "active");
                break;
            case 14:
                $('.clearfix > li').eq(5).attr("class", "active");
                break;
            case 15:
                $('.clearfix > li').eq(6).attr("class", "active");
                break;
            case 16:
                $('.clearfix > li').eq(7).attr("class", "active");
                break;
            case 17:
                $('.clearfix > li').eq(8).attr("class", "active");
                break;
            case 18:
                $('.clearfix > li').eq(9).attr("class", "active");
                break;
            case 19:
                $('.clearfix > li').eq(10).attr("class", "active");
                break;
            case 20:
                $('.clearfix > li').eq(11).attr("class", "active");
                break;
            case 21:
                $('.clearfix > li').eq(12).attr("class", "active");
                break;
            default:
                $('.clearfix > li').eq(0).attr("class", "active");
                break;
        }


        $(".arr1").click(function () {
            console.log("click");

            console.log(this.text);
            let audioSrc = $(this).attr("value");
            console.log(audioSrc);
            // console.log(this.val());

            // ▶

            //$(this).val("| |");
            //$(this).text("| |");

            let palyStatus = $(this).text();

            console.log(palyStatus)

            if ("▶" === $.trim(palyStatus)) {
                $(this).text("| |");
                audio.src = audioSrc;
                audio.pause();
                audio.play();
            } else {
                $(this).text("▶");
                audio.pause();
            }


            // audio["walk"].src = audioSrc;
            //audio["walk"].addEventListener('load', function () {
            //   audio["walk"].play();
            //});
        });
    });

    $('.clearfix > li').click(function () {
        // console.log("clearfix");
        // console.log($(this).val());
    });

    $('.contShow').click(function () {
        $('.bottomPop').slideToggle();
        $('.bottomPop').find('.btmPopBox').slideToggle()
        console.log("contShow");
    });

    function contShow2(url, mb_id, data) {
        console.log(url);
        console.log(mb_id);
        console.log(data);

        $("#voiceImgUrl").attr("src", url)
        $("#voiceImgUrl").attr("srcset", url + " 1x, " + url + " 2x");
        $("#voiceNick").text(data);
        $("#voiceActorInfo").attr("href", "./voiceDetail.php?mb_id=" + mb_id);
        $("#inboxInquiry").attr("href", "../inbox/inboxChatBox.php?me_recv_mb_id=" + mb_id);
        // $("#recordingInquiry").attr("href", "./voiceDetail.php?mb_id=" + mb_id);
        $("#moreSample").attr("href", "./voiceDetail.php?mb_id=" + mb_id);
    }

    function tempMessage() {
        alert("준비중 입니다.");
    }
</script>

</body>