<?php
include_once('/_common.php');
include_once(G5_MSHOP_PATH . '/_head.php');

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
            <img src="../theme/basic/images/close.png">
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
                        <a href="#tab1"><span class="chkBoxImg"></span>일반</a>
                        <div id="tab1" class="tabconts">
                            <div class="tabbox">
                                <form method="post" action="./member_info_update.php">
                                    <div class="inputTxt mt_50 mb_40">
                                        <p class="itemTxt">이름 </p>
                                        <input type="text" id="mb_name" name="mb_name" placeholder="성함을 입력해주세요">
                                        <label for="mb_name"></label>
                                    </div>

                                    <div class="inputType1">
                                        <p class="itemTxt">닉네임</p>
                                        <div class="">
                                            <input type="text" id="nick01" name="mb_nick" placeholder="닉네임을 입력해주세요">
                                            <label for="nick"></label>
                                            <button class="btnType1" type="button">중복확인</button>
                                        </div>
                                    </div>

                                    <div class="inputType1">
                                        <p class="itemTxt">휴대폰번호</p>
                                        <div class="">
                                            <input type="text" id="mb_hp" name="mb_hp" placeholder="휴대폰번호를 입력해주세요">
                                            <label for="mb_hp"></label>
                                            <button class="btnType1" id="chk_hp_cert">본인인증</button>
                                        </div>
                                        <small class="grayTxt txt_l">휴대폰 본인인증을 하시면 카카오 알림톡으로 결제 정보, 알림 정보를 수신할 수 있습니다.</small>
                                    </div>

                                    <!--
                                    <button class="bigBtn mt_20 mb_100" onClick="location.href='join4.html'">회원가입하기</button>
                                    -->
                                    <button class="bigBtn mt_20 mb_100" type="submit">회원가입하기</button>
                                </form>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="#tab2"><span class="chkBoxImg"></span>법인</a>
                        <div id="tab2" class="tabconts">
                            <div class="tabbox">
                                <form method="post" action="./member_info_update.php">
                                    <div class="inputTxt mt_50 mb_40">
                                        <p class="itemTxt">담당자 이름</p>
                                        <input type="text" id="name02" name="mb_name" placeholder="성함을 입력해주세요">
                                        <label for="name02"></label>
                                    </div>

                                    <div class="inputType1">
                                        <p class="itemTxt">상호명</p>
                                        <div class="">
                                            <input type="text" id="comname01" name="mb_nick" placeholder="닉네임을 입력해주세요">
                                            <label for="comname01"></label>
                                            <button class="btnType1">중복확인</button>
                                        </div>
                                    </div>

                                    <div class="inputType1">
                                        <p class="itemTxt">휴대폰번호</p>
                                        <div class="">
                                            <input type="text" id="phone02" name="mb_hp" placeholder="휴대폰번호를 입력해주세요">
                                            <label for="phone02"></label>
                                            <button class="btnType1">본인인증</button>
                                        </div>
                                        <small class="grayTxt txt_l">휴대폰 본인인증을 하시면 카카오 알림톡으로 결제 정보, 알림 정보를 수신할 수 있습니다.</small>
                                    </div>

                                    <div class="inputType1">
                                        <p class="itemTxt">사업자 등록번호</p>
                                        <div class="">
                                            <div class="filebox">
                                                <input class="upload-name" name="mb_tax_id_no" value="" placeholder="사업자등록번호를 입력해주세요">
                                                <label for="ex_filename">사본첨부</label>
                                                <input type="file" id="ex_filename" class="upload-hidden">
                                            </div>
                                        </div>

                                        <small class="grayTxt txt_l">세금계산서 발행을 위해 사업자등록증 사본을 첨부해주세요.</small>
                                    </div>

                                    <button class="bigBtn mt_20 mb_100" onClick="location.href='join4.html'">회원가입하기</button>
                                </form>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="#tab3"><span class="chkBoxImg"></span>성우</a>
                        <div id="tab3" class="tabconts">
                            <div class="tabbox">
                                <form>
                                    <div class="choiceWrap">
                                        <h4 class="blackTxt txt_l">협회성우 인가요? 비협회 성우인가요?</h4>
                                        <div class="choice">
                                            <input type="radio" id="rdo01" name="choice">
                                            <label for="rdo01">협회성우</label>

                                            <input type="radio" id="rdo02" name="choice">
                                            <label for="rdo02">비협회성우</label>
                                        </div>
                                        <small class="grayTxt txt_l">협회성우는 성우 협회에 등록되어있는 성우입니다.</small>
                                    </div>
                                    <div class="inputTxt mt_50 mb_40">
                                        <p class="itemTxt">이름</p>
                                        <input type="text" id="name04" placeholder="성함을 입력해주세요">
                                        <label for="name04"></label>
                                    </div>

                                    <div class="inputTxt mb_40">
                                        <p class="itemTxt">활동명</p>

                                        <input type="text" id="nick04" placeholder="활동명을 입력해주세요">
                                        <label for="nick04"></label>

                                    </div>

                                    <div class="inputType1">
                                        <p class="itemTxt">휴대폰번호</p>
                                        <div class="">
                                            <input type="text" id="phone04" placeholder="휴대폰번호를 입력해주세요">
                                            <label for="phone04"></label>
                                            <button class="btnType1">본인인증</button>
                                        </div>
                                        <small class="grayTxt txt_l">휴대폰 본인인증을 하시면 카카오 알림톡으로 결제 정보, 알림 정보를 수신할 수 있습니다.</small>
                                    </div>

                                    <div class="inputTxt mb_40">
                                        <p class="itemTxt">출신 방송국</p>

                                        <div class="selectbox">
                                            <label for="ex_select1">방송국을 선택해주세요</label>
                                            <select id="ex_select1">
                                                <option selected>방송국을 선택해주세요</option>
                                                <option>한국</option>
                                                <option>미국</option>
                                                <option>중국</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="inputTxt mb_40">
                                        <p class="itemTxt">입사년도를 선택해주세요</p>
                                        <div class="selectbox">
                                            <label for="ex_select2">입사년도를 선택해주세요</label>
                                            <select id="ex_select2">
                                                <option selected>입사년도를 선택해주세요</option>
                                                <option>2000</option>
                                                <option>2100</option>
                                                <option>2200</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="inputTxt mb_40">
                                        <p class="itemTxt">녹음장비</p>

                                        <input type="test" id="auto04" placeholder="사용하는 녹음장비명을 입력해주세요">
                                        <label for="auto04"></label>

                                    </div>

                                    <div class="inputTxt mb_40">
                                        <p class="itemTxt">인터페이스</p>

                                        <input type="test" id="auto04" placeholder="사용하는 인터페이스명을 입력해주세요">
                                        <label for="auto04"></label>

                                    </div>

                                    <div class="inputTxt mb_40">
                                        <p class="itemTxt">프로필등록<br>
                                        </p>
                                        <textarea class="textar" placeholder="주요작품 및 클라이언트를 입력해주세요 &#13;&#10;예시) KBC 라디오 ○○○ A역할"></textarea>

                                    </div>


                                    <p class="itemTxt">
                                        샘플 오디오 등록
                                        <small class="fl_r grayTxt">*1개이상 필수등록</small>
                                    </p>
                                    <!--샘플오디오등록-->
                                    <div class="sampleaudio">
                                        <div class="inputTxt">
                                            <p class="pt_20">
                                                <input type="text" id="auto05" placeholder="오디오 설명을 입력해주세요">
                                                <label for="auto05"></label>
                                            </p>

                                        </div>
                                        <div class="inputType1 mt_20 mb_20">
                                            <div class="filebox">
                                                <input class="upload-name _B" value="" placeholder="첨부파일:샘플오디오파일명.wav">
                                                <label class="labelB" for="ex_filename1">파일첨부</label>
                                                <input type="file" id="ex_filename1" class="upload-hidden">
                                            </div>

                                            <dl class="dl_layer">
                                                <dt>
                                                    카테고리
                                                </dt>
                                                <dd>
                                                    <div class="selectbox">
                                                        <label for="ex_select3">카테고리를 선택해주세요</label>
                                                        <select id="ex_select3">
                                                            <option selected>카테고리를 선택해주세요</option>
                                                            <option>카테고리</option>
                                                            <option>카테고리</option>
                                                            <option>카테고리</option>
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
                                                        <input type="radio" id="rdo03" name="gender">
                                                        <label for="rdo03">여자</label>

                                                        <input type="radio" id="rdo04" name="gender">
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
                                                        <select id="ex_select3">
                                                            <option selected>샘플의 나이대를 선택해주세요</option>
                                                            <option>10</option>
                                                            <option>20</option>
                                                            <option>30</option>
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
                                                        <select id="ex_select3">
                                                            <option selected>샘플의 연기스타일을 선택해주세요</option>
                                                            <option>스타일</option>
                                                            <option>스타일</option>
                                                            <option>스타일</option>
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
                                                        <select id="ex_select3">
                                                            <option selected>샘플의 음역대를 선택해주세요</option>
                                                            <option>음역대</option>
                                                            <option>음역대</option>
                                                            <option>음역대</option>
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
                                                        <select id="ex_select3">
                                                            <option selected>샘플의 언어/억양을 선택해주세요</option>
                                                            <option>언어/억양</option>
                                                            <option>언어/억양</option>
                                                            <option>언어/억양</option>
                                                        </select>
                                                    </div>
                                                </dd>
                                            </dl>

                                            <div class="mt_20 txt_l fl_r">
                                                <label for="rdo05" class="blackTxt">
                                                    <input type="radio" id="rdo05" name="rdo05">
                                                    대표 샘플로 설정합니다.
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="normal">샘플 오디오 추가하기</button>
                                    <button class="bigBtn mt_50 mb_100" onClick="location.href='join4.html'">회원가입하기</button>
                                </form>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="#tab4"><span class="chkBoxImg"></span>엔지니어</a>
                        <div id="tab4" class="tabconts">
                            <div class="tabbox">
                                <form>
                                    <div class="inputTxt mt_50 mb_40">
                                        <p class="itemTxt">이름</p>
                                        <input type="text" id="name04" placeholder="성함을 입력해주세요">
                                        <label for="name04"></label>
                                    </div>

                                    <div class="inputTxt mb_40">
                                        <p class="itemTxt">활동명</p>

                                        <input type="text" id="nick04" placeholder="활동명을 입력해주세요">
                                        <label for="nick04"></label>

                                    </div>

                                    <div class="inputType1">
                                        <p class="itemTxt">휴대폰번호</p>
                                        <div class="">
                                            <input type="text" id="phone04" placeholder="휴대폰번호를 입력해주세요">
                                            <label for="phone04"></label>
                                            <button class="btnType1">본인인증</button>
                                        </div>
                                        <small class="grayTxt txt_l">휴대폰 본인인증을 하시면 카카오 알림톡으로 결제 정보, 알림 정보를 수신할 수 있습니다.</small>
                                    </div>

                                    <div class="inputTxt mb_40">
                                        <p class="itemTxt">오디오 장비</p>

                                        <input type="text" id="auto03" placeholder="사용하는 오디오장비명을 입력해주세요">
                                        <label for="auto03"></label>

                                    </div>

                                    <div class="inputTxt mb_40">
                                        <p class="itemTxt">오디오 프로그램</p>

                                        <input type="test" id="auto04" placeholder="사용하는 오디오프로그램명을 입력해주세요">
                                        <label for="auto04"></label>

                                    </div>

                                    <div class="inputTxt mb_40">
                                        <p class="itemTxt">프로필등록<br>
                                        </p>
                                        <textarea class="textar" placeholder="주요작품 및 클라이언트를 입력해주세요 &#13;&#10;예시) KBC 라디오 ○○○ A역할"></textarea>

                                    </div>


                                    <p class="itemTxt">
                                        샘플 오디오 등록
                                        <small class="fl_r grayTxt">*1개이상 필수등록</small>
                                    </p>
                                    <!--샘플오디오등록-->
                                    <div class="sampleaudio">
                                        <div class="inputTxt">
                                            <p class="pt_20">
                                                <input type="text" id="auto05" placeholder="오디오 설명을 입력해주세요">
                                                <label for="auto05"></label>
                                            </p>

                                        </div>
                                        <div class="inputType1 mt_20 mb_20">
                                            <div class="filebox">
                                                <input class="upload-name _B" value="" placeholder="첨부파일:샘플오디오파일명.wav">
                                                <label class="labelB" for="ex_filename2">파일첨부</label>
                                                <input type="file" id="ex_filename2" class="upload-hidden">
                                            </div>

                                            <div class="mt_20 txt_l fl_r">
                                                <label for="rdo06" class="blackTxt">
                                                    <input type="radio" id="rdo06" name="rdo06">
                                                    대표 샘플로 설정합니다.
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="normal">샘플 오디오 추가하기</button>
                                    <button class="bigBtn mt_50 mb_100" onClick="location.href='join4.html'">회원가입하기</button>
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

        </div>


    </main>

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
</div>

<script type="text/javascript" src="<?php echo G5_JS_URL; ?>/jquery-3.4.1.js"></script>
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script src="<?php echo G5_JS_URL; ?>/slick.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo G5_JS_URL; ?>/allvoice.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">

    $(document).ready(function () {
        console.log("ready!");

        $("#tabs li").click(function (index) {
            // $("li:eq(1)").attr("data-val", "hello");
            // let index = $("li").index(this);
            console.log("2" + index);
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

    });

    $("li").click(function () {
        // $("li:eq(1)").attr("data-val", "hello");
        let index = $("li").index(this);
        console.log("5" + index);
    });

    $("#tabs").on("click", "li", function () {
        // $("li:eq(1)").attr("data-val", "hello");
        let index = $("li").index(this);
        console.log("1" + index);
    });

    // 닉네임/확동명 중복확인
    $(".btnType1").click(function () {
        console.log("btnType1");
        //return false;
        // Check nickname.
        let nickname = "몽키";

        // Send email for certification.
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
                    return false;
                }
            }
        });
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

</script>