<?php
include_once('./_common.php');


if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH . '/voiceDetail.php');
    return;
}

include_once('./_head.php');

$sql = " select * from {$g5['g5_shop_category_table']} ";
//if ($is_admin != 'super')
//    $sql .= " where ca_mb_id = '{$member['mb_id']}' ";
$sql .= " order by ca_order, ca_id ";
$result = sql_query($sql);
$dt = NULL;
for ($i = 0; $row = sql_fetch_array($result); $i++) {
    $dt[$row['ca_id']] = $row['ca_1'];
    $category_arr[$row['ca_id']] = $row['ca_name'];
}

if ($_REQUEST['mb_id']) {
    $where = " WHERE mb_id='" . $_REQUEST['mb_id'] . "' ";
} else {
    $where = " WHERE mb_no='" . $_REQUEST['it_id'] . "' ";
}

$sql = "SELECT * FROM " . $g5['member_table'] . " " . $where . " ";
$mem_dt = sql_fetch($sql);

$_REQUEST['mb_id'] = $mem_dt['mb_id'];

$row = sql_fetch("SELECT b.* FROM " . $g5['g5_shop_cart_table'] . " AS a JOIN " . $g5['g5_shop_item_table'] . " AS b ON a.it_id=b.it_id JOIN " . $g5['g5_shop_order_table'] . " AS c ON a.od_id=c.od_id WHERE b.it_maker='" . $member['mb_id'] . "' AND b.it_origin='" . $_REQUEST['mb_id'] . "' AND c.od_status IN ('작업진행중') ");
//print_r($row);
if ($row['it_id']) {
    $bizId = "allvoice";
    $mmdd = date("md");
    $secure = "67aec2b09241800da27133ea01d58a4d676034feb3a0c0a4dd2f907458c26c74";
    $secureCode = hash("sha256", $bizId . $mmdd . $secure);
    //echo $secureCode;
    $s_url = "https://bizapi.callmix.co.kr/biz050/BZV100?secureCode=" . $secureCode . "&bizId=" . $bizId . "&monthDay=" . $mmdd . "&selGbn=3&reqCnt=1";
    //echo $s_url;
    //$vno_str = file_get_contents($s_url);
    if (function_exists('curl_init')) {
        // curl 리소스를 초기화
        $ch = curl_init();

        // url을 설정
        curl_setopt($ch, CURLOPT_URL, $s_url);

        // 헤더는 제외하고 content 만 받음
        curl_setopt($ch, CURLOPT_HEADER, 0);

        // 응답 값을 브라우저에 표시하지 말고 값을 리턴
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // 브라우저처럼 보이기 위해 user agent 사용
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0');

        $vno_str = curl_exec($ch);

        // 리소스 해제를 위해 세션 연결 닫음
        curl_close($ch);
    } else {
        // curl 라이브러리가 설치 되지 않음. 다른 방법 알아볼 것
    }
    $vno_arr = json_decode($vno_str);
    //echo $vno_str;
    //print_r($vno_arr->vnList);
    if ($vno_arr->resCd == "SUCCESS") {
        $vno = $vno_arr->vnList[0]->vn;
        //echo "<br>vn = ".$vno_arr->vnList[0]->vn."<br>";
        //https://bizapi.callmix.co.kr/biz050/BZV210?secureCode= 378767ad6a190b3ea595225a0f52109d6c15c72df9b4ceba55bf4fbb8bf936e1&bizId=aaa&mo nthDay=0519&tkGbn=1&rn=021231234&vn=05041231234&brNm=맛있는치킨
        $s2_url = "https://bizapi.callmix.co.kr/biz050/BZV210?secureCode=" . $secureCode . "&bizId=" . $bizId . "&monthDay=" . $mmdd . "&tkGbn=1&rn=" . str_replace("-", "", $mem_dt['mb_hp']) . "&vn=" . $vno . "&brNm=" . $mem_dt['mb_id'];
        //echo $s2_url;
        if (function_exists('curl_init')) {
            // curl 리소스를 초기화
            $ch = curl_init();

            // url을 설정
            curl_setopt($ch, CURLOPT_URL, $s2_url);

            // 헤더는 제외하고 content 만 받음
            curl_setopt($ch, CURLOPT_HEADER, 0);

            // 응답 값을 브라우저에 표시하지 말고 값을 리턴
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            // 브라우저처럼 보이기 위해 user agent 사용
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0');

            $vno_res_str = curl_exec($ch);

            // 리소스 해제를 위해 세션 연결 닫음
            curl_close($ch);
        }
        $vno_res = json_decode($vno_res_str);
        //print_r($vno_res);print_r($vno);
        if ($vno_res->resCd == "SUCCESS") {
            $vtel = $vno;
        }
    }

}
?>

    <!-- 성우상세 { -->


    <div class="voiceDetail">
        <div class="voiceDetailInfo">
            <div class="voiceDetailSection">
                <div class="voiceDetailTab">
                    <ul>
                        <li class="on"><a href="javascript:;">프로필</a></li>
                        <li><a href="javascript:;">샘플음성</a></li>
                        <li><a href="javascript:;">리뷰</a></li>
                        <li><a href="javascript:;">응원메시지</a></li>
                        <li><a href="javascript:;">취소 및 환불규정</a></li>
                    </ul>
                </div>

                <div class="voiceDetailProfile">
                    <strong><?php echo $mem_dt['mb_title']; ?></strong>
                    <hr>
                    <p>
                        <i>자기소개</i><br/>
                        <?php echo nl2br($mem_dt['mb_profile']); ?><br/><br/>
                        <i>출신극회 및 입시년도</i><br/>
                        <?php echo $mem_dt['mb_9']; ?><br/><br/>
                        <i>녹음장비 및 마이크 모델명</i><br/>
                        <?php echo $mem_dt['mb_10']; ?><br/><br/>
                        <i>주요작품 및 클라이언트</i><br/>
                        <?php echo nl2br($mem_dt['mb_memo']); ?>
                    </p>
                </div>
            </div>

            <div class="voiceDetailSection">
                <div class="voiceDetailTab">
                    <ul>
                        <li><a href="javascript:;">프로필</a></li>
                        <li class="on"><a href="javascript:;">샘플음성</a></li>
                        <li><a href="javascript:;">리뷰</a></li>
                        <li><a href="javascript:;">응원메시지</a></li>
                        <li><a href="javascript:;">취소 및 환불규정</a></li>
                    </ul>
                </div>

                <div class="voiceDetailProfile">
                    <?php
                    $qry = "SELECT * FROM " . $g5['member_voice'] . " WHERE mb_id='" . $_REQUEST['mb_id'] . "' ORDER BY mv_no DESC ";
                    //echo $qry;
                    $res = sql_query($qry);
                    $row_cnt = sql_num_rows($res);
                    for ($i = 0; $row = sql_fetch_array($res); $i++) {
                        $mb_dir = substr($mem_dt['mb_id'], 0, 2);
                        $audio_url = G5_DATA_URL . '/member_voice/' . $mb_dir . '/' . $row['mv_voice'];
                        ?>
                        <div class="tagPlayer">
                            <div>
                                <strong><?php echo $row['mv_title']; ?></strong>
                                <span><?php echo $category_arr[$row['mv_cat']]; ?></span>
                                <span><?php echo $gender_arr[$row['mv_gen']]; ?></span>
                                <span><?php echo $age_arr[$row['mv_age']]; ?></span>
                                <span><?php echo $style_arr[$row['mv_sty']]; ?></span>
                                <span><?php echo $tone_arr[$row['mv_ton']]; ?></span>
                                <span><?php echo $language_arr[$row['mv_lan']]; ?></span>
                            </div>
                            <div>
                                <div class="audioPlayer" id="player01">
                                    <audio controls src="<?php echo $audio_url; ?>"></audio>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                    <script type="text/javascript">
                        $(function () {
                            //var h = '<audio controls src="../theme/basic/img/audio-test-01.mp3"></audio>'
                            //$('.audioPlayer').html(h);
                            maudio({
                                obj: 'audio',
                                fastStep: 10
                            });


                            var dragFlag = false;
                            $(".progress-bar").on("mousedown", function () {
                                dragFlag = true;
                            });

                            $("*").on("mouseup", function () {
                                dragFlag = false;
                            });

                            $(".progress-bar").on("click", function () {
                                dragFlag = false;
                                if (!$(this).parent().parent().hasClass("playing")) $(this).parent().find(".play").click();
                            });

                            $(".progress-bar").on("mousemove", function (event) {
                                var thisBar = $(this);
                                var thisPass = $(this).find(".progress-pass");
                                if (dragFlag) {
                                    thisPass.css({
                                        "width": ((event.pageX - 162) / thisBar.outerWidth() * 100) + "%"
                                    })
                                }
                            });
                        });
                    </script>

                    <!--
                    <table class="voiceSample">
                        <colgroup>
                            <col width="*" />
                            <col width="60" />
                            <col width="65" />
                            <col width="90" />
                            <col width="155" />
                        </colgroup>
                        <thead>
                            <tr>
                                <th>Player</th>
                                <th>Style</th>
                                <th>Age</th>
                                <th>Language</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="../theme/basic/img/img_audioPlay.png" /></td>
                                <td>밝은</td>
                                <td>유아</td>
                                <td>표준어</td>
                                <td><a href="javascript:;">Download</a></td>
                            </tr>
                            <tr>
                                <td colspan="5"></td>
                            </tr>
                            <tr>
                                <td><img src="../theme/basic/img/img_audioPlay.png" /></td>
                                <td>밝은</td>
                                <td>유아</td>
                                <td>표준어</td>
                                <td><a href="javascript:;">Download</a></td>
                            </tr>
                            <tr>
                                <td colspan="5"></td>
                            </tr>
                            <tr>
                                <td><img src="../theme/basic/img/img_audioPlay.png" /></td>
                                <td>밝은</td>
                                <td>유아</td>
                                <td>표준어</td>
                                <td><a href="javascript:;">Download</a></td>
                            </tr>
                            <tr>
                                <td colspan="5"></td>
                            </tr>
                            <tr>
                                <td><img src="../theme/basic/img/img_audioPlay.png" /></td>
                                <td>밝은</td>
                                <td>유아</td>
                                <td>표준어</td>
                                <td><a href="javascript:;">Download</a></td>
                            </tr>
                            <tr>
                                <td colspan="5"></td>
                            </tr>
                        </tbody>
                    </table>
                    -->
                    <!--
                    <div class="btnGetAgree">
                        <a href="javascript:;">합의 주문하기</a>
                    </div>
                     -->
                </div>
            </div>


            <div id="voiceDetailSection1" class="voiceDetailSection">
                <div class="voiceDetailTab">
                    <ul>
                        <li><a href="javascript:;">프로필</a></li>
                        <li><a href="javascript:;">샘플음성</a></li>
                        <li class="on"><a href="javascript:;">리뷰</a></li>
                        <li><a href="javascript:;">응원메시지</a></li>
                        <li><a href="javascript:;">취소 및 환불규정</a></li>
                    </ul>
                </div>
                <?php
                $it_id = $mem_dt['mb_no'];
                ?>
                <div>
                    <div id="itemuse"><?php include_once(G5_SHOP_PATH . '/itemuse.php'); ?></div>

                    <!--div class="voiceLv">
    				<strong>고객평점</strong>
    				<em class="star02"></em>
    				<span>120개의 평가</span>
    			</div>
    			
    			
    			<div class="tableSet01">
    				<table>
    					<colgroup>
    						<col width="170" />
    						<col width="*" />
    						<col width="170" />
    						<col width="170" />
    					</colgroup>
    					<thead>
    						<tr>
    							<th>평점</th>
    							<th>제목</th>
    							<th>작성일</th>
    							<th>작성자</th>
    						</tr>
    					</thead>
    					<tbody>
    						<tr>
    							<td><em class="star03"></em></td>
    							<td><a href="javascript:;">너무 만족스럽습니다.</a></td>
    							<td>19-01-10</td>
    							<td>홍길동</td>
    						</tr>
    						<tr>
    							<td><em class="star03"></em></td>
    							<td><a href="javascript:;">너무 만족스럽습니다.</a></td>
    							<td>19-01-10</td>
    							<td>홍길동</td>
    						</tr>
    						<tr>
    							<td><em class="star03"></em></td>
    							<td><a href="javascript:;">너무 만족스럽습니다.</a></td>
    							<td>19-01-10</td>
    							<td>홍길동</td>
    						</tr>
    						<tr>
    							<td><em class="star03"></em></td>
    							<td><a href="javascript:;">너무 만족스럽습니다.</a></td>
    							<td>19-01-10</td>
    							<td>홍길동</td>
    						</tr>
    						<tr>
    							<td><em class="star03"></em></td>
    							<td><a href="javascript:;">너무 만족스럽습니다.</a></td>
    							<td>19-01-10</td>
    							<td>홍길동</td>
    						</tr>
    					</tbody>
    				</table>
    			</div>
    			
    			<div class="tableWrite">
    				<?php $itemuse_form = "./itemuseform.php?it_id=1553055184"; ?>
    				<a href="<?php echo $itemuse_form; ?>" class="reviewTable">구매 후기 작성</a>
    			</div>
    			
    			<div class="ttrxPaging">
        			<a href="javascript:;"><img src="../theme/basic/img/btn_listPrev.png" /></a>
        			<ul>
        				<li><a href="javascript:;">1</a></li>
        				<li><a href="javascript:;">2</a></li>
        				<li><a href="javascript:;">3</a></li>
        				<li><a href="javascript:;">4</a></li>
        				<li><a href="javascript:;">5</a></li>
        				<li><a href="javascript:;">6</a></li>
        				<li><a href="javascript:;">7</a></li>
        				<li><a href="javascript:;">8</a></li>
        				<li><a href="javascript:;">9</a></li>
        				<li><a href="javascript:;">10</a></li>
        			</ul>
        			<a href="javascript:;"><img src="../theme/basic/img/btn_listNext.png" /></a>
        		</div-->
                </div>

            </div>

            <div id="voiceDetailSection2" class="voiceDetailSection">
                <div class="voiceDetailTab">
                    <ul>
                        <li><a href="javascript:;">프로필</a></li>
                        <li><a href="javascript:;">샘플음성</a></li>
                        <li><a href="javascript:;">리뷰</a></li>
                        <li class="on"><a href="javascript:;">응원메시지</a></li>
                        <li><a href="javascript:;">취소 및 환불규정</a></li>
                    </ul>
                </div>

                <div>
                    <div id="itemqa"><?php include_once(G5_SHOP_PATH . '/itemqa.php'); ?></div>

                    <!--div class="tableSet01">
                        <table>
                            <colgroup>
                                <col width="*" />
                                <col width="170" />
                                <col width="170" />
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>제목</th>
                                    <th>작성일</th>
                                    <th>작성자</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href="javascript:;">이용신 성우님! 응원합니다.</a></td>
                                    <td>19-01-10</td>
                                    <td>홍길동</td>
                                </tr>
                                <tr>
                                    <td><a href="javascript:;">이용신 성우님! 응원합니다.</a></td>
                                    <td>19-01-10</td>
                                    <td>홍길동</td>
                                </tr>
                                <tr>
                                    <td><a href="javascript:;">이용신 성우님! 응원합니다.</a></td>
                                    <td>19-01-10</td>
                                    <td>홍길동</td>
                                </tr>
                                <tr>
                                    <td><a href="javascript:;">이용신 성우님! 응원합니다.</a></td>
                                    <td>19-01-10</td>
                                    <td>홍길동</td>
                                </tr>
                                <tr>
                                    <td><a href="javascript:;">이용신 성우님! 응원합니다.</a></td>
                                    <td>19-01-10</td>
                                    <td>홍길동</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="tableWrite">
                        <a href="/bbs/memo_form.php" class="newMassage">메시지 작성</a>
                    </div>

                    <div class="ttrxPaging">
                        <a href="javascript:;"><img src="../theme/basic/img/btn_listPrev.png" /></a>
                        <ul>
                            <li><a href="javascript:;">1</a></li>
                            <li><a href="javascript:;">2</a></li>
                            <li><a href="javascript:;">3</a></li>
                            <li><a href="javascript:;">4</a></li>
                            <li><a href="javascript:;">5</a></li>
                            <li><a href="javascript:;">6</a></li>
                            <li><a href="javascript:;">7</a></li>
                            <li><a href="javascript:;">8</a></li>
                            <li><a href="javascript:;">9</a></li>
                            <li><a href="javascript:;">10</a></li>
                        </ul>
                        <a href="javascript:;"><img src="../theme/basic/img/btn_listNext.png" /></a>
                    </div-->
                </div>

            </div>

            <div class="voiceDetailSection">
                <div class="voiceDetailTab">
                    <ul>
                        <li><a href="javascript:;">프로필</a></li>
                        <li><a href="javascript:;">샘플음성</a></li>
                        <li><a href="javascript:;">리뷰</a></li>
                        <li><a href="javascript:;">응원메시지</a></li>
                        <li class="on"><a href="javascript:;">취소 및 환불규정</a></li>
                    </ul>
                </div>

                <div class="voiceDetailProfile">
                    <?php echo $default['de_change_content']; ?>
                </div>
            </div>
        </div>
        <?php
        $mb_dir = substr($mem_dt['mb_id'], 0, 2);
        $icon_url = G5_DATA_URL . '/member_image/' . $mb_dir . '/' . $mem_dt['mb_id'] . '.gif';
        $icon_url = is_file(G5_DATA_PATH . '/member_image/' . $mb_dir . '/' . $mem_dt['mb_id'] . '.gif') ? $icon_url : "../theme/basic/img/profileSample.jpg";
        $gen_img_url = $mem_dt['mb_sex'] == "m" ? "../theme/basic/img/img_male.png" : "../theme/basic/img/img_female.png";
        ?>
        <div class="voiceProfile">
            <div>
                <img src="<?php echo $icon_url; ?>"/>
                <img src="<?php echo $gen_img_url; ?>"/>
                <strong><?php echo $mem_dt['mb_name']; ?>(<?php echo $mem_dt['mb_id']; ?>)</strong>
                <i class="status01"><?php echo ($mem_dt['mb_state'] == 2) ? "부재중" : "작업가능"; ?></i>
                <b>연락 가능 시간<span><?php echo $mem_dt['mb_8']; ?></span></b>
                <span><img src="../theme/basic/img/bg_call.png"/><?php echo $vtel ? $vtel : "(결제 후 통화가능)"; ?></span>
                <div>
                    <b>리뷰 평점</b>
                    <img src="img/s_star<?php echo $mem_dt['it_use_avg'] <= 0 ? "5" : intval($mem_dt['it_use_avg']); ?>.png" width="100"/>
                    <!--em class="star01"></em-->
                </div>
            </div>
            <hr/>
            <!--
            <ul>
                <li><a href="javascript:;"><img src="../theme/basic/img/btn_pSns01.png" /></a></li>
                <li><a href="javascript:;"><img src="../theme/basic/img/btn_pSns02.png" /></a></li>
                <li><a href="javascript:;"><img src="../theme/basic/img/btn_pSns03.png" /></a></li>
                <li><a href="javascript:;"><img src="../theme/basic/img/btn_pSns04.png" /></a></li>
            </ul>
             -->
            <a href="/shop/inboxMessage.php?me_recv_mb_id=<?php echo $mem_dt['mb_id']; ?>" class="askNonPricing">1:1채팅 문의</a>
            <a href="javascript:;" class="sendAgree">녹음 의뢰하기</a>
            <a href="/bbs/memo_form.php?me_recv_mb_id=<?php echo $mem_dt['mb_id']; ?>" class="sendMassage"><img src="../theme/basic/img/btn_pPost.png"/>쪽지보내기</a>
        </div>
    </div>


    <div id="orderPopupCover"></div>
    <div id="orderPopup">
        <form id="fitemform" name="fitemform" action="./voiceDetail_update.php" method="post" enctype="MULTIPART/FORM-DATA" autocomplete="off">
            <input type="hidden" name="cat" value="<?php echo $_REQUEST['cat']; ?>">
            <input type="hidden" name="mb_id" value="<?php echo $_REQUEST['mb_id']; ?>">
            <div class="orderForm">
                <strong>녹음 의뢰하기</strong>
                <ul>
                    <li class="full"><span>*제목</span><input type="text" id="it_name" name="it_name" value=""/></li>
                    <li class="full"><span>*설명</span><textarea rows="3" id="it_explan" name="it_explan"></textarea></li>
                    <li class="full">
                        <span style="line-height:30px;padding-top:15px;">*대본<br/>(스크립트)</span><textarea rows="7" id="it_explan2" name="it_explan2" style="height:169px;" placeholder="최종 완성된 대본을 직접 입력하시거나
파일로 첨부해주세요."></textarea>
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

    <script type="text/javascript">
        var dt = new Array();
        <?php
        foreach ($dt as $key => $val) {
            echo "dt[" . $key . "] = '" . $val . "';\n";
        }
        ?>
        $(function () {
            $(".sendAgree").click(function () {

                <?php
                if ($member['mb_order_block_yn'] == '1') {

                    echo "alert('문의가 제한된 회원입니다.\\n올보이스 고객센터로 문의해 주세요.');";
                    echo "return false;";

                }
                ?>

                alert("비상업용(개인소장)의뢰의 경우, 비상업용 계정에서 의뢰 접수해주시길 바랍니다.");

                <?php
                if ( $member['mb_gubun'] == "1" || $member['mb_gubun'] == "2" ) {
                ?>
                $("#orderPopupCover").show();
                $("#orderPopup").show();
                <?php
                }
                else {
                    echo "alert('일반회원만 이용 가능합니다.');";
                }
                ?>
            });

            $(".askNonPricing").click(function () {

                <?php
                if ($member['mb_order_block_yn'] == '1') {

                    echo "alert('문의가 제한된 회원입니다.\\n올보이스 고객센터로 문의해 주세요.');";
                    echo "return false;";

                }
                ?>

                alert("1:1 채팅 문의는 상업용 문의일때만 이용해 주세요.\n비상업용(개인소장)은 올보이스 카카오 채널로 문의해 주세요.");
            });

            $(".orderForm > a, .vCancel").click(function () {
                $("#orderPopupCover").hide();
                $("#orderPopup").hide();
            });

            $(".voiceDetailTab").each(function () {
                $(this).find("a").each(function (aIdx) {
                    $(this).click(function () {
                        console.log($(".voiceDetailSection").eq(aIdx).offset().top);

                        $("html, body").animate({
                            scrollTop: $(".voiceDetailSection").eq(aIdx).offset().top - 203
                        }, 0);
                    });
                });
            });

            $(".reviewTable").click(function () {
                window.open(this.href, "itemuse_form", "width=810,height=680,scrollbars=1");
                return false;
            });

            $(".sendMassage, .newMassage").click(function () {

                <?php
                if ($member['mb_order_block_yn'] == '1') {

                    echo "alert('쪽지가 제한된 회원입니다.\\n올보이스 고객센터로 문의해 주세요.');";
                    echo "return false;";

                }
                ?>

                alert("쪽지 보내기 서비스는 2020년 7월 31일까지 제공됩니다.\r\n앞으로 1:1 채팅 문의를 이용해 주십시오.");
                window.open(this.href, "itemuse_form", "width=810,height=550,scrollbars=1");
                return false;
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


            // Access instance of plugin
            var endDatePicker = $('#it_view_time').data('datepicker');

            $("#it_7").change(function () {
                $("#it_7_name").val($(this).val());
            });

            $("#ca_id").change(function () {
                $("#ch_pr").text(number_format(dt[$(this).val()]));
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

        });
    </script>


    <!-- } 성우상세 끝 -->

<?php
include_once("./_tail.php");
?>