<?php
include_once('./_common.php');

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH . '/bbs/signup_voice.php');
    return;
}

$g5['title'] = '로그인2';
include_once('./_head.sub.php');


// 불법접근을 막도록 토큰생성
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


    <div id="contentsWrapEx">

        <!-- 회원가입 3단계 협회성우-->
        <div id="join_wrap">
            <div class="graph_box">
                <p class="text_box">
                    <span class="text">상세정보 입력</span>
                    <span class="num">3 / 3</span>
                </p>
                <div class="graph">
                    <span style="width:100%;"></span>
                </div>
            </div>
            <div class="user_tab">
                <p>회원 구분 선택</p>
                <ul>
                    <li><a href="./signup_normal.php"><span>일반</span></a></li>
                    <li><a href="./signup_company.php"><span>법인</span></a></li>
                    <li class="on"><a href="#none"><span>성우</span></a></li>
                    <li id="not_open"><a href="javascript:"><span>엔지니어</span></a></li>
                    <!--
                    <li><a href="signup_engineer.php"><span>엔지니어</span></a></li>
                    -->
                </ul>
            </div>

            <form id="form_signup_voice" name="form_signup_voice" action="./signup_voice_update.php" method="post" enctype="MULTIPART/FORM-DATA" autocomplete="off">
                 <input type="hidden" id="form_voice_type" name="form_voice_type" value="3">
                <input type="hidden" id="form_voice_gen" name="form_voice_gen" value="f">
                <div class="user_tab w2">
                    <label for="">협회 성우인가요? 비협회 성우인가요?</label>
                    <ul id="voice_type">
                        <li class="on" id="voice_association"><a href="#none"><span>협회 성우</span></a></li>
                        <li id="voice_normal"><a href="#none"><span>비협회 성우</span></a></li>
                    </ul>
                    <p class="small_text">협회성우는 성우 협회에 등록되어 있는 성우입니다.</p>
                </div>
                <div class="user_box wide">
                    <div class="inp_box">
                        <label for="mb_name" class="label_st1">이름</label>
                        <input type="text" id="mb_name" name="mb_name" placeholder="성함을 입력해주세요" class="inp_st1"/>
                    </div>

                    <div class="inp_box">
                        <div class="user_tab w2">
                            <label for="form_gen" class="label_st1">성별</label>
                            <ul id="form_gen">
                                <li class="on" id="form_gen_female" value="f"><a href="#none"><span>여자</span></a></li>
                                <li id="form_gen_man" value="m"><a href="#none"><span>남자</span></a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="inp_box">
                        <label for="nick" class="label_st1">활동명</label>
                        <input type="text" id="nick" name="nick" placeholder="활동명을 입력해주세요" class="inp_st1"/>
                        <a href="#none" class="inp_btn" id="chk_nickname">중복확인</a>
                    </div>

                    <div class="inp_box add_btn">
                        <label for="cert_no" class="label_st1">휴대폰 번호</label>
                        <input type="text" id="mb_hp" name="mb_hp" placeholder="휴대폰 번호를 입력해주세요" class="inp_st1"/>
                        <a href="javascript:" class="inp_btn" id="chk_hp_cert">본인인증</a>
                        <p class="small_text">휴대폰 본인인증을 하시면 카카오 알림톡으로 결제 정보, 알림 정보를 수신할 수 있습니다.</p>
                    </div>

                    <div class="inp_box" id="network_from">
                        <label for="sel" class="label_st1">출신 방송국</label>
                        <div class="select_bg">
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

                    <div class="inp_box" id="entry_year">
                        <label for="year" class="label_st1">입사년도</label>
                        <div class="select_bg">
                            <select id="year" name="year">
                                <option value="">입사년도를 선택해주세요</option>
                            </select>
                        </div>
                    </div>

                    <div class="inp_box">
                        <label for="rec_device" class="label_st1">녹음 장비</label>
                        <input type="text" id="rec_device" name="rec_device" placeholder="사용하는 녹음장비명을 입력해주세요" class="inp_st1"/>
                    </div>

                    <div class="inp_box">
                        <label for="rec_interface" class="label_st1">인터페이스</label>
                        <input type="text" id="rec_interface" name="rec_interface" placeholder="사용하는 오디오 인터페이스명을 입력해주세요" class="inp_st1"/>
                    </div>

                    <div class="inp_box">
                        <label for="profile_title" class="label_st1">프로필 제목</label>
                        <input type="text" id="profile_title" name="profile_title" placeholder="한줄 프로필 제목을 입력해주세요." class="inp_st1"/>
                    </div>

                    <div class="inp_box">
                        <label for="profile" class="label_st1">프로필 등록</label>
                        <textarea class="textarea_st1" id="profile" name="profile" placeholder="자기소개 프로필을 작성해주세요."></textarea>
                        <!--
                        <a href="#none" class="inp_btn">중복확인</a>
                        -->
                    </div>

                    <div class="inp_box">
                        <label for="activity" class="label_st1">주요작품 및 클라이언트</label>
                        <textarea class="textarea_st1" id="activity" name="activity" placeholder="주요작품 및 클라이언트를 입력해주세요 예시) KBC 라디오 ○○○ 역할"></textarea>
                        <!--
                        <a href="#none" class="inp_btn">중복확인</a>
                        -->
                    </div>

                    <div class="audio_box">
                        <input type="hidden" id="audio_gen" name="audio_gen" value="f">
                        <input type="hidden" id="main_audio" name="main_audio" value="y">
                        <p class="text">샘플 오디오 등록<span>* 1개 이상 필수 등록</span></p>
                        <input type="text" id="title" name="title" placeholder="오디오설명을 입력해주세요" class="inp_st1"/>

                        <div class="audio_file">
                            <input type="file" id="voice" name="voice"/>
                            <label for="file" class="label_file">파일첨부</label>
                        </div>

                        <div class="sel_box">
                            <div class="box">
                                <label for="cat" class="label_st1">카테고리</label>
                                <div class="select_bg">
                                    <select id="cat" name="cat">
                                        <option value="">카테고리를 선택해주세요</option>
                                        <?php echo conv_selected_option($category_select, ''); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="box">
                                <label for="gen" class="label_st1">성별</label>
                                <div class="user_tab w2">
                                    <ul id="gen">
                                        <li class="on" id="gen_female" value="f"><a href="#none"><span>여자</span></a></li>
                                        <li id="gen_man" value="m"><a href="#none"><span>남자</span></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="box">
                                <label for="age" class="label_st1">나이대</label>
                                <div class="select_bg">
                                    <select id="age" name="age">
                                        <option value="">샘플의 나이대를 선택하세요</option>
                                        <?php echo conv_selected_option($age_select, ''); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="box">
                                <label for="sty" class="label_st1">스타일</label>
                                <div class="select_bg">
                                    <select id="sty" name="sty">
                                        <option value="">샘플의 연기 스타일을 선택하세요</option>
                                        <?php echo conv_selected_option($style_select, ''); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="box">
                                <label for="ton" class="label_st1">톤</label>
                                <div class="select_bg">
                                    <select id="ton" name="ton">
                                        <option value="">샘플의 음역대를 선택하세요</option>
                                        <?php echo conv_selected_option($tone_select, ''); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="box">
                                <label for="lan" class="label_st1">언어</label>
                                <div class="select_bg">
                                    <select id="lan" name="lan">
                                        <option value="">샘플의 언어/억양을 선택하세요</option>
                                        <?php echo conv_selected_option($language_select, ''); ?>
                                    </select>
                                </div>
                            </div>
                            <!--
                            <div class="btn_check3">
                                <input type="checkbox" id="set" name="set">
                                <i></i>
                                <label for="set">대표 샘플로 설정합니다.</label>
                            </div>
                            -->
                        </div>
                    </div>

                    <div class="btn_box">
                        <!--
                        <a href="#none" class="btn_st1 short">샘플 오디오 추가하기</a>
                        -->
                        <a href="#none" class="btn_st1">회원 정보 변경</a>
                    </div>
                </div>
            </form>
        </div>
        <!-- 회원가입 3단계 협회성우-->

    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            console.log("ready");

            setDateBox();

            let checkNickname = false;

            // 닉네임 중복확인
            $("#chk_nickname").click(function () {
                console.log("중복확인");
                let nickname = $("#nick").val().trim();

                console.log(nickname);

                // 유효성 체크
                if (nickname === "") {
                    alert("닉네임을 입력해 주세요.");
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


            $(".btn_st1").click(function () {
                console.log("회원가입하기");
                $("#form_signup_voice").submit();
            });

            $("#voice_type").on("click", "li", function () {
                console.log(this.id);

                $("#voice_association").attr("class", "");
                $("#voice_normal").attr("class", "");

                if (this.id === "voice_association") {
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

                console.log($("#form_voice_type").val());
            })

            $("#gen").on("click", "li", function () {
                console.log(this.id);

                $("#gen_female").attr("class", "");
                $("#gen_man").attr("class", "");

                if (this.id === "gen_female") {
                    $("#gen_female").attr("class", "on");
                    $("#audio_gen").val("f");

                } else {
                    $("#gen_man").attr("class", "on");
                    $("#audio_gen").val("m");
                }
            });


            $("#form_gen").on("click", "li", function () {
                console.log(this.id);

                $("#form_gen_female").attr("class", "");
                $("#form_gen_man").attr("class", "");

                if (this.id === "form_gen_female") {
                    $("#form_gen_female").attr("class", "on");
                    $("#form_voice_gen").val("f");

                } else {
                    $("#form_gen_man").attr("class", "on");
                    $("#form_voice_gen").val("m");
                }
            });

            // 휴대폰 본인인증
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

            $("#not_open").click(function() {
                alert("준비중");
            });
        }); // end of document ready

        function setDateBox() {
            let dt = new Date();
            let com_year = dt.getFullYear();
            console.log(com_year);

            for (var y = com_year; y > (com_year - 40); y--) {
                $("#year").append("<option value='" + y + "'>" + y + " 년" + "</option>");
            }
        }

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

    </script>

<?php
include_once('./_tail.sub.php');
?>