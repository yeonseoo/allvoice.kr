<?php
include_once('./_common.php');


if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH . '/bbs/signup_normal.php');
    return;
}

include_once('./_head.php');
$g5['title'] = '로그인2';
include_once('./_head.sub.php');


// 불법접근을 막도록 토큰생성
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

<div id="contentsWrapEx">

    <!-- 회원가입 3단계 일반-->
    <div id="join_wrap">
        <div class="graph_box">
            <p class="text_box">
                <span class="text">상세정보 입력</span>
                <span class="num">3 / 3</span>
            </p>
            <div class="graph">
                <span style="width:100%;"></span>
            </div>
        </div>
        <div class="user_tab">
            <p>회원 구분 선택</p>
            <ul>
                <li class="on"><a href="#none"><span>일반</span></a></li>
                <li><a href="./signup_company.php"><span>법인</span></a></li>
                <li><a href="./signup_voice.php"><span>성우</span></a></li>
                <li id="not_open"><a href="javascript:"><span>엔지니어</span></a></li>
                <!--
                <li><a href="signup_engineer.php"><span>엔지니어</span></a></li>
                -->
            </ul>
        </div>
        <div class="user_box wide">
            <form id="form_signup_normal" name="form_signup_normal" action="./signup_normal_update.php" method="post" enctype="MULTIPART/FORM-DATA" autocomplete="off">
                <input type="hidden" name="url" value="<?php echo $urlencode ?>">
                <input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
                <input type="hidden" name="cert_no" value="">
                <div class="inp_box">
                    <label for="mb_name" class="label_st1">이름</label>
                    <input type="text" id="mb_name" name="mb_name" placeholder="성함을 입력해주세요" class="inp_st1"/>
                </div>

                <div class="inp_box add_btn">
                    <label for="nick" class="label_st1">닉네임</label>
                    <input type="text" id="nick" name="nick" placeholder="닉네임을 입력해주세요" class="inp_st1"/>
                    <a href="#none" class="inp_btn" id="chk_nickname">중복확인</a>
                </div>

                <div class="inp_box add_btn">
                    <label for="mb_hp" class="label_st1">휴대폰 번호</label>
                    <input type="text" id="mb_hp" name="mb_hp" placeholder="휴대폰 번호를 입력해주세요" class="inp_st1"/>
                    <a href="javascript:" class="inp_btn" id="chk_hp_cert">본인인증</a>
                    <p class="small_text">휴대폰 본인인증을 하시면 카카오 알림톡으로 결제 정보, 알림 정보를 수신할 수 `있습니다.</p>
                </div>

                <div class="btn_box mt">
                    <a href="javascript:" class="btn_st1">회원 정보 변경</a>
                </div>
            </form>
        </div>
    </div>
    <!-- 회원가입 3단계 일반-->

    <script type="text/javascript">
        //$(document).ready(function () {
        $(function () {
            console.log("ready!");

            let checkNickname = false;

            // 닉네임 중복확인
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

            // 휴대폰 본인인증
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

            // 회원 정보 변경
            $(".btn_st1").click(function () {
                console.log("회원가입하기");

                if (false === checkNickname) {
                    alert("닉네임 중복체크를 해주세요.");
                    return false;
                }

                $("#form_signup_normal").submit();
            });

            $("#not_open").click(function() {
                alert("준비중");
            });
        }); // end of $(document).ready(function ()

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

</div>

<?php
include_once('./_tail.sub.php');
?>
