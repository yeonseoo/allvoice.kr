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

<body>
<div class="allWrap">
    <header class="subHd">
        <div class="left">
            <h2>회원가입</h2>
        </div>
        <div class="right">
            <!--
            <img src="../theme/basic/images/close.png">
            <a href="#" id="backto" onclick="history.back(); return false;">닫기</a>
            -->

            <a href="<?php echo G5_SHOP_URL;?>" id="backto">닫기</a>

        </div>
    </header>

    <main class="subWrap">
        <div class="joinStep">
            <p class="blueTxt">
                <small>기본정보 입력</small>
                <small><span>2</span>/<span>3</span></small>
            </p>
            <div class="stepBar">
                <span class="on2"></span>
            </div>

        </div>

        <div class="step2">
            <form id="form_signup_email" method="post" action="./signup_email_update.php">
                <div class="inputType1">
                    <p class="itemTxt">이메일</p>
                    <div class="">
                        <input type="text" id="mb_id" name="mb_id" placeholder="이메일을 입력해주세요">
                        <label for="pw01"></label>
                        <button type="button" class="btnType1" id="email_certification">인증하기</button>
                    </div>

                </div>
                <div class="inputPw">
                    <p class="itemTxt">비밀번호</p>
                    <input type="password" id="pw" name="pw" placeholder="영문 · 숫자 · 특수문자 포함, 6자 이상">
                    <label for="pw"></label>
                    <p class="itemTxt">비밀번호 확인</p>
                    <input type="password" id="pw2" name="pw2" placeholder="비밀번호를 한번 더 입력해주세요">
                    <label for="pw2"></label>
                </div>

                <div class="agree">
                    <p class="itemTxt">약관동의</p>
                    <div class="chkType1">
                        <input type="checkbox" id="allCheck">
                        <label for="allCheck">모든 약관에 동의 합니다.</label>
                    </div>
                    <div class="chkType2">
                        <p>
                            <input type="checkbox" id="agree1" name="agree1" value="Y">
                            <label for="agree1">서비스 이용약관에 동의 합니다. (필수)</label>
                            <a href="./content.php?co_id=provision" target="_blank"><small>〉</small></a>
                        </p>
                        <p>
                            <input type="checkbox" id="agree2" name="agree2" value="Y">
                            <label for="agree2">개인정보 수집,이용에 동의합니다. (필수)</label>
                            <a href="./content.php?co_id=privacy" target="_blank"><small>〉</small></a>
                        </p>
                        <p>
                            <input type="checkbox" id="agree3" name="agree3" value="Y">
                            <label for="agree3">이벤트 등 알림 수신에 동의합니다. (선택)</label>
                            <!--
                            <a href="#a"><small>〉</small></a>
                            -->
                        </p>
                    </div>
                </div>

                <!--
                <button type="submit" class="bigBtn mt_20" onclick="location='./signup_normal.php'">다음단계로</button>
                -->
                <button type="button" class="bigBtn mt_20" id="signup">회원가입</button>
            </form>

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

<script type="text/javascript">

    $(document).ready(function () {
        console.log("ready!");
        $('body').css('padding-top', '0px');

        //>> (Start)이메일 인증
        $("#email_certification").click(function () {
            console.log("인증");

            let userEmail = $("#mb_id").val();
            console.log(userEmail);

            // 유효성 검사
            if ($("#mb_id").val().trim() === "") {
                alert("이메일을 입력해주세요");
                $("#mb_id").focus();
                return false;
            }

            // 이메일 형식 확인
            if (false === validateEmail(userEmail)) {
                alert("이메일 형식을 확인해 주세요.");
                $("#mb_id").focus();
                return false;
            }

            // 인증 이메일 전송
            // Send email for certification.
            $.ajax({
                type: "POST",
                url: "./requestEmailCert.php",
                cache: false,
                data: {email: userEmail},
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    if (data.error) {
                        alert(data.error);
                        return false;
                    } else {
                        alert(data.result);
                    }
                }
            });
        });
        //<< (End)이메일 인증

        //>> (Start)회원가입 버튼 클릭
        $("#signup").click(function () {
            console.log("회원 가입");

            // 유효성 검사
            if ($("#mb_id").val().trim() === "") {
                alert("이메일을 입력해 주세요");
                $("#mb_id").focus();
                return false;
            }

            if ($("#pw").val().trim() === "") {
                alert("비밀번호를 입력해 주세요.");
                $("#pw").focus();
                return false;
            }

            let password = $("#pw").val();
            if (false === validatePassword(password)) {
                $("#pw").focus();
                return false;
            }

            if ($("#pw2").val().trim() === "") {
                alert("비밀번호 확인을 입력해 주세요.");
                $("#pw2").focus();
                return false;
            }

            if ($("#pw").val() !== $("#pw2").val()) {
                alert("비밀번호가 일치하지 않습니다.");
                return false;
            }

            // 약관 확인 (필수 약관 - 서비스 이용약과, 개인정보 수집 이용)
            if (false === $("#agree1").is(":checked")) {
                alert("서비스 이용약관에 동의해 주세요.");
                return false;
            }

            if (false === $("#agree2").is(":checked")) {
                alert("개인정보 수집, 이용에 동의해 주세요.");
                return false;
            }


            // 인증메일 확인 여부 체크
            let userEmail = $("#mb_id").val();
            console.log(userEmail);
            $.ajax({
                type: "POST",
                url: "./checkEmailCert.php",
                cache: false,
                data: {email: userEmail},
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    if (data.error) {
                        alert(data.error);
                        return false;
                    }
                    else {
                        // alert(data.result);
                        $("#form_signup_email").submit();
                    }
                }
            });
        });

        //>> (End)회원가입 버튼 클릭

        /*
        $("#tabs li").click(function(index){
            // $("li:eq(1)").attr("data-val", "hello");
            // let index = $("li").index(this);
            console.log("2"+index);
        });
         */

        //
        //
        //
        // email_cert
        $("#email_cert").click(function () {
            console.log("email_cert");

            let email = "lwj1212g@naver.com";

            // Send email for certification.
            $.ajax({
                type: "POST",
                url: "./requestEmailCert.php",
                cache: false,
                data: {email: email},
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    if (data.error) {
                        alert(data.error);
                        return false;
                    }
                }
            });
        }); // end of email_cert

    }); // end of document ready

    function validateEmail(sEmail) {
        let filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (filter.test(sEmail)) {
            return true;
        } else {
            return false;
        }
    }

    function validatePassword(password) {

        let num = password.search(/[0-9]/g);
        let eng = password.search(/[a-z]/ig);
        let spe = password.search(/[`~!@@#$%^&*|₩₩₩'₩";:₩/?]/gi);

        if (password.length < 6 || password.length > 20) {
            alert("6자리 ~ 20자리 이내로 입력해주세요.");
            return false;
        } else if (password.search(/\s/) != -1) {
            alert("비밀번호는 공백 없이 입력해주세요.");
            return false;
        } else if (num < 0 || eng < 0 || spe < 0) {
            alert("영문, 숫자, 특수문자를 혼합하여 입력해주세요.");
            return false;
        } else {
            return true;
        }
    }
</script>