<?php
include_once('./_common.php');

if (G5_IS_MOBILE) {
    //include_once(G5_BBS_PATH.'/login.php');
    //include_once(G5_MSHOP_PATH)
    include_once(G5_MOBILE_PATH . '/bbs/login2.php');
    return;
}

$g5['title'] = '로그인2';
include_once('./_head.sub.php');

?>
<!--로그인 -->
<div id="contentsWrapEx">
    <div id="login_wrap">
        <div class="user_box">
            <form id="form_login" method="post" action="login_check.php" autocomplete="off">
                <p class="user_title"> 올보이스 로그인 </p>
                <div class="inp_box">
                    <label for="mb_id" class="label_st1"> 이메일 / 아이디</label>
                    <input type="text" id="mb_id" name="mb_id" placeholder="이메일 또는 아이디를 입력해주세요" class="inp_st1"/>
                </div>
                <div class="inp_box">
                    <label for="mb_password" class="label_st1"> 비밀번호</label>
                    <input type="password" id="mb_password" name="mb_password" placeholder="비밀번호를 입력해주세요" class="inp_st1"/>
                </div>
                <div class="btn_box">
                    <a href="#none" class="btn_st1" id="login"> 로그인</a>
                </div>

                <div class="find_box">
                    <p class="btn">
                        <a href="<?php echo G5_BBS_URL ?>/password_lost.php" target="_blank"> 아이디 / 비밀번호 찾기 </a>
                    </p>
                    <div class="btn_check">
                        <input type="checkbox" id="agree1" name="agree1" value="Y">
                        <i></i>
                        <label for="agree1"> 로그인 유지 </label>
                    </div>
                </div>
            </form>

            <!--
            <p class="user_title"> 간편로그인</p>
            <ul class="user_sns">
                <li><a href="#none"><img src="../theme/basic/img/user/img_sns1.png" alt=""> 네이버 로그인 </a></li>
                <li><a href="#none"><img src="../theme/basic/img/user/img_sns2.png" alt=""> 카카오 로그인 </a></li>
                <li><a href="#none"><img src="../theme/basic/img/user/img_sns3.png" alt=""> 페이스북 로그인 </a></li>
                <li><a href="#none"><img src="../theme/basic/img/user/img_sns4.png" alt=""> 구글 로그인 </a></li>
            </ul>
            -->

            <p class="user_title"> 올보이스 회원가입하기 </p>
            <div class="btn_box">
                <a href="<?php echo G5_BBS_URL ?>/signup.php" class="btn_st1"> 회원가입</a>
            </div>
        </div>
    </div>
</div>
<!-- //로그인 -->

<script type="text/javascript">

    $(document).ready(function () {
        console.log("ready!");

        // Check login field and submit.
        $("#login").click(function () {
            console.log("login click");

            // Check id and password
            if ($("#mb_id").val().trim() === "") {
                alert("이메일 또는 아이디를 입력해주세요.");
                $("#mb_id").focus();
                return false;
            }

            if ($("#mb_password").val().trim() === "") {
                alert("비밀번호를 입력해주세요.");
                $("#mb_password").focus();
                return false;
            }

            // Submit
            $("#form_login").submit();
        });
    }); // end of $(document).ready
</script>

<?php
include_once('./_tail.sub.php');
?>


