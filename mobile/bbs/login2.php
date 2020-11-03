<?php
include_once('/_common.php');
//include_once(G5_MSHOP_PATH . '/_head.php');
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
            <h2>로그인</h2>
        </div>
        <div class="right">
            <!--
            <img src="images/close.png">
            -->
            <a href="#" id="backto" onclick="history.back(); return false;">닫기</a>
        </div>
    </header>

    <main class="subWrap">

        <div class="loginIdPw">
            <form method="post" action="login_check.php" autocomplete="off">
                <div class="inputTxt">
                    <p class="itemTxt">이메일/아이디</p>
                    <input type="text" id="mb_id" name="mb_id" placeholder="이메일 또는 아이디를 입력해주세요">
                    <label for="txt01"></label>
                </div>

                <div class="inputPw">
                    <p class="itemTxt">비밀번호</p>
                    <input type="password" id="mb_password" name="mb_password" placeholder="비밀번호를 입력해주세요">
                    <label for="pw01"></label>
                </div>
                <div class="txt_c mt_20">
                    <button type="submit" class="loginBtn">로그인</button>
                </div>

                <div class="findkeep">
                    <div>
                        <a href="<?php echo G5_BBS_URL ?>/password_lost.php" target="_blank">아이디/비밀번호 찾기</a>
                    </div>
                    <div>
                        <input type="checkbox" id="agree1" name="agree1" value="Y">
                        <label for="agree1">로그인 유지</label>

                    </div>
                </div>
            </form>
        </div>

        <!--
        <div class="easylogin">

            <h3>간편 로그인</h3>

            <div class="social">
                <div class="socialBox">
                    <button class="circle">
                        <img src="../theme/basic/images/button_naver.png" srcset="../theme/basic/images/button_naver.png 1x, ../theme/basic/images/button_naver@2x.png 2x">
                    </button>
                    <p><small class="grayTxt miniTxt">네이버 로그인</small></p>
                </div>
                <div class="socialBox">
                    <button class="circle">
                        <span><img src="../theme/basic/images/button_kakao_login.png" srcset="../theme/basic/images/button_kakao_login.png 1x, ../theme/basic/images/button_kakao_login@2x.png 2x"></span>
                    </button>
                    <p><small class="grayTxt miniTxt">카카오 로그인</small></p>
                </div>
                <div class="socialBox">
                    <button class="circle">
                        <span><img src="../theme/basic/images/button_facebook.png" srcset="../theme/basic/images/button_facebook.png 1x, ../theme/basic/images/button_facebook@2x.png 2x"></span>
                    </button>
                    <p><small class="grayTxt miniTxt">페이스북 로그인</small></p>
                </div>
                <div class="socialBox">
                    <button class="circle">
                        <span><img src="../theme/basic/images/button_google.png" srcset="../theme/basic/images/button_google.png 1x, ../theme/basic/images/button_google@2x.png 2x"></span>
                    </button>
                    <p><small class="grayTxt miniTxt">구글 로그인</small></p>
                </div>
            </div>

        </div>
        -->

        <div class="gojoin mb_50">
            <h4>올보이스 회원가입하기</h4>
            <!--
            <button class="bigBtn mt_10" onClick="location.href='./signup.php'">회원 가입</button>
            -->
            <button class="bigBtn mt_10" onClick="location.href='<?php echo G5_BBS_URL; ?>/signup.php'">회원 가입</button>
        </div>
    </main>

    <div class="quicMenu">
        <!--
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
        -->

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
</div>
</body>


<script type="text/javascript" src="<?php echo G5_JS_URL; ?>/jquery-3.4.1.js"></script>
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script src="<?php echo G5_JS_URL; ?>/slick.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo G5_JS_URL; ?>/allvoice.js" type="text/javascript" charset="utf-8"></script>
