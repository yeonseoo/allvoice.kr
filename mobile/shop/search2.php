<?php
include_once('./_common.php');
//include_once(G5_MSHOP_PATH . '/_head.php');

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');

?>

<body class="base">
<div class="allWrap">
     <header class="subHd">
        <div class="left">
            <h2>검색</h2>
        </div>
        <div class="right">
            <!--
            <a href="#" id="backto" onclick="history.back()"><img src="../theme/basic/images/close.png"></a>
            -->
            <a href="#" id="backto" onclick="history.back(); return false;">닫기</a>
        </div>
    </header>

    <main class="subWrap">
        <form method="get" action="./voiceList.php">
            <div class="schStep">
                <div class="inputTxt mt_20 mb_20">
                    <input type="text" id="search_name" name="search_name" placeholder="이름검색">
                    <label for="search_name"></label>
                </div>
                <div class="schFilter">
                    <small>필터검색</small>
                    <div class="openClose">
                        <a href="#a" class="openA"><small>열기<img src="../theme/basic/images/chevron-down.svg"></small></a>
                        <a href="#a" class="closeA"><small>닫기<img src="../theme/basic/images/chevron-up.svg"></small></a>
                    </div>
                </div>
            </div>

            <div class="schWrap">
                <div class="filters">
                    <div class="mt_20 grayTxt">
                        <!--
                        <div class="choice sch">
                            <input type="radio" id="rdo01" name="sch" checked>
                            <label for="rdo01">협회성우</label>

                            <input type="radio" id="rdo02" name="sch">
                            <label for="rdo02">비협회성우</label>

                            <input type="radio" id="rdo03" name="sch">
                            <label for="rdo03">엔지니어</label>
                        </div>
                        <small class="grayTxt txt_l">협회성우는 성우 협회에 등록되어있는 성우입니다.</small>
                        -->
                    </div>

                    <div class="inputType1 mt_20 mb_20">
                        <dl class="dl_layer">
                            <dt>
                                카테고리
                            </dt>
                            <dd>
                                <div class="selectbox">
                                    <label for="ex_select3">카테고리를 선택해주세요</label>
                                    <select id="ex_select3" name="search_cat">
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
                                    <input type="radio" id="rdo04" name="search_gen" value="f">
                                    <label for="rdo04" class="grayTxt">여자</label>
                                    <input type="radio" id="rdo05" name="search_gen" value="m">
                                    <label for="rdo05" class="grayTxt">남자</label>
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
                                    <select id="ex_select3" name="search_age">
                                        <option value="">샘플의 나이대를 선택해주세요</option>
                                        <!--
                                        <option>유아</option>
                                        <option>아동</option>
                                        <option>청소년</option>
                                        <option>젊은성인</option>
                                        <option>중년</option>
                                        <option>노년</option>
                                        -->
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
                                    <select id="ex_select3" name="search_style">
                                        <option value="">샘플의 연기스타일을 선택해주세요</option>
                                        <!--
                                        <option>밝은</option>
                                        <option>귀여운</option>
                                        <option>섹시한</option>
                                        <option>순수한</option>
                                        <option>재미있는</option>
                                        <option>따뜻한</option>
                                        <option>차분한</option>
                                        <option>힘있는</option>
                                        <option>귄위있는</option>
                                        <option>시크한</option>
                                        <option>사악한</option>
                                        -->
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
                                    <select id="ex_select3" name="search_ton">
                                        <option value="">샘플의 음역대를 선택해주세요</option>
                                        <!--
                                        <option>저음</option>
                                        <option>중음</option>
                                        <option>고음</option>
                                        -->
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
                                    <select id="ex_select3" name="search_lan">
                                        <option value="">샘플의 언어/억양을 선택해주세요</option>
                                        <!--
                                        <option>표준어</option>
                                        <option>전라도</option>
                                        <option>경상도</option>
                                        <option>강원도</option>
                                        <option>충천도</option>
                                        <option>그외</option>
                                        <option>영어</option>
                                        <option>중국어</option>
                                        <option>일어</option>
                                        <option>기타 외국어</option>
                                        -->
                                        <?php echo conv_selected_option($language_select, ''); ?>
                                    </select>
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="btnWrap">
                <!--
                <button class="bigBtn mt_30 mb_100" onClick="location.href='voice_list.html'"> 검색</button>
                <button class="bigBtn mt_30 mb_100" onClick="location.href='./voiceList.php'"> 검색</button>
                -->
                <button type="submit" class="bigBtn mt_30 mb_100"> 검색</button>
            </div>
        </form>
    </main>

    <div class="quicMenu">
        <!--
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
        -->

        <!--
        <button class="top" onClick="scrollToTop()">
            <img src="../theme/basic/images/button_a.png" srcset="../theme/basic/images/button_a.png 1x, ../theme/basic/images/button_a@2x.png 2x">
        </button>

        <button class="back">
            <img src="../theme/basic/images/button_arrow_back.png" srcset="../theme/basic/images/button_arrow_back.png 1x, ../theme/basic/images/button_arrow_back@2x.png 2x">
        </button>

        <button class="gokakao">
            <img src="../theme/basic/images/button_kakao_1.png" srcset="../theme/basic/images/button_kakao_1.png 1x, ../theme/basic/images/button_kakao_1@2x.png 2x">
        </button>
        -->
    </div>
</div>
</body>

<script type="text/javascript" src="<?php echo G5_JS_URL; ?>/js/jquery-3.4.1.js"></script>
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script src="<?php echo G5_JS_URL; ?>/slick.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo G5_JS_URL; ?>/allvoice.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">

</script>



