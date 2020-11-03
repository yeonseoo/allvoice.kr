<?php
include_once('./_common.php');

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH . '/bbs/cert_email.php');
    return;
}

include_once('./_head.sub.php');

$cert_key = $_GET['cert_key'];

$sql = "select count(*) as cnt from allv_member_email_cert where cert_key = '$cert_key'";
$result = sql_fetch($sql);

$message = "이메일이 인증이 완료되었습니다.";

if (1 > $result['cnt']) {
    $message = "이메일 인증을 실패하였습니다!!!";
} else {
    $sql = "UPDATE allv_member_email_cert SET cert_yn = 'Y' where cert_key = '$cert_key'";
    $result = sql_query($sql);

    if (false == $result) {
        $message = "이메일 인증을 실패하였습니다!!!";
    }
}
?>

<div id="contentsWrapEx">
    <!-- 회원가입 -->
    <div id="join_wrap">
        <div class="join_finish">
            <p class="text1"><?php echo $message; ?></p>
            <p class="text2"></p>
            <div class="btn_box">
                <!--
                    <a href="<?php echo G5_SHOP_URL ?>" class="btn_st1">홈으로 이동하기</a>
                 -->
            </div>
        </div>
    </div>
    <!-- //회원가입 -->
</div>

<?php
include_once('./_tail.sub.php');
?>

