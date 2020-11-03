<?php
include_once('./_common.php');

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH . '/bbs/signup_email.php');
    return;
}

$g5['title'] = '로그인2';
include_once('./_head.sub.php');

?>
    <div id="contentsWrapEx">
        <!-- 회원가입 이메일-->
        <div id="join_wrap">
            <div class="graph_box">
                <p class="text_box">
                    <span class="text">기본정보 입력</span>
                    <span class="num">2 / 3</span>
                </p>
                <div class="graph">
                    <span style="width:66.66%;"></span>
                </div>
            </div>
            <form id="form_signup_email" method="post" action="./signup_email_update.php">
                <div class="user_box wide">
                    <div class="inp_box add_btn">
                        <label for="id" class="label_st1">이메일</label>
                        <input type="text" id="mb_id" name="mb_id" placeholder="이메일을 입력해주세요" class="inp_st1"/>
                        <a href="javascript:" class="inp_btn" id="email_certification">인증하기</a>
                    </div>

                    <div class="inp_box">
                        <label for="pw" class="label_st1">비밀번호</label>
                        <input type="password" id="pw" name="pw" placeholder="영문 · 숫자 · 특수문자 포함, 6자 이상" class="inp_st1"/>
                    </div>

                    <div class="inp_box">
                        <label for="pw2" class="label_st1">비밀번호 확인</label>
                        <input type="password" id="pw2" name="pw2" placeholder="비밀번호를 한번 더 입력해주세요" class="inp_st1"/>
                    </div>

                    <div class="agree_box">
                        <p class="agree_title">약관동의</p>
                        <div class="all">
                            <div class="btn_check2">
                                <input type="checkbox" id="agree_all" name="agree_all">
                                <i></i>
                                <label for="agree_all">모든 약관에 동의 합니다.</label>
                            </div>
                        </div>
                        <ul>
                            <li>
                                <div class="btn_check3">
                                    <input type="checkbox" id="agree1" name="agree1" value="Y">
                                    <i></i>
                                    <label for="agree1">서비스 이용약관에 동의 합니다. (필수)</label>
                                </div>
                                <a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=provision" target="_blank"><img src="../theme/basic/img/user/btn_agree.png" alt=""></a>
                            </li>
                            <li>
                                <div class="btn_check3">
                                    <input type="checkbox" id="agree2" name="agree2" value="Y">
                                    <i></i>
                                    <label for="agree2">개인정보 수집,이용에 동의합니다. (필수)</label>
                                </div>
                                <a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=privacy" target="_blank"><img src="../theme/basic/img/user/btn_agree.png" alt=""></a>
                            </li>
                            <li>
                                <div class="btn_check3">
                                    <input type="checkbox" id="agree3" name="agree3" value="Y">
                                    <i></i>
                                    <label for="agree3">이벤트 등 알림 수신에 동의합니다. (선택)</label>
                                </div>
                                <!--
                                <a href="#none"><img src="../theme/basic/img/user/btn_agree.png" alt=""></a>
                                -->
                            </li>
                        </ul>
                    </div>

                    <div class="btn_box">
                        <!--
                        <a href="./signup_normal.php" class="btn_st1 short">다음 단계로</a>
                        -->
                        <!--
                        <a href="javascript:" class="btn_st1 short">다음 단계로</a>
                        -->
                        <a href="javascript:" class="btn_st1 short">회원 가입</a>
                    </div>
                </div>
            </form>
        </div>
        <!-- 회원가입 이메일-->

    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            console.log("ready");

            // 이메일 인증하기
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

            // 약관 동의
            $("#agree_all").click(function () {
                let check = $(this).is(":checked");

                if (true === check) {
                    // 전체 선택
                    $("#agree1").prop("checked", true);
                    $("#agree2").prop("checked", true);
                    $("#agree3").prop("checked", true);
                } else {
                    // 전체 해제
                    $("#agree1").prop("checked", false);
                    $("#agree2").prop("checked", false);
                    $("#agree3").prop("checked", false);
                }
            });

            // 회원 가입
            $(".btn_st1").click(function () {
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

                /*
                $.ajax({
                    type: "POST",
                    url: "./signup_email_update.php",
                    data: {
                        mb_id: "",
                        mb_password: "world",
                    },
                    cache: false,
                    async: false,
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        location.href = "./signup_normal.php";
                    }
                });
                 */
            });
        }); // end of $(document).ready

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

            if(password.length < 6 || password.length > 20){
                alert("6자리 ~ 20자리 이내로 입력해주세요.");
                return false;
            }else if(password.search(/\s/) != -1){
                alert("비밀번호는 공백 없이 입력해주세요.");
                return false;
            }else if(num < 0 || eng < 0 || spe < 0 ){
                alert("영문, 숫자, 특수문자를 혼합하여 입력해주세요.");
                return false;
            }else {
                return true;
            }
        }

    </script>

<?php
include_once('./_tail.sub.php');
?>