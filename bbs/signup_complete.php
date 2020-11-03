<?php
include_once('./_common.php');

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH . '/bbs/signup_complete.php');
    return;
}

include_once('./_head.sub.php');

?>
    <div id="contentsWrap">
        <!-- 회원가입 -->
        <div id="join_wrap">
            <div class="join_finish">
                <p class="text1">회원가입이 완료되었습니다</p>
                <p class="text2"></p>
                <div class="btn_box">
                    <a href="<?php echo G5_SHOP_URL ?>" class="btn_st1">홈으로 이동하기</a>
                </div>
            </div>
        </div>
        <!-- //회원가입 -->
    </div>

<?php
include_once('./_tail.sub.php');
?>