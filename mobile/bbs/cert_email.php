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

<div class="allWrap">
    <header class="subHd">
        <div class="left">
            <h2>회원가입</h2>
        </div>
        <div class="right">
            <img src="../theme/basic/images/close.png">
        </div>
    </header>

    <main class="subWrap">
        <div class="gojoin mt_100">
            <h2><?php echo $message; ?></h2>
            <!--
            <p><small class="grayTxt">사이트이용을 위해 로그인해주세요</small></p>
            -->
            <button class="bigBtn mt_20" onClick="location.href='<?php echo G5_SHOP_URL; ?>'">홈으로 이동하기</button>
        </div>
    </main>
</div>


<script type="text/javascript" src="<?php echo G5_JS_URL; ?>/jquery-3.4.1.js"></script>
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script src="<?php echo G5_JS_URL; ?>/slick.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo G5_JS_URL; ?>/allvoice.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">
    $(document).ready(function () {
        console.log("ready!");
        $('body').css('padding-top', '0px');
    });
</script>