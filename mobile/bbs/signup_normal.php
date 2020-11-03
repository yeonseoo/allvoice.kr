<?php
include_once('/_common.php');

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


$token = md5(uniqid(rand(), true));
set_session("ss_token", $token);
set_session("ss_cert_no", "");
set_session("ss_cert_hash", "");
set_session("ss_cert_type", "");

set_session("ss_reg_mb_name", $member['mb_name']);
set_session("ss_reg_mb_hp", $member['mb_hp']);

?>
<script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>
<?php if ($config['cf_cert_use'] && ($config['cf_cert_ipin'] || $config['cf_cert_hp'])) { ?>
    <script src="<?php echo G5_JS_URL ?>/certify.js?v=<?php echo G5_JS_VER; ?>"></script>
<?php } ?>


<div class="allWrap">
    <header class="subHd">
        <div class="left">
            <h2>회원가입</h2>
        </div>
        <div class="right">
            <!--
            <img src="../theme/basic/images/close.png">
            -->
            <a href="<?php echo G5_SHOP_URL;?>" id="backto">닫기</a>
        </div>
    </header>

    <main class="subWrap">
        <div class="joinStep">
            <p class="blueTxt">
                <small>상세정보 입력</small>
                <small><span>3</span>/<span>3</span></small>
            </p>
            <div class="stepBar">
                <span class="on3"></span>
            </div>

        </div>

        <div class="step3">
            <div class="tabwrap">
                <h4>회원구분선택</h4>
                <ul class="tabs">
                    <li>
                        <a class="active" href="#tab1"><span class="chkBoxImg"></span>일반</a>
                        <div id="tab1" class="tabconts">
                            <div class="tabbox">
                                <form id="form_signup_noraml" method="post" action="./signup_normal_update.php">
                                    <input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
                                    <input type="hidden" name="cert_no" value="">
                                    <div class="inputTxt mt_50 mb_40">
                                        <p class="itemTxt">이름 </p>
                                        <input type="text" id="mb_name" name="mb_name" placeholder="성함을 입력해주세요">
                                        <label for="mb_name"></label>
                                    </div>

                                    <div class="inputType1">
                                        <p class="itemTxt">닉네임</p>
                                        <div class="">
                                            <input type="text" id="nick" name="nick" placeholder="닉네임을 입력해주세요">
                                            <label for="nick"></label>
                                            <button class="btnType1" id="chk_nickname" type="button">중복확인</button>
                                        </div>
                                    </div>

                                    <div class="inputType1">
                                        <p class="itemTxt">휴대폰번호</p>
                                        <div class="">
                                            <input type="text" id="mb_hp" name="mb_hp" placeholder="휴대폰번호를 입력해주세요">
                                            <label for="mb_hp"></label>
                                            <button class="btnType1" id="chk_hp_cert">본인인증</button>
                                        </div>
                                        <small class="grayTxt txt_l">휴대폰 본인인증을 하시면 카카오 알림톡으로 결제 정보, 알림 정보를 수신할 수 있습니다.</small>
                                    </div>

                                    <!--
                                    <button class="bigBtn mt_20 mb_100" onClick="location.href='join4.html'">회원가입하기</button>
                                    -->
                                    <button class="bigBtn mt_20 mb_100" id="signup">회원 정보 변경</button>
                                </form>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="./signup_company.php"><span class=""></span>법인</a>
                    </li>
                    <li>
                        <a href="./signup_voice.php"><span class=""></span>성우</a>
                    </li>
                    <li id="not_open">
                        <a href="#tab4"><span class=""></span>엔지니어</a>
                    </li>
                </ul>
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

<script type="text/javascript" src="<?php echo G5_JS_URL; ?>/jquery-3.4.1.js"></script>
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script src="<?php echo G5_JS_URL; ?>/slick.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo G5_JS_URL; ?>/allvoice.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">

    $(document).ready(function () {
        console.log("ready!");
        $('body').css('padding-top', '0px');

        let checkNickname = false;

        //>> (Start)닉네임 중복확인
        $("#chk_nickname").click(function () {
            console.log("중복확인");
            let nickname = $("#nick").val().trim();

            console.log(nickname);

            // 유효성 체크
            if (nickname === "") {
                alert("닉네임을 입력해 주세요.");
                return false;
            }

            $.ajax({
                type: "POST",
                url: "./checkNickname.php",
                cache: false,
                data: {nickname: nickname},
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    if (data.error) {
                        alert(data.error);
                        checkNickname = false
                        return false;
                    } else {
                        alert(data.result);
                        checkNickname = true;
                    }
                }
            });
        });
        //>> (End)닉네임 중복확인


        $("#tabs li").click(function (index) {
            // $("li:eq(1)").attr("data-val", "hello");
            // let index = $("li").index(this);
            console.log("2" + index);
        });

        // chk_hp_cert"
        //>> (Start) 휴대폰 본인인증
        $("#chk_hp_cert").click(function () {
            console.log("중복확인");
            // if (!cert_confirm())
            //    return false;
            <?php
            switch ($config['cf_cert_hp']) {
                case 'kcb':
                    $cert_url = G5_OKNAME_URL . '/hpcert1.php';
                    $cert_type = 'kcb-hp';
                    break;
                case 'kcp':
                    $cert_url = G5_KCPCERT_URL . '/kcpcert_form.php';
                    $cert_type = 'kcp-hp';
                    break;
                case 'lg':
                    $cert_url = G5_LGXPAY_URL . '/AuthOnlyReq.php';
                    $cert_type = 'lg-hp';
                    break;
                default:
                    echo 'alert("기본환경설정에서 휴대폰 본인확인 설정을 해주십시오");';
                    echo 'return false;';
                    break;
            }
            ?>

            certify_win_open("<?php echo $cert_type; ?>", "<?php echo $cert_url; ?>");
            console.log("end");
            return false;

        });
        //<< (End) 휴대폰 본인인증

        //>> (Start)회원가입
        $("#signup").click(function () {
            console.log("signup");

            if (false === checkNickname) {
                alert("닉네임 중복체크를 해주세요.");
                return false;
            }

            $("#form_signup_normal").submit();
        });
        //>> (End)회원가입

        $("#not_open").click(function () {
            alert("준비중입니다.");
        });
    }); // end of document ready

    $("li").click(function () {
        // $("li:eq(1)").attr("data-val", "hello");
        let index = $("li").index(this);
        console.log("5" + index);
    });

    $("#tabs").on("click", "li", function () {
        // $("li:eq(1)").attr("data-val", "hello");
        let index = $("li").index(this);
        console.log("1" + index);
    });

    // 닉네임/확동명 중복확인
    $(".btnType1").click(function () {
        console.log("btnType1");
        //return false;
        // Check nickname.
        let nickname = "몽키";

        // Send email for certification.
        $.ajax({
            type: "POST",
            url: "./checkNickname.php",
            cache: false,
            data: {nickname: nickname},
            dataType: "json",
            success: function (data) {
                console.log(data);
                if (data.error) {
                    alert(data.error);
                    return false;
                }
            }
        });
    });

    // 회원가입하기
    $(".bigBtn").click(function () {
        console.log("bigBtn");
    });

    // 인증체크
    function cert_confirm() {
        //var val = document.fregisterform.cert_type.value;
        let val = "hp";
        let type;

        switch (val) {
            case "ipin":
                type = "아이핀";
                break;
            case "hp":
                type = "휴대폰";
                break;
            default:
                return true;
        }

        if (confirm("이미 " + type + "으로 본인확인을 완료하셨습니다.\n\n이전 인증을 취소하고 다시 인증하시겠습니까?"))
            return true;
        else
            return false;
    }

</script>