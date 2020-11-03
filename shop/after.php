<?php
include_once('./_common.php');


if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH . '/after.php');
    return;
}

include_once('./_head.php');

// 분류리스트
$category_select = '';
$script = '';
$sql = " select * from {$g5['g5_shop_category_table']} ";
//if ($is_admin != 'super')
//    $sql .= " where ca_mb_id = '{$member['mb_id']}' ";
$sql .= " order by ca_order, ca_id ";
$result = sql_query($sql);
for ($i = 0; $row = sql_fetch_array($result); $i++) {
    $len = strlen($row['ca_id']) / 2 - 1;

    $nbsp = "";
    for ($i = 0; $i < $len; $i++)
        $nbsp .= "&nbsp;&nbsp;&nbsp;";

    $category_select .= "<option value=\"{$row['ca_id']}\">$nbsp{$row['ca_name']}</option>\n";

}
?>

    <!-- 성우상세 { -->
    <div class="contTop" style="opacity:0;">
        <strong>보이스매칭(VM. Voice Matching) 프로그램 신청</strong>
        <hr/>
        <span>크리에이터, 캐릭터 등 보이스가 지속적으로 필요한 모든 콘텐츠에 프로성우를 매칭시켜드립니다.<br/><br/>
            내가 원하는 목소리의 성우와 지속적인 작업진행을 보장하여<br/> 합리적인 성우료와 원하는 컨셉의 더빙이 가능하도록 합니다.</span>
    </div>

    <script type="text/javascript">
        $(function () {
            $("#contentsWrap > div").before("<div class='contTop2'>" + $(".contTop").html() + "</div>");
            $(".contTop").remove();
        });
    </script>

    <div class="voiceDetail">
        <div class="voiceDetailInfo">
            <form id="fitemform" name="fitemform" action="mailSend.php" method="post" enctype="MULTIPART/FORM-DATA" autocomplete="off">
                <div class="voiceSampleSection form">
                    <strong>보이스매칭 프로그램 신청하기</strong>
                    <ul>
                        <li>
                            <!-- 					<strong>샘플음성 01</strong> -->
                            <ul>
                                <li><span>채널URL</span><input type="text" id="it_name" name="it_name" value=""/></li>
                                <li><span>연락처 (필수)</span><input type="text" id="it_phone" name="it_phone" value=""/></li>
                                <li><span style="padding:5px 0;">예상 성우료</span><input type="text" id="it_purpose" name="it_purpose" value=""/></li>
                                <li><span>신청내용</span><textarea type="text" id="it_request_form" name="it_request_form" value=""/></textarea></li>
                            </ul>
                        </li>

                    </ul>
                    <script type="text/javascript">
                        $(function () {

                            $("#submit_btn").click(function () {

                                if ($("#it_phone").val() == "") {
                                    alert("연락처를 입력해 주세요.");
                                    $("#it_explan").focus();
                                    return;
                                }

                                $("#fitemform").submit();
                            });

                        });
                    </script>
                </div>
                <div class="ctrler">
                    <a id="submit_btn" class="vSave" style="cursor:pointer;">신청하기</a>
                    <!-- 			<a href="javascript:;" class="vCancel">취소</a> -->
                </div>
            </form>
        </div>

        <div class="voiceProfile">
            <article>
                <span>어떻게 진행하는지 궁금한가요?</span>
                <strong>보이스매칭 프로그램 프로세스</strong>
                <ol>
                    <li>01. 보이스매칭 프로그램 신청</li>
                    <li style="padding-left:23px;">아래의 양식에 맞추어 보이스매칭 프로그램을 의뢰합니다.</li>
                    <li>02. 사전 협의</li>
                    <li style="padding-left:23px;">담당자가 연락을 드려서 사전 미팅을 진행합니다.</li>
                    <li>03. 성우 오디션</li>
                    <li style="padding-left:23px;">해당 채널 컨셉에 맞는 성우 오디션을 진행합니다.</li>
                    <li>04. 더빙 작업</li>
                    <li style="padding-left:23px;">매칭된 성우와 함께 더빙 작업이 시작됩니다.</li>
                </ol>
                <br/><br/>
            </article>
        </div>
    </div>


    <!-- } 성우상세 끝 -->

<?php
include_once("./_tail.php");
?>