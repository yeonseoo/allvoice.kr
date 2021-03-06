<?php
$mb_dir = substr($member['mb_id'], 0, 2);
$icon_url = G5_DATA_URL . '/member_image/' . $mb_dir . '/' . $member['mb_id'] . '.gif';
$icon_url = is_file(G5_DATA_PATH . '/member_image/' . $mb_dir . '/' . $member['mb_id'] . '.gif') ? $icon_url : "../theme/basic/img/profileSample.jpg";

$reg_url = ($member['mb_gubun'] == "3" || $member['mb_gubun'] == "4") ? "register_form2.php" : "register_form.php";
?>
<div class="voiceProfile">
    <div>
        <img src="<?php echo $icon_url ?>"/>
        <strong><a href="/shop/voiceDetail.php?cat=&mb_id=<?php echo $member['mb_id'] ?>"><?php echo $member['mb_name'] ?>(<?php echo $member['mb_id'] ?>)</a></strong>
        <ul>
            <li>연락처</li>
            <li><?php echo $member['mb_hp'] ?></li>
            <li>이메일</li>
            <li><?php echo $member['mb_email'] ?></li>
            <li>최종 접속 일시</li>
            <li><?php echo $member['mb_today_login'] ?></li>
        </ul>
        <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/<?php echo $reg_url; ?>">내 정보 수정</a>
    </div>
    <section>
        <ul>
            <?php
            if ($member['mb_gubun'] == "3" || $member['mb_gubun'] == "4") {
                ?>
                <li><a href="/shop/voiceProfile.php">프로필관리</a></li>
                <li><a href="/shop/voiceSample.php">샘플 음성 관리</a></li>
                <?php
            }
            ?>
            <li><a href="/shop/voiceMypageOrder.php?it_gubun=">거래 내역 관리</a></li>
            <li><a href="/shop/voiceMypageOrder.php?it_gubun=3">문의 주문 관리</a></li>
            <?php if ($member['mb_gubun'] == "3" || $member['mb_gubun'] == "4") { ?>
                <li><a href="/shop/voiceMypageOrder.php?it_gubun=1">작업 의뢰 프로젝트 지원 내역</a></li>
            <?php } else { ?>
                <li><a href="/shop/voiceMypageOrder.php?it_gubun=1">작업 의뢰 프로젝트 등록 내역</a></li>
            <?php } ?>
            <li><a href="/bbs/memo.php" class="memoPop">쪽지함</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=member_leave.php">회원탈퇴</a></li>
        </ul>
    </section>
</div>