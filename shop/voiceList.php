<?php
include_once('./_common.php');


if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH . '/voiceList.php');
    return;
}

$page_rows = 10;
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
if ($page < 1) {
    $page = 1;
} // 페이지가 없으면 첫 페이지 (1 페이지)
$_REQUEST['orderby'] = isset($_REQUEST['orderby']) ? $_REQUEST['orderby'] : "a.mv_no";
$_REQUEST['cat'] = isset($_REQUEST['cat']) ? $_REQUEST['cat'] : "10";

include_once('./_head.php');

$qstr = "cat=" . $_REQUEST['cat'];
$qstr2 = "";
$qstr3 = "&orderby=" . $_REQUEST['orderby'];
$sub_where = "";

$_REQUEST['gen'] = isset($_REQUEST['gen']) ? $_REQUEST['gen'] : "";
if ($_REQUEST['gen'] != "") {
    $qstr2 .= "&gen=" . $_REQUEST['gen'];
    $sub_where .= " AND a.mv_gen='" . $_REQUEST['gen'] . "' ";
}
$_REQUEST['age'] = isset($_REQUEST['age']) ? $_REQUEST['age'] : "";
if ($_REQUEST['age'] != "") {
    $qstr2 .= "&age=" . $_REQUEST['age'];
    $sub_where .= " AND a.mv_age='" . $_REQUEST['age'] . "' ";
}
$_REQUEST['sty'] = isset($_REQUEST['sty']) ? $_REQUEST['sty'] : "";
if ($_REQUEST['sty'] != "") {
    $qstr2 .= "&sty=" . $_REQUEST['sty'];
    $sub_where .= " AND a.mv_sty='" . $_REQUEST['sty'] . "' ";
}
$_REQUEST['ton'] = isset($_REQUEST['ton']) ? $_REQUEST['ton'] : "";
if ($_REQUEST['ton'] != "") {
    $qstr2 .= "&ton=" . $_REQUEST['ton'];
    $sub_where .= " AND a.mv_ton='" . $_REQUEST['ton'] . "' ";
}
$_REQUEST['lan'] = isset($_REQUEST['lan']) ? $_REQUEST['lan'] : "";
if ($_REQUEST['lan'] != "") {
    $qstr2 .= "&lan=" . $_REQUEST['lan'];
    $sub_where .= " AND a.mv_lan='" . $_REQUEST['lan'] . "' ";
}

$sql = " SELECT * FROM " . $g5['g5_shop_category_table'] . " WHERE ca_id='" . $_REQUEST['cat'] . "' ";
$cat_dt = sql_fetch($sql);

// $qry = "SELECT count(*) as cnt FROM ".$g5['member_voice']." a JOIN ".$g5['member_table']." b ON a.mb_id=b.mb_id WHERE a.mv_cat='".$_REQUEST['cat']."' ".$sub_where." ";
$qry = "select count(*) as rows from (SELECT count(*) as cnt FROM g5_member_voice a JOIN g5_member b ON a.mb_id=b.mb_id where a.mv_cat = '" . $_REQUEST['cat'] . "' " . $sub_where . " AND b.mb_gubun = '3' group by a.mb_id) as c";
$tot_dt = sql_fetch($qry);
$total_count = $tot_dt['rows'];
$total_page = ceil($total_count / $page_rows);  // 전체 페이지 계산
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함
//echo $qry;
// $qry = "SELECT a.*, b.mb_name, b.it_use_avg, c.cnt FROM ".$g5['member_voice']." a JOIN ".$g5['member_table']." b ON a.mb_id=b.mb_id LEFT JOIN ( SELECT COUNT(*) cnt, mb_id FROM g5_shop_order WHERE od_status IN ('작업진행중','작업완료') GROUP BY mb_id ) c ON a.mb_id=c.mb_id WHERE a.mv_cat='".$_REQUEST['cat']."' ".$sub_where." ORDER BY  ".$_REQUEST['orderby']." DESC, a.mb_id ASC, a.mv_no ASC LIMIT ".$from_record.", ".$page_rows." ";
$qry = "SELECT a.*, b.mb_name, b.it_use_avg, c.cnt FROM " . $g5['member_voice'] . " a 
        JOIN " . $g5['member_table'] . " b ON a.mb_id=b.mb_id 
        inner join ( select MAX(mv_no) as max_mv_no FROM g5_member_voice where mv_cat = '" . $_REQUEST['cat'] . "' GROUP BY mb_id) as d on a.mv_no = d.max_mv_no
        LEFT JOIN ( SELECT COUNT(*) cnt, mb_id FROM g5_shop_order WHERE od_status IN ('작업진행중','작업완료') GROUP BY mb_id ) c ON a.mb_id=c.mb_id 
        WHERE a.mv_cat='" . $_REQUEST['cat'] . "' " . $sub_where . "  AND b.mb_gubun = '3' group by a.mb_id ORDER BY  " . $_REQUEST['orderby'] . " DESC, a.mb_id ASC, a.mv_no ASC LIMIT " . $from_record . ", " . $page_rows . " ";
//echo $qry;
$res = sql_query($qry);
$row_cnt = sql_num_rows($res);
//$dt = NULL;

?>

    <!-- 성우리스트 { -->


    <div class="listWrap">
        <div class="listCont">
            <div class="listInfo">
                <div class="listLocation">
                    <ul>
                        <li><img src="../theme/basic/img/img_home.png"/></li>
                        <li>협회성우 > <?php echo $cat_dt['ca_name']; ?></li>
                        <!--li>카테고리명01</li-->
                    </ul>
                </div>
                <div class="listOrder">
                    <ul>
                        <li><a href="javascript:location.href='<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $qstr . $qstr2; ?>&orderby=a.mv_no';" <?php echo ($_REQUEST['orderby'] == "a.mv_no") ? "class='on'" : ""; ?>>최신순</a></li>
                        <li><a href="javascript:location.href='<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $qstr . $qstr2; ?>&orderby=b.it_use_cnt';" <?php echo ($_REQUEST['orderby'] == "b.it_use_cnt") ? "class='on'" : ""; ?>>후기많은순</a></li>
                        <li><a href="javascript:location.href='<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $qstr . $qstr2; ?>&orderby=b.it_use_avg';" <?php echo ($_REQUEST['orderby'] == "b.it_use_avg") ? "class='on'" : ""; ?>>평점높은순</a></li>
                        <li><a href="javascript:location.href='<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $qstr . $qstr2; ?>&orderby=c.cnt';" <?php echo ($_REQUEST['orderby'] == "c.cnt") ? "class='on'" : ""; ?>>판매많은순</a></li>
                    </ul>
                </div>
            </div>


            <ul class="listData2">
                <?php
                for ($i = 0; $row = sql_fetch_array($res); $i++) {
                    $mb_dir = substr($row['mb_id'], 0, 2);
                    $icon_url = G5_DATA_URL . '/member_image/' . $mb_dir . '/' . $row['mb_id'] . '.gif';
                    $icon_url = is_file(G5_DATA_PATH . '/member_image/' . $mb_dir . '/' . $row['mb_id'] . '.gif') ? $icon_url : "/theme/basic/img/profileSample.jpg";
                    $audio_url = G5_DATA_URL . '/member_voice/' . $mb_dir . '/' . $row['mv_voice'];
                    ?>
                    <li>
                        <a href="/shop/voiceDetail.php?cat=<?php echo $_REQUEST['cat']; ?>&mb_id=<?php echo $row['mb_id']; ?>">
                            <img src="<?php echo $icon_url; ?>"/>
                        </a>
                        <div>
                            <strong><?php echo $row['mb_name']; ?> (<?php echo $row['mb_id']; ?>)</strong>
                            <img src="img/s_star<?php echo $row['it_use_avg'] <= 0 ? "1" : intval($row['it_use_avg']); ?>.png"/> <!-- 1~5 -->
                            <a href="./inboxMessage.php?me_recv_mb_id=<?php echo $row['mb_id']; ?>"><span>1:1 채팅</span></a>
                            <a href="javacript:" onclick="requestRecording('<?php echo $row['mb_id']; ?>');" class="sendAgree">녹음 의뢰</a>
                            <div class="tagPlayer">
                                <div>
                                    <strong><?php echo $row['mv_title']; ?></strong>
                                    <span><?php echo $gender_arr[$row['mv_gen']]; ?></span>
                                    <span><?php echo $age_arr[$row['mv_age']]; ?></span>
                                    <span><?php echo $style_arr[$row['mv_sty']]; ?></span>
                                    <span><?php echo $tone_arr[$row['mv_ton']]; ?></span>
                                    <span><?php echo $language_arr[$row['mv_lan']]; ?></span>
                                </div>
                                <div class="audioPlayer" id="player01">
                                    <audio controls src="<?php echo $audio_url; ?>"></audio>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php
                }
                ?>

            </ul>
            <script type="text/javascript">
                $(function () {
                    //var h = '<audio controls src="../theme/basic/img/audio-test-01.mp3"></audio>'
                    //$('.audioPlayer').html(h);
                    maudio({
                        obj: 'audio',
                        fastStep: 10
                    });
                    $(".progress-bar").width('400px');
                });
            </script>

            <?php echo get_paging($page_rows, $page, $total_page, $_SERVER['SCRIPT_NAME'] . '?' . $qstr . $qstr2 . $qstr3 . '&amp;page='); ?>
        </div>

        <div class="detailSearch">
            <strong>원하는 목소리를 찾아보세요</strong>
            <em></em>
            <p>샘플 음성을 들어보시고 <br/>원하는 목소리 성우의 사진을 클릭하시면<br/>직접 작업의뢰가 가능합니다.</p>
            <div>
			<span class="slcWrap">
				<select name="gen" id="gen">
					<option value="">Gender</option>
					<?php echo conv_selected_option($gender_select, $_REQUEST['gen']); ?>
				</select>
			</span>
                <span class="slcWrap">
				<select name="age" id="age">
					<option value="">Age</option>
					<?php echo conv_selected_option($age_select, $_REQUEST['age']); ?>
				</select>
			</span>
                <span class="slcWrap">
				<select name="sty" id="sty">
					<option value="">Style</option>
					<?php echo conv_selected_option($style_select, $_REQUEST['sty']); ?>
				</select>
			</span>
                <span class="slcWrap">
				<select name="ton" id="ton">
					<option value="">Tone</option>
					<?php echo conv_selected_option($tone_select, $_REQUEST['ton']); ?>
				</select>
			</span>
                <span class="slcWrap">
				<select name="lan" id="lan">
					<option value="">Language</option>
					<?php echo conv_selected_option($language_select, $_REQUEST['lan']); ?>
				</select>
			</span>
            </div>
            <hr/>
            <a id="search_btn" style="cursor:pointer;">Search</a>
        </div>
    </div>

    <!-- 바로 문의하기 시작 -->
    <div id="orderPopupCover"></div>
    <div id="orderPopup">
        <form id="fitemform" name="fitemform" action="./voiceDetail_update.php" method="post" enctype="MULTIPART/FORM-DATA" autocomplete="off">
            <input type="hidden" name="cat" value="<?php echo $_REQUEST['cat']; ?>">
            <input type="hidden" id = "form_mb_id" name="mb_id" value="<?php echo $_REQUEST['mb_id']; ?>">
            <div class="orderForm">
                <strong>바로 문의하기</strong>
                <ul>
                    <li class="full"><span>*제목</span><input type="text" id="it_name" name="it_name" value=""/></li>
                    <li class="full"><span>*설명</span><textarea rows="3" id="it_explan" name="it_explan"></textarea></li>
                    <li class="full">
                        <span style="line-height:30px;padding-top:15px;">*대본<br/>(스크립트)</span><textarea rows="7" id="it_explan2" name="it_explan2" style="height:169px;" placeholder="최종 완성된 대본을 직접 입력하시거나 파일로 첨부해주세요."></textarea>
                    </li>
                    <li class="full">
                        <span>&nbsp;</span>
                        <div class="fakeFile">
                            <input type="text" id="it_7_name" value=""/>
                            <div><input type="file" id="it_7" name="it_7"/></div>
                        </div>
                    </li>
                    <li><span>*마감시한</span><input type="text" id="it_view_time" name="it_view_time" data-language='ko' readOnly/><em class="xi-calendar-check"></em></li>
                </ul>
                <ul>
                    <li>
                        <span>*카테고리</span>
                        <span class="slcWrap">
					<select id="ca_id" name="ca_id">
						<option value="">1차 카테고리(선택)</option>
						<?php echo conv_selected_option($category_select, ''); ?>
					</select>
				</span>
                    </li>
                    <li>
                        <span>*예산</span>
                        <input type="text" id="it_price" name="it_price" numberOnly value=""/><i>※ 최저가격 <span id="ch_pr"></span>원 이상으로 작성해주세요</i><i style="padding-left:16px;text-indent:-16px;letter-spacing:-0.5px;">※ 광고 작업의 경우 공중파 광고는 기본금액 25만원 이상으로 <br/>적어주시기 바랍니다</i>
                    </li>
                    <li>
                        <span>스타일</span>
                        <span class="slcWrap">
					<select id="it_3" name="it_3">
						<option value="">스타일(선택)</option>
						<?php echo conv_selected_option($style_select, ''); ?>
					</select>
				</span>
                    </li>
                    <li>
                        <span>톤</span>
                        <span class="slcWrap">
					<select id="it_4" name="it_4">
						<option value="">톤(선택)</option>
						<?php echo conv_selected_option($tone_select, ''); ?>
					</select>
				</span>
                    </li>
                    <li>
                        <span>연령</span>
                        <span class="slcWrap">
					<select id="it_2" name="it_2">
						<option value="">연령(선택)</option>
						<?php echo conv_selected_option($age_select, ''); ?>
					</select>
				</span>
                    </li>
                    <li>
                        <span>언어</span>
                        <span class="slcWrap">
					<select id="it_5" name="it_5">
						<option value="">언어(선택)</option>
						<?php echo conv_selected_option($language_select, ''); ?>
					</select>
				</span>
                    </li>
                    <li>
                        <span>성별</span>
                        <span class="slcWrap">
					<select id="it_1" name="it_1">
						<option value="">성별(선택)</option>
						<?php echo conv_selected_option($gender_select, ''); ?>
					</select>
				</span>
                    </li>
                </ul>
                <div class="ctrler">
                    <a id="submit_btn" class="vSave" style="cursor:pointer;">확인</a>
                    <a href="javascript:;" class="vCancel">취소</a>
                </div>
                <a href="javascript:;">Ⅹ</a>
            </div>
        </form>
    </div>
    <!-- 바로 문의하기 끝 -->

    <script type="text/javascript">
        $(document).ready(function () {
            $("#search_btn").click(function () {
                location.href = "<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $qstr . $qstr3; ?>&gen=" + $("#gen").val() + "&age=" + $("#age").val() + "&sty=" + $("#sty").val() + "&ton=" + $("#ton").val() + "&lan=" + $("#lan").val() + "";
            });
        });

        function requestRecording(mb_id) {

            console.log(mb_id);
            $("#form_mb_id").val(mb_id);
            <?php
            if ($member['mb_order_block_yn'] == '1') {

                echo "alert('문의가 제한된 회원입니다.\\n올보이스 고객센터로 문의해 주세요.');";
                echo "return;";
            }

            if ( $member['mb_gubun'] == "1" || $member['mb_gubun'] == "2" ) {
            ?>
            $("#orderPopupCover").show();
            $("#orderPopup").show();
            <?php
            }
            else {
                echo "alert('일반회원만 이용 가능합니다.');";
                echo "location.href = '../bbs/login.php';";
            }
            ?>
        }

        $(".orderForm > a, .vCancel").click(function () {
            $("#orderPopupCover").hide();
            $("#orderPopup").hide();

            $("#ncOrderPopupCover").hide();
            $("#ncOrderPopup").hide();
        });

        $.fn.datepicker.language['ko'] = {
            days: ['일', '월', '화', '수', '목', '금', '토'],
            daysShort: ['일', '월', '화', '수', '목', '금', '토'],
            daysMin: ['일', '월', '화', '수', '목', '금', '토'],
            months: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            monthsShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            dateFormat: 'yyyy-mm-dd'
        };

        //Initialization
        $('#it_view_time').datepicker({
            language: 'ko',
            //timepicker: true,
            onSelect: function (fd, d, picker) {
                var thisMonth = $('#it_view_time').val().split('-');
                var thisDate = thisMonth[2];
                thisDate = parseInt(thisDate);
                thisMonth = thisMonth[1];
                thisMonth = parseInt(thisMonth);
                var crntDate = new Date();
                var crntMonth = crntDate.getMonth();
                var crntDate = crntDate.getDate();
                console.log(thisMonth + " / " + crntMonth);
                if (thisMonth > crntMonth) {
                    if ((thisMonth - crntMonth) > 3) {
                        if ((thisMonth - crntMonth) == 4 && thisDate <= crntDate) {
                        } else {
                            alert("마감시간은 최대 3개월 후 입니다.");
                            endDatePicker.clear();
                        }
                    }
                } else {
                    if ((thisMonth - crntMonth) > -9) {
                        if ((thisMonth - crntMonth) == -10 && thisDate <= crntDate) {
                        } else {
                            alert("마감시간은 최대 3개월 후 입니다.");
                            endDatePicker.clear();
                        }
                    }
                }
            }
        });

        $("#submit_btn").click(function () {
            if ($("#it_name").val() == "") {
                alert("제목을 입력해 주세요.");
                $("#it_name").focus();
                return;
            }
            if ($("#it_explan").val() == "") {
                alert("설명을 입력해 주세요.");
                $("#it_explan").focus();
                return;
            }
            /*
            if ( $("#it_explan2").val() == "" ) {
                alert("대본샘플을 입력해 주세요.");
                $("#it_explan2").focus();
                return;
            }
            */
            if ($("#it_6").val() == "") {
                alert("대본분량을 입력해 주세요.");
                $("#it_6").focus();
                return;
            }
            if ($("#ca_id").val() == "") {
                alert("카테고리를 선택해 주세요.");
                $("#ca_id").focus();
                return;
            }
            if ($("#it_price").val() == "") {
                alert("예산을 입력해 주세요.");
                $("#it_price").focus();
                return;
            }
            /*if ( $("#it_price").val() < dt[$("#ca_id").val()] ) {
                alert("예산을 "+number_format(dt[$("#ca_id").val()])+"원 이상으로 입력해 주세요.");
                $("#it_price").focus();
                return;
            }*/
            if ($("#it_view_time").val() == "") {
                alert("노출기간을 입력해 주세요.");
                $("#it_view_time").focus();
                return;
            }

            $("#fitemform").submit();
        });
    </script>
    <!-- } 성우리스트 끝 -->

<?php
include_once("./_tail.php");
?>