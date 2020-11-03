<?php
include_once('/_common.php');
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
?>

<body class="base">
<div class="allWrap">
    <header class="subHd">
        <div class="left">
            <h2>회원가입</h2>
        </div>
        <div class="right">
            <a href="#" id="backto" onclick="history.back(); return false;">닫기</a>
            <!--
            <img src="images/close.png">
            -->
        </div>
    </header>

    <main class="subWrap">
        <div class="joinStep">
            <p class="blueTxt">
                <small>가입유형 선택</small>
                <small><span>1</span>/<span>3</span></small>
            </p>
            <div class="stepBar">
                <span class="on1"></span>
            </div>

        </div>
        <div class="step1">
            <div class="gojoin mt_100 mb_50">
                <h3>이메일로 회원가입</h3>
                <p><small class="grayTxt">이메일을 이용하여 회원가입을 진행합니다.</small></p>
                <button class="bigBtn mt_20" onClick="location.href='./signup_email.php'">이메일 가입하기</button>
            </div>
            <div class="easyjoin">
                <!--
                <h3>간편 회원가입</h3>
                <p><small class="grayTxt">자주 사용하는 SNS 아이디로 간편하게 가입합니다.</small></p>
                <div class="social">
                    <div class="socialBox">
                        <button class="circle">
                            <img src="../theme/basic/images/button_naver.png" srcset="../theme/basic/images/button_naver.png 1x, ../theme/basic/images/button_naver@2x.png 2x">
                        </button>
                        <p><small class="grayTxt miniTxt">네이버로 가입</small></p>
                    </div>
                    <div class="socialBox">
                        <button class="circle">
                            <span><img src="../theme/basic/images/button_kakao_login.png" srcset="../theme/basic/images/button_kakao_login.png 1x, ../theme/basic/images/button_kakao_login@2x.png 2x"></span>
                        </button>
                        <p><small class="grayTxt miniTxt">카카오로 가입</small></p>
                    </div>
                    <div class="socialBox">
                        <button class="circle">
                            <span><img src="../theme/basic/images/button_facebook.png" srcset="../theme/basic/images/button_facebook.png 1x, ../theme/basic/images/button_facebook@2x.png 2x"></span>
                        </button>
                        <p><small class="grayTxt miniTxt">페이스북으로 가입</small></p>
                    </div>
                    <div class="socialBox">
                        <button class="circle">
                            <span><img src="../theme/basic/images/button_google.png" srcset="../theme/basic/images/button_google.png 1x, ../theme/basic/images/button_google@2x.png 2x"></span>
                        </button>
                        <p><small class="grayTxt miniTxt">구글로 가입</small></p>
                    </div>
                </div>
                -->
            </div>
        </div>

    </main>

    <!--
    <div class="quicMenu">
        <ul>
            <li>
                <a href="#a">
                    <p><img src="../theme/basic/images/briefcase.svg" class="imgSvg"></p>
                    <p>오디션</p>
                </a>
            </li>
            <li>
                <a href="#a">
                    <p><img src="../theme/basic/images/heart.svg" class="imgSvg"></p>
                    <p>관심리스트</p>
                </a>
            </li>
            <li>
                <a href="#a">
                    <p><img src="../theme/basic/images/chatbubble.svg" class="imgSvg"></p>
                    <p>채팅</p>
                </a>
            </li>
            <li>
                <a href="#a">
                    <p><img src="../theme/basic/images/person.svg" class="imgSvg"></p>
                    <p>마이페이지</p>
                </a>
            </li>
        </ul>
        <button class="top" onClick="scrollToTop()">
            <img src="../theme/basic/images/button_a.png" srcset="../theme/basic/images/button_a.png 1x, ../theme/basic/images/button_a@2x.png 2x">
        </button>

        <button class="back">
            <img src="../theme/basic/images/button_arrow_back.png" srcset="../theme/basic/images/button_arrow_back.png 1x, ../theme/basic/images/button_arrow_back@2x.png 2x">
        </button>

        <button class="gokakao">
            <img src="../theme/basic/images/button_kakao_1.png" srcset="../theme/basic/images/button_kakao_1.png 1x, ../theme/basic/images/button_kakao_1@2x.png 2x">
        </button>
    </div>
    -->
</div>
</body>

<script type="text/javascript" src="<?php echo G5_JS_URL; ?>/jquery-3.4.1.js"></script>
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script src="<?php echo G5_JS_URL; ?>/slick.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo G5_JS_URL; ?>/allvoice.js" type="text/javascript" charset="utf-8"></script>