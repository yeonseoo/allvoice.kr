<?php
include_once('./_common.php');

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH . '/voiceList.php');
    return;
}

// include_once('./_head.php');

include_once(G5_THEME_PATH . '/head.sub.php');
include_once(G5_LIB_PATH . '/outlogin.lib.php');
include_once(G5_LIB_PATH . '/poll.lib.php');
include_once(G5_LIB_PATH . '/visit.lib.php');
include_once(G5_LIB_PATH . '/connect.lib.php');
include_once(G5_LIB_PATH . '/popular.lib.php');
include_once(G5_LIB_PATH . '/latest.lib.php');

// 오디션 목록 가져오기.
$qry = "SELECT a.*, IFNULL(d.cnt,0) cnt, b.ca_name 
        FROM " . $g5['g5_shop_item_table'] . " AS a 
        JOIN " . $g5['g5_shop_category_table'] . " AS b ON a.ca_id=b.ca_id 
        JOIN " . $g5['member_table'] . " AS c ON a.it_maker=c.mb_id 
        LEFT JOIN (
        SELECT it_id, COUNT(*) AS cnt FROM " . $g5['g5_shop_cart_table'] . " WHERE ct_select='1' AND ct_status<>'취소' GROUP BY it_id) d 
        ON a.it_id=d.it_id WHERE a.it_use='1' AND a.it_gubun IN ('1','2') AND a.it_type1='1' ORDER BY it_id DESC LIMIT 0, 8 ";
$res = sql_query($qry);


?>

<!--
<head>
    <meta charset="utf-8">
    <title>Main_3_logout</title>
    <meta name="author" content="Your Name">
    <meta name="description" content="Example description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/allvoice_pc.css">
    <link rel="stylesheet" href="css/ttrx_layout.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/slick-theme.css">
    <link rel="icon" type="image/x-icon" href=""/>
</head>
-->

<!--
<body class="allWrapPc">
-->
<body class="allWrapPc">
<header class="top_nav">

    <div class="top" name="top">
        <div class="logo"><a href="<?php echo G5_SHOP_URL ?>"><img src="../theme/basic/imgpc/logo.png"></a></div>

        <div class="topSch">
            <label for="sch01"></label>
            <input type="text01" id="sch01" placeholder="이름검색">
        </div>
        <!--
        <div class="topLink">
            <a href="#"><span>보이스 매칭</span></a>
            <a href="#"><span>이용방법</span></a>
        </div>
        <div class="topLink">
            <a href="#"><span>성우 녹음 의뢰</span></a>
            <a href="#"><span>엔지니어</span></a>
            <a href="#"><span>성우 오디션</span></a>
        </div>
        -->

        <div class="topLink">
            <a href="<?php echo G5_SHOP_URL ?>/how.php"><span>이용방법&nbsp&nbsp</span></a>
            <a href="<?php echo G5_SHOP_URL ?>/after.php"><span>보이스매칭&nbsp&nbsp</span></a>
        </div>
        <div class="topLink">
            <a href="<?php echo G5_SHOP_URL ?>/inboxMessage.php"><span>1:1 채팅&nbsp&nbsp</span></a>
            <a href="<?php echo G5_SHOP_URL ?>/voiceProject.php"><span>오디션&nbsp&nbsp</span></a>
        </div>

        <div class="topLink">
            <?php if ($is_member) { ?>
                <a href="<?php echo G5_SHOP_URL ?>/voiceMypage.php"><span>마이페이지&nbsp&nbsp</span></a>
                <a href="<?php echo G5_BBS_URL ?>/logout.php"><span>로그아웃&nbsp&nbsp</span></a>

                <?php if ($is_admin) { ?>
                    <a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/">관리자</a>
                <?php } ?>

            <?php } else { ?>
                <a href="<?php echo G5_BBS_URL ?>/login2.php"><span>로그인&nbsp&nbsp</span></a>
                <a href="<?php echo G5_BBS_URL ?>/signup.php"><span>회원가입</span></a>
            <?php } ?>
        </div>

    </div>

</header>
<main class="main">
    <div class="mainBox">
        <div class="photo">
            <img src="../theme/basic/imgpc/ID1_1.png">
        </div>
        <!--보이스를 찾으시나요?-->
        <div class="findVoice">
            <h4><p>보이스를 찾으시나요?</p>
                <span>고객과 성우를 직접 연결하여 온라인 작업이 가능합니다.<br>
                        녹음실 방문이 필요 없어 비용과 시간이 획기적으로 절감됩니다</span>
            </h4>

            <a href="<?php echo G5_SHOP_URL ?>/voiceList.php" class="fvBox">
                <div class="left"><img src="../theme/basic/imgpc/icon_pro.png"></div>
                <div class="right">
                    <p class="tit">성우협회 목소리 찾기</p>
                    <p class="txt">방송국 공채 출신으로 성우협회 소속성우</p>
                </div>
            </a>
            <a href="<?php echo G5_SHOP_URL ?>/voiceList_n.php" class="fvBox">
                <div class="left"><img src="../theme/basic/imgpc/icon_semipro.png"></div>
                <div class="right">
                    <p class="tit">일반성우 목소리 찾기</p>
                    <p class="txt">프리랜서로 활동중인 성우</p>
                </div>
            </a>
            <a href="<?php echo G5_SHOP_URL ?>/voiceList_f.php" class="fvBox">
                <div class="left"><img src="../theme/basic/imgpc/icon_foreigner.png"></div>
                <div class="right">
                    <p class="tit">외국어 목소리 찾기</p>
                    <p class="txt">외국어를 사용할 수 있는 성우</p>
                </div>
            </a>
        </div>

        <!--오늘 올라온 오디션-->
        <div class="todayOdi">
            <div class="odiTit">
                <h4>오디션
                    <a href="<?php echo G5_SHOP_URL ?>/voiceProjectApply.php" class="goOdi">오디션 등록하기 〉</a>
                </h4>
                <p class="txt">최근 올라온 오디션을 한번에 확인</p>
            </div>
            <section class="variable slider">
                <?php
                $qry = "SELECT a.*, IFNULL(d.cnt,0) cnt, b.ca_name FROM " . $g5['g5_shop_item_table'] . " AS a JOIN " . $g5['g5_shop_category_table'] . " AS b ON a.ca_id=b.ca_id JOIN " . $g5['member_table'] . " AS c ON a.it_maker=c.mb_id LEFT JOIN (SELECT it_id, COUNT(*) AS cnt FROM " . $g5['g5_shop_cart_table'] . " WHERE ct_select='1' AND ct_status<>'취소' GROUP BY it_id) d ON a.it_id=d.it_id WHERE a.it_use='1' AND a.it_gubun IN ('1','2') AND a.it_type1='1' ORDER BY it_id DESC LIMIT 0, 8 ";
                //echo $qry;
                $res = sql_query($qry);
                $row_cnt = sql_num_rows($res);

                for ($i = 0;
                     $row = sql_fetch_array($res);
                     $i++) {
                    $icon_url = G5_DATA_URL . '/item/' . $row['it_id'] . '/' . $row['it_img1'];
                    $icon_url = is_file(G5_DATA_PATH . '/item/' . $row['it_id'] . '/' . $row['it_img1']) ? $icon_url : "/theme/basic/img/profileSample.jpg";

                    $link_url = ($row['it_maker'] != $member['mb_id'] && ($row['it_gubun'] != 1 || $row['it_view_time'] < date("Y-m-d H:i:s"))) ? "javascript:alert('마감된 프로젝트입니다.');" : "/shop/voiceProjectDetail.php?it_id=" . $row['it_id'] . "&ca_id=" . $_REQUEST['ca_id'];

                    $mod = $i % 2;

                    $link_url = (
                        $row['it_maker'] != $member['mb_id'] &&
                        ($row['it_gubun'] != 1 || $row['it_view_time'] < date("Y-m-d H:i:s"))) ? "javascript:alert('마감된 프로젝트입니다.');" : "/shop/voiceProjectDetail.php?it_id=" . $row['it_id'] . "&ca_id=" . $_REQUEST['ca_id'] . "&orderby=" . $_REQUEST['orderby'] . "&page=" . $page . "";

                    ?>
                    <div>
                        <div class="todayBox <?php if ($mod == 0) echo 'blue';
                        else echo 'orenge'; ?>">
                            <a href="<?php echo $link_url; ?>">
                                <small><?php echo $row['ca_name']; ?></small>
                                <p class="txt2"><?php echo $row['it_name']; ?>
                                </p>
                                <p class="mt_20">
                                    <!--
                                    <span class="keyword">여성</span>
                                    <span class="keyword">젋은성인</span>
                                    <span class="keyword">밝은</span>
                                    -->
                                    <?php
                                    $showCount = 0;
                                    if (isset($gender_arr[$row['it_1']])) {
                                        echo '<span class="keyword">' . $gender_arr[$row['it_1']] . '</span>';
                                        $showCount++;
                                    }
                                    if (isset($age_arr[$row['it_2']])) {
                                        echo '<span class="keyword">' . $age_arr[$row['it_2']] . '</span>';
                                        $showCount++;
                                    }
                                    if (isset($style_arr[$row['it_3']])) {
                                        echo '<span class="keyword">' . $style_arr[$row['it_3']] . '</span>';
                                        $showCount++;
                                    }
                                    if (isset($tone_arr[$row['it_4']]) && $showCount < 3) {
                                        echo '<span class="keyword">' . $tone_arr[$row['it_4']] . '</span>';
                                        $showCount++;
                                    }
                                    if (isset($language_arr[$row['it_5']]) && $showCount < 3) {
                                        echo '<span class="keyword">' . $language_arr[$row['it_5']] . '</span>';
                                    }

                                    ?>
                                    <!--
                                <span class="keyword"><?php echo $gender_arr[$row['it_1']]; ?></span>
                                <span class="keyword"><?php echo $age_arr[$row['it_2']]; ?></span>
                                <span class="keyword"><?php echo $style_arr[$row['it_3']]; ?></span>
                                <span class="keyword"><?php echo $tone_arr[$view_dt['it_4']]; ?></span>
                                <span class="keyword"><?php echo $language_arr[$view_dt['it_5']]; ?></span>
                                -->
                                </p>
                                <div class="priceBar">
                                    <small class="dateymd"><?php echo $row['it_view_time']; ?></small>
                                    <b class="price"><span><?php echo number_format($row['it_price']); ?></span> 원</b>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <!--
                <div>
                    <div class="todayBox blue">
                        <small>광고1</small>
                        <p class="txt1">레트로 느낌의 선크림 광고 영상 더빙 & 나래이션 (일정 촉박한 오디션)
                        </p>
                        <p class="mt_20">
                            <span class="keyword">여성</span>
                            <span class="keyword">젋은성인</span>
                            <span class="keyword">밝은</span>
                        </p>
                        <div class="priceBar">
                            <small class="dateymd">20년 7월 30일 마감</small>
                            <b class="price"><span>500,000</span> 원</b>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="todayBox orenge">
                        <small>광고2</small>
                        <p class="txt1">레트로 느낌의 선크림 광고 영상 더빙 & 나래이션 (일정 촉박한 오디션)
                        </p>
                        <p class="mt_20">
                            <span class="keyword">여성</span>
                            <span class="keyword">젋은성인</span>
                            <span class="keyword">밝은</span>
                        </p>
                        <div class="priceBar">
                            <small class="dateymd">20년 7월 30일 마감</small>
                            <b class="price"><span>500,000</span> 원</b>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="todayBox blue">
                        <small>광고3</small>
                        <p class="txt1">레트로 느낌의 선크림 광고 영상 더빙 & 나래이션 (일정 촉박한 오디션)
                        </p>
                        <p class="mt_20">
                            <span class="keyword">여성</span>
                            <span class="keyword">젋은성인</span>
                            <span class="keyword">밝은</span>
                        </p>
                        <div class="priceBar">
                            <small class="dateymd">20년 7월 30일 마감</small>
                            <b class="price"><span>500,000</span> 원</b>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="todayBox orenge">
                        <small>광고4</small>
                        <p class="txt1">레트로 느낌의 선크림 광고 영상 더빙 & 나래이션 (일정 촉박한 오디션)
                        </p>
                        <p class="mt_20">
                            <span class="keyword">여성</span>
                            <span class="keyword">젋은성인</span>
                            <span class="keyword">밝은</span>
                        </p>
                        <div class="priceBar">
                            <small class="dateymd">20년 7월 30일 마감</small>
                            <b class="price"><span>500,000</span> 원</b>
                        </div>
                    </div>
                </div>
                -->

            </section>

        </div>

        <!--오디오엔지니어찾기 회원가입하기-->
        <div class="mainLink">
            <div class="linkBox">
                <a href="#" class="fvBox" onclick="">
                    <div class="right">
                        <p class="txt">더욱 완벽한 결과물을 위한 </p>
                        <p class="tit">오디오 엔지니어 찾기</p>

                    </div>
                </a>
            </div>
            <div class="linkBox">
                <a href="<?php echo G5_BBS_URL ?>/signup.php" class="fvBox">
                    <div class="right">
                        <p class="txt">아직 올보이스 회원이 아니신가요</p>
                        <p class="tit">회원가입하기</p>

                    </div>
                </a>
            </div>
        </div>
    </div>
</main>
<footer class="foot">
    <div class="footLink">
        <ul style=" ">
            <!--
            <li><a href="#a">이용방법</a></li>
            <li><a href="#a">가격정책</a></li>
            https://allvoice.kr/bbs/content.php?co_id=provision
            -->
            <li><a href="<?php echo G5_SHOP_URL ?>/how.php">이용방법</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/content.php?co_id=provision">이용약관</a></li>
            <li><a href="#a">개인정보처리방침</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/faq.php">고객센터</a></li>
            <!--
            <li><a href="#a">서비스 이용동의</a></li>
            <li><a href="#a"><img src="../theme/basic/imgpc/icon_language.png">한국어</a></li>
            -->
        </ul>
    </div>

    <div class="info">
        <div class="footLogo"><img src="../theme/basic/imgpc/logo-1_g.png"></div>
        <div class="infoBox">
            <p class="comName"> 올보이스(주) 사업자정보 </p>
            <p>
                <span>대표이사: 오신성 / 주소 : 서울특별시 마포구 성암로330 DMC첨단산업센터 316-2호</span>
                <span>사업자등록번호 : 845-86-011-81 / 통신판매업 신고 : 제 2018-서울성동-162 <button class="infoshow">사업자정보확인하기</button></span>
                <span>개인정보보호책임자 : 오신성</span>
                <em class="infoBlind">
                    <span>사업자등록 : 845-86-011-81</span>
                    <span>통신판매신고 : 제 2018-서울성동-162</span>
                </em>
            </p>
            <p class="copy mt_20">
                <!--
                <span>호스팅 서비스 : 호스팅 업체 명</span>
                -->
                <span>copyrightⓒ Allvoice co. Ltd. All right reserved</span>
            </p>
        </div>
        <div class="footCs">
            <p><em>고객센터</em><b>1544-2055</b></p>
            <p>평일 10:00~17:00 / 점심시간 12:40~14:00</p>
            <p class="social mt_20">
                <button class="circle">
                    <img src="../theme/basic/imgpc/button_logo-twitter.png" srcset="../theme/basic/imgpc/button_logo-twitter.png 1x, ../theme/basic/imgpc/button_logo-twitter@2x.png 2x">
                </button>
                <button class="circle">
                    <span><img src="../theme/basic/imgpc/button_logo-youtube.png" srcset="../theme/basic/imgpc/button_logo-youtube.png 1x, ../theme/basic/imgpc/button_logo-youtube@2x.png 2x"></span>
                </button>
                <button class="circle">
                    <span><img src="../theme/basic/imgpc/button_logo_instagram.png" srcset="../theme/basic/imgpc/button_logo_instagram.png 1x, ../theme/basic/imgpc/button_logo_instagram@2x.png 2x"></span>
                </button>
            </p>
        </div>
    </div>
</footer>


<div id="right_button">
    <a href="#a"><img id="right_button_1" src="../theme/basic/imgpc/right_button_1.png"></a>
    <!--
    <a href="#a"><img id="right_button_2" src="../theme/basic/imgpc/right_button_2.png"></a>
    <a href="#top"><img id="right_button_3" src="../theme/basic/imgpc/right_button_3.png"></a>
    -->
</div>

<script type="text/javascript" src="<?php echo G5_JS_URL; ?>/jquery-3.4.1.js"></script>
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script src="<?php echo G5_JS_URL; ?>/slick.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo G5_JS_URL; ?>/allvoicePc.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">
    $(document).ready(function () {
        console.log("ready!");
    });

</script>

</body>

