<?php

/********************
    상수 선언
********************/

define('G5_VERSION', '그누보드5');
define('G5_GNUBOARD_VER', '5.3.2.6');
define('G5_YOUNGCART_VER', '5.3.2.6');

// 이 상수가 정의되지 않으면 각각의 개별 페이지는 별도로 실행될 수 없음
define('_GNUBOARD_', true);

if (PHP_VERSION >= '5.1.0') {
    //if (function_exists("date_default_timezone_set")) date_default_timezone_set("Asia/Seoul");
    date_default_timezone_set("Asia/Seoul");
}

/********************
    경로 상수
********************/

/*
보안서버 도메인
회원가입, 글쓰기에 사용되는 https 로 시작되는 주소를 말합니다.
포트가 있다면 도메인 뒤에 :443 과 같이 입력하세요.
보안서버주소가 없다면 공란으로 두시면 되며 보안서버주소 뒤에 / 는 붙이지 않습니다.
입력예) https://www.domain.com:443/gnuboard5
*/
define('G5_DOMAIN', 'https://allvoice.kr');
define('G5_HTTPS_DOMAIN', 'https://allvoice.kr');

/*
www.sir.kr 과 sir.kr 도메인은 서로 다른 도메인으로 인식합니다. 쿠키를 공유하려면 .sir.kr 과 같이 입력하세요.
이곳에 입력이 없다면 www 붙은 도메인과 그렇지 않은 도메인은 쿠키를 공유하지 않으므로 로그인이 풀릴 수 있습니다.
*/
define('G5_COOKIE_DOMAIN',  '');

define('G5_DBCONFIG_FILE',  'dbconfig.php');

define('G5_ADMIN_DIR',      'adm');
define('G5_BBS_DIR',        'bbs');
define('G5_CSS_DIR',        'css');
define('G5_DATA_DIR',       'data');
define('G5_EXTEND_DIR',     'extend');
define('G5_IMG_DIR',        'img');
define('G5_JS_DIR',         'js');
define('G5_LIB_DIR',        'lib');
define('G5_PLUGIN_DIR',     'plugin');
define('G5_SKIN_DIR',       'skin');
define('G5_EDITOR_DIR',     'editor');
define('G5_MOBILE_DIR',     'mobile');
define('G5_OKNAME_DIR',     'okname');
define('G5_UTIL_DIR',  		'util');

define('G5_KCPCERT_DIR',    'kcpcert');
define('G5_LGXPAY_DIR',     'lgxpay');

define('G5_SNS_DIR',        'sns');
define('G5_SYNDI_DIR',      'syndi');
define('G5_PHPMAILER_DIR',  'PHPMailer');
define('G5_SESSION_DIR',    'session');
define('G5_THEME_DIR',      'theme');

// URL 은 브라우저상에서의 경로 (도메인으로 부터의)
if (G5_DOMAIN) {
    define('G5_URL', G5_DOMAIN);
} else {
    if (isset($g5_path['url']))
        define('G5_URL', $g5_path['url']);
    else
        define('G5_URL', '');
}

if (isset($g5_path['path'])) {
    define('G5_PATH', $g5_path['path']);
} else {
    define('G5_PATH', '');
}

define('G5_ADMIN_URL',      G5_URL.'/'.G5_ADMIN_DIR);
define('G5_BBS_URL',        G5_URL.'/'.G5_BBS_DIR);
define('G5_CSS_URL',        G5_URL.'/'.G5_CSS_DIR);
define('G5_DATA_URL',       G5_URL.'/'.G5_DATA_DIR);
define('G5_IMG_URL',        G5_URL.'/'.G5_IMG_DIR);
define('G5_JS_URL',         G5_URL.'/'.G5_JS_DIR);
define('G5_SKIN_URL',       G5_URL.'/'.G5_SKIN_DIR);
define('G5_PLUGIN_URL',     G5_URL.'/'.G5_PLUGIN_DIR);
define('G5_EDITOR_URL',     G5_PLUGIN_URL.'/'.G5_EDITOR_DIR);
define('G5_OKNAME_URL',     G5_PLUGIN_URL.'/'.G5_OKNAME_DIR);
define('G5_KCPCERT_URL',    G5_PLUGIN_URL.'/'.G5_KCPCERT_DIR);
define('G5_LGXPAY_URL',     G5_PLUGIN_URL.'/'.G5_LGXPAY_DIR);
define('G5_SNS_URL',        G5_PLUGIN_URL.'/'.G5_SNS_DIR);
define('G5_SYNDI_URL',      G5_PLUGIN_URL.'/'.G5_SYNDI_DIR);
define('G5_MOBILE_URL',     G5_URL.'/'.G5_MOBILE_DIR);

// PATH 는 서버상에서의 절대경로
define('G5_ADMIN_PATH',     G5_PATH.'/'.G5_ADMIN_DIR);
define('G5_BBS_PATH',       G5_PATH.'/'.G5_BBS_DIR);
define('G5_DATA_PATH',      G5_PATH.'/'.G5_DATA_DIR);
define('G5_EXTEND_PATH',    G5_PATH.'/'.G5_EXTEND_DIR);
define('G5_LIB_PATH',       G5_PATH.'/'.G5_LIB_DIR);
define('G5_PLUGIN_PATH',    G5_PATH.'/'.G5_PLUGIN_DIR);
define('G5_SKIN_PATH',      G5_PATH.'/'.G5_SKIN_DIR);
define('G5_MOBILE_PATH',    G5_PATH.'/'.G5_MOBILE_DIR);
define('G5_SESSION_PATH',   G5_DATA_PATH.'/'.G5_SESSION_DIR);
define('G5_EDITOR_PATH',    G5_PLUGIN_PATH.'/'.G5_EDITOR_DIR);
define('G5_OKNAME_PATH',    G5_PLUGIN_PATH.'/'.G5_OKNAME_DIR);
define('ALLV_UTIL_PATH',	G5_PATH.'/'.G5_UTIL_DIR);

define('G5_KCPCERT_PATH',   G5_PLUGIN_PATH.'/'.G5_KCPCERT_DIR);
define('G5_LGXPAY_PATH',    G5_PLUGIN_PATH.'/'.G5_LGXPAY_DIR);

define('G5_SNS_PATH',       G5_PLUGIN_PATH.'/'.G5_SNS_DIR);
define('G5_SYNDI_PATH',     G5_PLUGIN_PATH.'/'.G5_SYNDI_DIR);
define('G5_PHPMAILER_PATH', G5_PLUGIN_PATH.'/'.G5_PHPMAILER_DIR);
//==============================================================================


//==============================================================================
// 사용기기 설정
// pc 설정 시 모바일 기기에서도 PC화면 보여짐
// mobile 설정 시 PC에서도 모바일화면 보여짐
// both 설정 시 접속 기기에 따른 화면 보여짐
//------------------------------------------------------------------------------
define('G5_SET_DEVICE', 'both');

define('G5_USE_MOBILE', true); // 모바일 홈페이지를 사용하지 않을 경우 false 로 설정
define('G5_USE_CACHE',  true); // 최신글등에 cache 기능 사용 여부


/********************
    시간 상수
********************/
// 서버의 시간과 실제 사용하는 시간이 틀린 경우 수정하세요.
// 하루는 86400 초입니다. 1시간은 3600초
// 6시간이 빠른 경우 time() + (3600 * 6);
// 6시간이 느린 경우 time() - (3600 * 6);
define('G5_SERVER_TIME',    time());
define('G5_TIME_YMDHIS',    date('Y-m-d H:i:s', G5_SERVER_TIME));
define('G5_TIME_YMD',       substr(G5_TIME_YMDHIS, 0, 10));
define('G5_TIME_HIS',       substr(G5_TIME_YMDHIS, 11, 8));

// 입력값 검사 상수 (숫자를 변경하시면 안됩니다.)
define('G5_ALPHAUPPER',      1); // 영대문자
define('G5_ALPHALOWER',      2); // 영소문자
define('G5_ALPHABETIC',      4); // 영대,소문자
define('G5_NUMERIC',         8); // 숫자
define('G5_HANGUL',         16); // 한글
define('G5_SPACE',          32); // 공백
define('G5_SPECIAL',        64); // 특수문자

// 퍼미션
define('G5_DIR_PERMISSION',  0755); // 디렉토리 생성시 퍼미션
define('G5_FILE_PERMISSION', 0644); // 파일 생성시 퍼미션

// 모바일 인지 결정 $_SERVER['HTTP_USER_AGENT']
define('G5_MOBILE_AGENT',   'phone|samsung|lgtel|mobile|[^A]skt|nokia|blackberry|BB10|android|sony');

// SMTP
// lib/mailer.lib.php 에서 사용
define('G5_SMTP',      '127.0.0.1');
define('G5_SMTP_PORT', '25');


/********************
    기타 상수
********************/

// 암호화 함수 지정
// 사이트 운영 중 설정을 변경하면 로그인이 안되는 등의 문제가 발생합니다.
define('G5_STRING_ENCRYPT_FUNCTION', 'sql_password');

// SQL 에러를 표시할 것인지 지정
// 에러를 표시하려면 TRUE 로 변경
define('G5_DISPLAY_SQL_ERROR', FALSE);

// escape string 처리 함수 지정
// addslashes 로 변경 가능
define('G5_ESCAPE_FUNCTION', 'sql_escape_string');

// sql_escape_string 함수에서 사용될 패턴
//define('G5_ESCAPE_PATTERN',  '/(and|or).*(union|select|insert|update|delete|from|where|limit|create|drop).*/i');
//define('G5_ESCAPE_REPLACE',  '');

// 게시판에서 링크의 기본개수를 말합니다.
// 필드를 추가하면 이 숫자를 필드수에 맞게 늘려주십시오.
define('G5_LINK_COUNT', 2);

// 썸네일 jpg Quality 설정
define('G5_THUMB_JPG_QUALITY', 90);

// 썸네일 png Compress 설정
define('G5_THUMB_PNG_COMPRESS', 5);

// 모바일 기기에서 DHTML 에디터 사용여부를 설정합니다.
define('G5_IS_MOBILE_DHTML_USE', false);

// MySQLi 사용여부를 설정합니다.
define('G5_MYSQLI_USE', true);

// Browscap 사용여부를 설정합니다.
define('G5_BROWSCAP_USE', true);

// 접속자 기록 때 Browscap 사용여부를 설정합니다.
define('G5_VISIT_BROWSCAP_USE', false);

// ip 숨김방법 설정
/* 123.456.789.012 ip의 숨김 방법을 변경하는 방법은
\\1 은 123, \\2는 456, \\3은 789, \\4는 012에 각각 대응되므로
표시되는 부분은 \\1 과 같이 사용하시면 되고 숨길 부분은 ♡등의
다른 문자를 적어주시면 됩니다.
*/
define('G5_IP_DISPLAY', '\\1.♡.\\3.\\4');

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') {   //https 통신일때 daum 주소 js
    define('G5_POSTCODE_JS', '<script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>');
} else {  //http 통신일때 daum 주소 js
    define('G5_POSTCODE_JS', '<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>');
}

$voice_file_str = "mp3|wav|ogg|m4a|flac|wmv|wma|aac";


define('SENDER_KEY', '5ed71adc5225bed979e0784e6ed7087b0e415fc1');
$bizp_arr = array(
		"1"=>"bizp_2019082914295322317625520",	// 쪽지가 도착했습니다. => 쪽지가 도착했습니다. -올보이스-
		"2"=>"bizp_2019082914395422317226521",	// 결제완료>To.일반 => 결제가 완료되어, 사이트 내에서 성우의 안심번호를 확인할 수 있습니다. -올보이스-
		"3"=>"bizp_2019082914404422317898522",	// 결제완료>To.성우 => 결제완료, 작업을 진행해주세요. 성우님의 안심번호를 안내하였습니다. -올보이스-
		"4"=>"bizp_2019082914411816788931542",	// 합의주문>견적금액도착>To.일반 => 성우의 견적 금액이 도착 했습니다. 마이페이지에서 확인해주세요. -올보이스-
		"5"=>"bizp_2019082914415822317275523",	// 합의주문>주문발생>To.성우 => 합의주문의뢰가 도착했습니다. -올보이스-
		"6"=>"bizp_2019082914433522317196524",	// 합의주문>작업물도착>To.일반 => 작업물 도착. 마이페이지에서 확인 후 작업완료 인증을 해주세요. -올보이스-
		"7"=>"bizp_2019082914440222317867525",	// 합의주문>작업완료>To.성우 => 고객님이 작업완료를 인증하셨습니다. -올보이스-
		"8"=>"bizp_2019082914463922317016526",	// 작업의뢰>채택시>To.성우 => 지원하신 작업에 채택되셨습니다. 결제가 완료되면 작업을 진행해주세요. -올보이스-
		"9"=>"bizp_2019082914471716788078543",	// 작업의뢰>성우지원시>To.일반 => 고객님이 등록하신 작업에 성우가 지원하였습니다. -올보이스-
		"10"=>"bizp_2019082914475522317334527",	// To.관리자(합의주문등록시) => 새로운 합의주문이 등록되었습니다. -올보이스-
		"11"=>"bizp_2019082914483016788512544",	// To.관리자(작업의뢰등록시) => 새로운 작업이 등록되었습니다. -올보이스-
		"12"=>"bizp_2019082914494022317576528",	// To.관리자(후반작업의뢰등록시) => 후반작업 의뢰가 등록되었습니다. 확인해주세요. -올보이스-
		"13"=>"bizp_2019091010371722317145059", // 의뢰취소>To.성우 => 고객님이 작업 의뢰를 취소하셨습니다. -올보이스-
		"14"=>"bizp_2019091022381916788455088", // 쪽지 수신(2) => 작업에 대한 문의 내용이 도착했습니다. 쪽지함을 확인해주세요. -올보이스-
		"15"=>"bizp_2019091010342116788527056"  // To.관리자(가입신청도착시 알림) => 성우회원 가입 신청이 도착했습니다.
);

$bizp_err_code = array (
	// 공통
	"9903"=>"선불사용자 사용금지 ",
	"9904"=>"Block time (날짜제한) ",
	"9081"=>"선불 사용자 FAX, PHONE 발송 제한 ",
	"9082"=>"발송해제 ",
	"9083"=>"IP 차단 ",
	"9084"=>"DEVICE 발송 제한 ",
	"9085"=>"사용금지 Callback 번호 ",
	"9023"=>"Callback error ",
	"9905"=>"Block time ",
	"9907"=>"지원하지 않는 메시지 타입 ",
	"9010"=>"아이디틀림 ",
	"9011"=>"비밀번호 틀림 ",
	"9012"=>"중복 접속 량 많음 ",
	"9014"=>"알림톡/친구톡 유효하지 않은 발신프로필키 ",
	"9015"=>"알림톡/친구톡 발신프로필키 미 입력 ",
	"9016"=>"알림톡/친구톡 템플릿 미 입력 ",
	"9017"=>"존재하지 않는 첨부파일 ",
	"9018"=>"0 바이트 첨부파일 ",
	"9019"=>"지원하지 않는 첨부파일 ",
	"9020"=>"Wrong Data Format ",
	"9022"=>"Wrong Data Format (ex. cinfo 가 특수 문자 / , 공백 을 포함) ",
	"9023"=>"시간제한 (리포트 수신대기 timeout) ",
	"9024"=>"Wrong Data Format (ex. 메시지 본문 길이) ",
	"9026"=>"블랙리스트에 의한 차단 ",
	"9027"=>"MMS 첨부파일 이미지 사이즈 초과 ",
	"9028"=>"첨부파일 URL 구문 오류 ",
	"9029"=>"JSON String 구문 오류 ",
	"9030"=>"지원하지 않는 첨부파일 데이터 타입 ",
	"9031"=>"첨부파일 테이블과 매칭되는 MSG_KEY 가 없음. ",
	"9080"=>"Deny User Ack ",
	"9214"=>"Wrong Phone Num ",
	"9311"=>"Uploaded File Not Found ",
	"9908"=>"PHONE, FAX 선불사용자 제한기능 ",
	"9090"=>"기타에러 ",
	 
	// 구 분 코 드 설 명 알림톡/친구톡 
	"7000"=>"전달 ",
	"7101"=>"카카오 형식 오류 ",
	"7103"=>"Sender key (발신프로필키) 유효하지 않음 ",
	"7105"=>"Sender key (발신프로필키) 존재하지 않음 ",
	"7106"=>"삭제된 Sender key (발신프로필키) ",
	"7107"=>"차단 상태 Sender key (발신프로필키) ",
	"7108"=>"차단 상태 옐로우 아이디 ",
	"7109"=>"닫힌 상태 옐로우 아이디 ",
	"7110"=>"삭제된 옐로우 아이디 ",
	"7203"=>"친구톡 전송 시 친구대상 아님 ",
	"7204"=>"템플릿 불일치 ",
	"7300"=>"기타에러 ",
	"7305"=>"성공불확실(30 일 이내 수신 가능) ",
	"7306"=>"카카오 시스템 오류 ",
	"7308"=>"전화번호 오류 ",
	"7311"=>"메시지가 존재하지 않음 ",
	"7314"=>"메시지 길이 초과 ",
	"7315"=>"템플릿 없음 ",
	"7318"=>"메시지를 전송할 수 없음 ",
	"7322"=>"메시지 발송 불가 시간 ",
	"7323"=>"메시지 그룹 정보를 찾을 수 없음 ",
	"7324"=>"재전송 메시지 존재하지 않음 ",
	"7421"=>"타임아웃 ",
	 
	// 구 분 코 드 설 명 SMS 
	"4100"=>"전달 ",
	"4400"=>"음영 지역 ",
	"4401"=>"단말기 전원 꺼짐 ",
	"4402"=>"단말기 메시지 저장 초과 ",
	"4403"=>"메시지 삭제 됨 ",
	"4404"=>"가입자 위치 정보 없음 ",
	"4405"=>"단말기 BUSY ",
	"4410"=>"잘못된 번호 ",
	"4420"=>"기타에러 ",
	"4430"=>"스팸 ",
	"4431"=>"발송제한 수신거부(스팸) ",
	"4411"=>"NPDB 에러 ",
	"4412"=>"착신거절 ",
	"4413"=>"SMSC 형식오류 ",
	"4414"=>"비가입자,결번,서비스정지 ",
	"4421"=>"타임아웃 ",
	"4422"=>"단말기일시정지 ",
	"4423"=>"단말기착신거부 ",
	"4424"=>"URL SMS 미지원폰 ",
	"4425"=>"단말기 호 처리 중 ",
	"4426"=>"재시도한도초과 ",
	"4427"=>"기타 단말기 문제 ",
	"4428"=>"시스템에러 ",
	"4432"=>"회신번호 차단(개인) ",
	"4433"=>"회신번호 차단(기업) ",
	"4434"=>"회신번호 사전 등록제에 의한 미등록 차단 ",
	"4435"=>"KISA 신고 스팸 회신번호 차단 ",
	"4436"=>"회신번호 사전 등록제 번호규칙 위반 ",
	 
	// 구 분 코 드 설 명 MMS 
	"6600"=>"전달 ",
	"6601"=>"타임 아웃 ",
	"6602"=>"핸드폰 호 처리 중 ",
	"6603"=>"음영 지역 ",
	"6604"=>"전원이 꺼져 있음 ",
	"6605"=>"메시지 저장개수 초과 ",
	"6606"=>"잘못된 번호 ",
	"6607"=>"서비스 일시 정지 ",
	"6608"=>"기타 단말기 문제 ",
	"6609"=>"착신 거절 ",
	"6610"=>"기타에러 ",
	"6611"=>"통신사의 SMC 형식 오류 ",
	"6612"=>"게이트웨이의 형식 오류 ",
	"6613"=>"서비스 불가 단말기 ",
	"6614"=>"핸드폰 호 불가 상태 ",
	"6615"=>"SMC 운영자에 의해 삭제 ",
	"6616"=>"통신사의 메시지 큐 초과 ",
	"6617"=>"통신사의 스팸 처리 ",
	"6618"=>"공정위의 스팸 처리 ",
	"6619"=>"게이트웨이의 스팸 처리 ",
	"6620"=>"발송 건수 초과 ",
	"6621"=>"메시지의 길이 초과 ",
	"6622"=>"잘못된 번호 형식 ",
	"6623"=>"잘못된 데이터 형식 ",
	"6624"=>"MMS 정보를 찾을 수 없음 ",
	"6625"=>"NPDB 에러 ",
	"6626"=>"080 수신거부(SPAM) ",
	"6627"=>"발송제한 수신거부(SPAM) ",
	"6628"=>"회신번호 차단(개인) ",
	"6629"=>"회신번호 차단(기업) ",
	"6630"=>"서비스 불가 번호 ",
	"6631"=>"회신번호 사전 등록제에 의한 미등록 차단 ",
	"6632"=>"KISA 신고 스팸 회신번호 차단 ",
	"6633"=>"회신번호 사전 등록제 번호규칙 위반 ",
	"6670"=>"첨부파일 사이즈 초과(60K) ",
	 
	// 구 분 코 드 설 명 FAX 
	"3200"=>"전달 ",
	"3241"=>"부분전달 ",
	"3211"=>"통화 중 ",
	"3212"=>"응답 없음 ",
	"3213"=>"잘못된 번호",
	"3214"=>"잘못된 번호 ",
	"3242"=>"사람이 받음 ",
	"3216"=>"호 개통거부 ",
	"3217"=>"번호고장 ",
	"3219"=>"중계선 호 폭주 ",
	"3220"=>"호 개통 시간초과 ",
	"3221"=>"내부시스템 장애 ",
	"3222"=>"발신번호 사전 등록제에 의한 미등록 차단 ",
	"3223"=>"발신번호 사전 등록제 번호규칙 위반 ",
	"3243"=>"송신프로토콜 에러 ",
	"3244"=>"데이터 불량 ",
	"3245"=>"데이터 없음 ",
	"3218"=>"기타에러",
	"3250"=>"기타에러 ",
	 
	// 구 분 코 드 설 명 PHONE 일반전화 
	"1200"=>"청취 ",
	"1201"=>"청취 후 중간종료 ",
	"1202"=>"청취 후 답변 ",
	"1211"=>"통화 중 ",
	"1212"=>"부재 중 ",
	"1213"=>"잘못된 전화번호",
	"1214"=>"잘못된 전화번호 ",
	"1216"=>"호 개통거부 ",
	"1217"=>"번호고장 ",
	"1219"=>"중계선 호 폭주 ",
	"1220"=>"호 개통 시간초과 ",
	"1221"=>"내부시스템 장애 ",
	"1231"=>"시나리오 not found ",
	"1232"=>"시나리오 CGI error ",
	"1233"=>"Invalid VXML ",
	"1234"=>"시나리오 DNS error ",
	"1218"=>"기타에러",
	"1250"=>"기타에러 ",

	// 구 분 코 드 설 명 PHONE 휴대전화 
	"2201"=>"청취 ",
	"2202"=>"청취 후 답변 ",
	"2211"=>"통화 중 ",
	"2200"=>"부재 중 ",
	"2212"=>"부재 중 ",
	"2213"=>"잘못된 전화번호",
	"2214"=>"잘못된 전화번호 ",
	"2216"=>"호 개통거부 ",
	"2217"=>"번호고장 ",
	"2219"=>"중계선호폭주 ",
	"2220"=>"호 개통 시간초과 ",
	"2221"=>"내부시스템 장애 ",
	"2231"=>"시나리오 Not found ",
	"2232"=>"시나리오 CGI error ",
	"2233"=>"Invalid VXML ",
	"2234"=>"시나리오 DNS error ",
	"2218"=>"기타에러",
	"2250"=>"기타에러 ",
	 
	// 구 분 코 드 설 명 SMS_INBOUND 
	"5100"=>"사서함 미확인 ",
	"5110"=>"사서함 확인 ",
	"5111"=>"사서함 확인 후 답변 ",
	"5400"=>"음영지역 ",
	"5410"=>"잘못된 전화번호 ",
	"5420"=>"기타에러 "
);
?>
