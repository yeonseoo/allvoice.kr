<?php
include_once('./_common.php');


include_once(G5_MSHOP_PATH.'/_head.php');


?>

<!-- 회원가입 { -->

<div class="voiceSignup">
	<strong>올보이스 회원가입</strong>
	<hr />
	<p>프로성우와 클라이언트를 연결하는 No.1 목소리 직거래 플랫폼, 올보이스<br />회원 가입 후 올보이스의 서비스를 경험해보세요!</p>
	<ul>
		<li>
			<strong>일반회원</strong>
			<span>목소리를 찾고계신가요?</span>
			<a href="<?php echo G5_BBS_URL ?>/register.php">회원가입(일반)</a>
		</li>
		<li>
			<strong>프로성우</strong>
			<span>여러분의 목소리를 들려주세요.</span>
			<a href="<?php echo G5_BBS_URL ?>/register2.php">회원가입(성우)</a>
		</li>
	</ul>
</div>

<!-- } 회원가입 -->

<?php
include_once(G5_MSHOP_PATH."/_tail.php");
?>