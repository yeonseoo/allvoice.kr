<?php
include_once('./_common.php');

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH . '/bbs/signup.php');
    return;
}

$g5['title'] = '로그인2';
include_once('./_head.sub.php');


?>
    <div id="contentsWrap">

        <!-- 회원가입 -->
        <div id="join_wrap">
            <div class="graph_box">
                <p class="text_box">
                    <span class="text">가입유형 선택</span>
                    <span class="num">1 / 3</span>
                </p>
                <div class="graph">
                    <span style="width:33.33%;"></span>
                </div>
            </div>
            <div class="user_box">
                <p class="user_title">이메일로 회원가입</p>
                <p class="user_text1">이메일을 이용하여 회원가입을 진행합니다.</p>
                <div class="btn_box">
                    <a href="./signup_email.php" class="btn_st1">이메일 가입하기</a>
                </div>

                <!--
                <p class="user_title">간편 회원가입</p>
                <p class="user_text1">자주 사용하는 SNS 아이디로 간편하게 가입합니다.</p>
                <ul class="user_sns">
                    <li><a href="#none"><img src="../theme/basic/img/user/img_sns1.png" alt="">네이버로 가입</a></li>
                    <li><a href="#none"><img src="../theme/basic/img/user/img_sns2.png" alt="">카카오로 가입</a></li>
                    <li><a href="#none"><img src="../theme/basic/img/user/img_sns3.png" alt="">페이스북으로 가입</a></li>
                    <li><a href="#none"><img src="../theme/basic/img/user/img_sns4.png" alt="">구글로 가입</a></li>
                </ul>
                -->
            </div>
        </div>
        <!-- //회원가입 -->
    </div>

<?php
include_once('./_tail.sub.php');
?>