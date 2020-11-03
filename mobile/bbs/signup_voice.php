<?php
include_once('/_common.php');

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

<div class="allWrap">
    <header class="subHd">
        <div class="left">
            <h2>회원가입</h2>
        </div>
        <div class="right">
            <!--
            <img src="../theme/basic/images/close.png">
            -->
            <a href="<?php echo G5_SHOP_URL;?>" id="backto">닫기</a>
        </div>
    </header>

    <main class="subWrap">
        <div class="joinStep">
            <p class="blueTxt">
                <small>상세정보 입력</small>
                <small><span>3</span>/<span>3</span></small>
            </p>
            <div class="stepBar">
                <span class="on3"></span>
            </div>

        </div>

        <div class="step3">
            <div class="tabwrap">
                <h4>회원구분선택</h4>
                <ul class="tabs">
                    <li>
                        <a href="./signup_normal.php"><span class=""></span>일반</a>
                    </li>
                    <li>
                        <a href="./signup_company.php"><span class=""></span>법인</a>
                    </li>
                    <li>
                        <a class="active" href="#"><span class="chkBoxImg"></span>성우</a>
                        <div id="tab3" class="tabconts">
                            <div class="tabbox">
                                <form id="form_signup_company" method="post" action="./signup_voice_update.php" enctype="MULTIPART/FORM-DATA" autocomplete="off">
                                    <input type="hidden" id="form_voice_type" name="form_voice_type" value="">
                                    <input type="hidden" id="form_voice_gen" name="form_voice_gen" value="">
                                    <div class="choiceWrap">
                                        <h4 class="blackTxt txt_l">협회성우 인가요? 비협회 성우인가요?</h4>
                                        <div class="choice">
                                            <input class="voice_type" type="radio" id="rdo01" name="choice" value="3">
                                            <label for="rdo01">협회성우</label>
                                            <input class="voice_type" type="radio" id="rdo02" name="choice" value="4">
                                            <label for="rdo02">비협회성우</label>
                                        </div>
                                        <small class="grayTxt txt_l">협회성우는 성우 협회에 등록되어있는 성우입니다.</small>
                                    </div>
                                    <div class="inputTxt mt_50 mb_40">
                                        <p class="itemTxt">이름</p>
                                        <input type="text" id="mb_name" name="mb_name" placeholder="성함을 입력해주세요">
                                        <label for="mb_name"></label>
                                    </div>

                                    <div class="choiceWrap">
                                        <h4 class="blackTxt txt_l">성별</h4>
                                        <div class="choice">
                                            <input class="voice_gen" type="radio" id="rdo011" name="choice2" value="f">
                                            <label for="rdo011">여자</label>
                                            <input class="voice_gen" type="radio" id="rdo022" name="choice2" value="m">
                                            <label for="rdo022">남자</label>
                                        </div>
                                    </div>

                                    <div class="inputType1 mt_20 mb_20">
                                        <p class="itemTxt">활동명</p>
                                        <div class="">
                                            <input type="text" id="nick" name="nick" placeholder="활동명을 입력해주세요">
                                            <label for="nick"></label>
                                            <button type="button" class="btnType1" id="chk_nickname">중복확인</button>
                                        </div>
                                    </div>

                                    <div class="inputType1">
                                        <p class="itemTxt">휴대폰번호</p>
                                        <div class="">
                                            <input type="text" id="mb_hp" name="mb_hp" placeholder="휴대폰번호를 입력해주세요">
                                            <label for="mb_hp"></label>
                                            <button type="button" class="btnType1" id="chk_hp_cert">본인인증</button>
                                        </div>
                                        <small class="grayTxt txt_l">휴대폰 본인인증을 하시면 카카오 알림톡으로 결제 정보, 알림 정보를 수신할 수 있습니다.</small>
                                    </div>

                                    <div class="inputTxt mb_40" id="network_from">
                                        <p class="itemTxt">출신 방송국</p>
                                        <div class="selectbox">
                                            <label for="ex_select1">방송국을 선택해주세요</label>
                                            <select id="network_from" name="network_from">
                                                <option value="">방송국을 선택해주세요</option>
                                                <option value="CBS">CBS</option>
                                                <option value="EBS">EBS</option>
                                                <option value="KBS">KBS</option>
                                                <option value="MBC">MBC</option>
                                                <option value="대원">대원</option>
                                                <option value="대교">대교 어린이TV</option>
                                                <option value="CJ&M(투니버스)">CJ&M(투니버스)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="inputTxt mb_40" id="entry_year">
                                        <p class="itemTxt">입사년도를 선택해주세요</p>
                                        <div class="selectbox">
                                            <label for="year">입사년도를 선택해주세요</label>
                                            <select id="year" name="year">
                                                <option value="">입사년도를 선택해주세요</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="inputTxt mb_40">
                                        <p class="itemTxt">녹음장비</p>
                                        <input type="text" id="rec_device" name="rec_device" placeholder="사용하는 녹음장비명을 입력해주세요">
                                        <label for="rec_device"></label>
                                    </div>

                                    <div class="inputTxt mb_40">
                                        <p class="itemTxt">인터페이스</p>
                                        <input type="text" id="rec_interface" name="rec_interface" placeholder="사용하는 인터페이스명을 입력해주세요">
                                        <label for="rec_interface"></label>
                                    </div>

                                    <div class="inputTxt mb_40">
                                        <p class="itemTxt">프로필 제목</p>
                                        <input type="text" id="profile_title" name="profile_title" placeholder="한줄 프로필 제목을 입력해주세요">
                                        <label for="profile_title"></label>
                                    </div>

                                    <div class="inputTxt mb_40">
                                        <p class="itemTxt">프로필등록<br>
                                        </p>
                                        <textarea class="textar" id="profile" name="profile" placeholder="자기소개 프로필을 작성해주세요."></textarea>
                                    </div>

                                    <div class="inputTxt mb_40">
                                        <p class="itemTxt">주요작품 및 클라이언트<br>
                                        </p>
                                        <textarea class="textar" id="activity" name="activity" placeholder="주요작품 및 클라이언트를 입력해주세요 &#13;&#10;예시) KBC 라디오 ○○○ A역할"></textarea>
                                    </div>


                                    <p class="itemTxt">
                                        샘플 오디오 등록
                                        <small class="fl_r grayTxt">*1개이상 필수등록</small>
                                    </p>
                                    <!--샘플오디오등록-->
                                    <div class="sampleaudio">
                                        <input type="hidden" id="audio_gen" name="audio_gen" value="f">
                                        <input type="hidden" id="main_audio" name="main_audio" value="y">
                                        <div class="inputTxt">
                                            <p class="pt_20">
                                                <input type="text" id="title" name="title" placeholder="오디오 설명을 입력해주세요">
                                                <label for="title"></label>
                                            </p>

                                        </div>
                                        <div class="inputType1 mt_20 mb_20">
                                            <div class="filebox">
                                                <input class="upload-name _B" value="" placeholder="첨부파일:샘플오디오파일명.wav">
                                                <label class="labelB" for="voice">파일첨부</label>
                                                <input type="file" id="voice" name="voice" class="upload-hidden">
                                            </div>

                                            <dl class="dl_layer">
                                                <dt>
                                                    카테고리
                                                </dt>
                                                <dd>
                                                    <div class="selectbox">
                                                        <label for="ex_select3">카테고리를 선택해주세요</label>
                                                        <select id="cat" name="cat">
                                                            <option value="">카테고리를 선택해주세요</option>
                                                            <option value="10">광고</option>
                                                            <option value="11">홍보</option>
                                                            <option value="12">방송</option>
                                                            <option value="13">만화</option>
                                                            <option value="14">게임</option>
                                                            <option value="15">영화예고</option>
                                                            <option value="16">이벤트</option>
                                                            <option value="17">오디오북,교재</option>
                                                            <option value="18">기기음성,성대모사</option>
                                                            <option value="19">ARS,안내멘트</option>
                                                            <option value="20">홈쇼핑</option>
                                                            <option value="21">비상업용</option>
                                                        </select>
                                                    </div>
                                                </dd>
                                            </dl>
                                            <dl class="dl_layer">
                                                <dt>
                                                    성별
                                                </dt>
                                                <dd>
                                                    <div class="choice">
                                                        <input type="radio" class="audio_gen" id="rdo03" name="gender">
                                                        <label for="rdo03">여자</label>

                                                        <input type="radio" class="audio_gen" id="rdo04" name="gender">
                                                        <label for="rdo04">남자</label>
                                                    </div>
                                                </dd>
                                            </dl>
                                            <dl class="dl_layer">
                                                <dt>
                                                    나이대
                                                </dt>
                                                <dd>
                                                    <div class="selectbox">
                                                        <label for="ex_select3">샘플의 나이대를 선택해주세요</label>
                                                        <select id="age" name="age">
                                                            <option value="">샘플의 나이대를 선택해주세요</option>
                                                            <?php echo conv_selected_option($age_select, ''); ?>
                                                        </select>
                                                    </div>
                                                </dd>
                                            </dl>
                                            <dl class="dl_layer">
                                                <dt>
                                                    스타일
                                                </dt>
                                                <dd>
                                                    <div class="selectbox">
                                                        <label for="ex_select3">샘플의 연기스타일을 선택해주세요</label>
                                                        <select id="sty" name="sty">
                                                            <option value="">샘플의 연기스타일을 선택해주세요</option>
                                                            <?php echo conv_selected_option($style_select, ''); ?>
                                                        </select>
                                                    </div>
                                                </dd>
                                            </dl>
                                            <dl class="dl_layer">
                                                <dt>
                                                    톤
                                                </dt>
                                                <dd>
                                                    <div class="selectbox">
                                                        <label for="ex_select3">샘플의 음역대를 선택해주세요</label>
                                                        <select id="ton" name="ton">
                                                            <option value="">샘플의 음역대를 선택해주세요</option>
                                                            <?php echo conv_selected_option($tone_select, ''); ?>
                                                        </select>
                                                    </div>
                                                </dd>
                                            </dl>
                                            <dl class="dl_layer">
                                                <dt>
                                                    언어
                                                </dt>
                                                <dd>
                                                    <div class="selectbox">
                                                        <label for="ex_select3">샘플의 언어/억양을 선택해주세요</label>
                                                        <select id="lan" name="lan">
                                                            <option value="">샘플의 언어/억양을 선택해주세요</option>
                                                            <?php echo conv_selected_option($language_select, ''); ?>
                                                        </select>
                                                    </div>
                                                </dd>
                                            </dl>

                                            <!--
                                            <div class="mt_20 txt_l fl_r">
                                                <label for="rdo05" class="blackTxt">
                                                    <input type="radio" id="rdo05" name="rdo05">
                                                    대표 샘플로 설정합니다.
                                                </label>
                                            </div>
                                            -->
                                        </div>
                                    </div>

                                    <!--
                                    <button class="normal">샘플 오디오 추가하기</button>
                                    -->
                                    <button type="button" class="bigBtn mt_50 mb_100" id="signup">회원 정보 변경</button>
                                </form>
                            </div>
                        </div>
                    </li>
                    <li id="not_open">
                        <a href="#"><span class=""></span>엔지니어</a>
                    </li>
                </ul>
            </div>
        </div>


    </main>

    <!--
    <div class="quicMenu">
        <ul>
            <li>
                <a href="#a">
                    <p><img src="../theme/basic/images/briefcase.svg" class="imgSvg"></p>
                    <p>오디션</p>
                </a>
            </li>
            <li>
                <a href="#a">
                    <p><img src="../theme/basic/images/heart.svg" class="imgSvg"></p>
                    <p>관심리스트</p>
                </a>
            </li>
            <li>
                <a href="#a">
                    <p><img src="../theme/basic/images/chatbubble.svg" class="imgSvg"></p>
                    <p>채팅</p>
                </a>
            </li>
            <li>
                <a href="#a">
                    <p><img src="../theme/basic/images/person.svg" class="imgSvg"></p>
                    <p>마이페이지</p>
                </a>
            </li>
        </ul>

        <button class="top" onClick="scrollToTop()">
            <img src="../theme/basic/images/button_a.png" srcset="../theme/basic/images/button_a.png 1x, ../theme/basic/images/button_a@2x.png 2x">
        </button>

        <button class="back">
            <img src="../theme/basic/images/button_arrow_back.png" srcset="../theme/basic/images/button_arrow_back.png 1x, ../theme/basic/images/button_arrow_back@2x.png 2x">
        </button>

        <button class="gokakao">
            <img src="../theme/basic/images/button_kakao_1.png" srcset="../theme/basic/images/button_kakao_1.png 1x, ../theme/basic/images/button_kakao_1@2x.png 2x">
        </button>
    </div>
    -->
</div>

<script type="text/javascript" src="<?php echo G5_JS_URL; ?>/jquery-3.4.1.js"></script>
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script src="<?php echo G5_JS_URL; ?>/slick.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo G5_JS_URL; ?>/allvoice.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">

    $(document).ready(function () {
        console.log("ready!");
        $('body').css('padding-top', '0px');

        // 협회성우 입사년도
        setDateBox();

        let checkNickname = false;

        //>> (Start) 성우 타입(협회, 일반)
        $(".voice_type").click(function () {
            console.log("voice_type");
            console.log($(this).attr('id'));

            $("#network_from").show();
            $("#entry_year").show();

            if (this.id === "rdo01") {
                $("#voice_association").attr("class", "on");
                $("#network_from").show();
                $("#entry_year").show();

                $("#form_voice_type").val("3");

            } else {
                $("#voice_normal").attr("class", "on");
                $("#network_from").hide();
                $("#entry_year").hide();

                $("#form_voice_type").val("4");
            }
        });
        //<< (Start) 성우 타입(협회, 일반)

        //>> (Start) 성별
        $(".voice_gen").click(function () {

            if (this.id === "rdo011") {
                $("#form_voice_gen").val("f");
            } else {
                $("#form_voice_gen").val("m");
            }
        });
        //<< (Start) 성우 타입(협회, 일반)

        //>> (Start) 성별
        $(".audio_gen").click(function () {

            if (this.id === "rdo03") {
                $("#audio_gen").val("f");
            } else {
                $("#audio_gen").val("m");
            }
        });
        //<< (Start) 성우 타입(협회, 일반)

        //>> (Start)닉네임 중복확인
        $("#chk_nickname").click(function () {
            console.log("중복확인");
            let nickname = $("#nick").val().trim();

            console.log(nickname);

            // 유효성 체크
            if (nickname === "") {
                alert("활동명을 입력해 주세요.");
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
        //>> (End)닉네임 중복확인


        $("#tabs li").click(function (index) {
            // $("li:eq(1)").attr("data-val", "hello");
            // let index = $("li").index(this);
            // console.log("2" + index);
        });

        // chk_hp_cert"
        //>> (Start) 휴대폰 본인인증
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
        //<< (End) 휴대폰 본인인증

        //>> (Start)회원가입
        $("#signup").click(function () {
            console.log("signup");

            //<input type="hidden" id="form_voice_type" name="form_voice_type" value="">
            //    <input type="hidden" id="form_voice_gen" name="form_voice_gen" value="">

            // 유효성 검사.
            // 협회, 일반성우 체크 확인
            console.log($("#form_voice_type").val());
            if ("3" !== $("#form_voice_type").val() && "4" !== $("#form_voice_type").val()) {
                alert("협회성우, 일반성우인지 체크해주세요.");
                $(".voice_type").focus();
                return false;
            }

            // 일반성우이면 방송국, 입사년도 초기화
            if ( "4" === $("#form_voice_type").val()) {
                $("#network_from option:eq(0)").prop("selected", true);
                $("#year option:eq(0)").prop("selected", true);
            }

            if ("f" !== $("#form_voice_gen").val() && "m" !== $("#form_voice_gen").val()) {
                alert("성별을 선택해주세요.");
                $(".voice_gen").focus();
                return false;
            }

            // 활동명 확인
            if (false === checkNickname) {
                alert("활동명 중복체크를 해주세요.");
                return false;
            }

            $("#form_signup_company").submit();
        });
        //>> (End)회원가입

        $("#not_open").click(function () {
            alert("준비중입니다.");
        });
    }); // end of document ready

    $("li").click(function () {
        // $("li:eq(1)").attr("data-val", "hello");
        let index = $("li").index(this);
        // console.log("5" + index);
    });

    $("#tabs").on("click", "li", function () {
        // $("li:eq(1)").attr("data-val", "hello");
        let index = $("li").index(this);
        // console.log("1" + index);
    });


    // 회원가입하기
    $(".bigBtn").click(function () {
        console.log("bigBtn");
    });

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

    function setDateBox() {
        let dt = new Date();
        let com_year = dt.getFullYear();
        console.log(com_year);

        for (var y = com_year; y > (com_year - 40); y--) {
            $("#year").append("<option value='" + y + "'>" + y + " 년" + "</option>");
        }
    }
</script>