<?php
include_once('../shop/_common.php');
//include_once('..//_common.php');
include_once('chatMngr.php');
include_once(G5_MSHOP_PATH . '/_head.php');

if ($is_guest)
    alert('회원만 이용하실 수 있습니다.', G5_URL);

$chatroomId = "0";

$chatroomId = $_GET['chatroom_id'];
$toId = $_GET['me_recv_mb_id'];

if (!empty($toId)) {
    $chatManager = new chatMngr();
    $chatroomId = $chatManager->checkChatroomId($toId, $member['mb_id']);
}
?>


<div id="message_m_wrap">
    <div class="message_m_box">
        <!--
        <div class="top_area">
            <p class="title">1:1 메시지</p>
            <p class="text1">내 대화 가능 시간 : 평일 오전 9시 ~ 오후 6시<a href="#none"><img src="../theme/basic/img/mobile/inbox/button_chat_option.png"></a></p>
        </div>
        -->
        <div class="body_area">
            <div class="view_box">
                <div class="user_info">
                    <a href="inbox_room_list.php" class="btn_prev"><img src="../theme/basic/img/mobile/inbox/btn_list.png"></a>
                    <p class="name" id="other_name"></p>
                    <!--
                    <a href="#none" class="favorite on"></a>
                    -->
                </div>
                <div class="popup_message on">
                    <?php if ($member['mb_gubun'] == 3) { ?>
                        <p>성우님! 가격 협의 후 채팅창 옆 ￦ 아이콘을 눌러 <br>바로 결제 요청이 가능합니다.</p>
                        <?php
                    } else { ?>
                        <p>성우료 결제는 안전하고 편리한 올보이스 결제시스템을 이용해주세요.<br> 세금계산서, 현금영수증은 결제페이지에서 신청 가능합니다.</p>
                        <?php
                    }
                    ?>
                </div>
                <div class="chat_box">
                    <div class="chat_area">

                    </div>
                </div>
                <div class="write_wrap">
                    <div class="write_box">
                        <a href="javascript:" class="btn_more" id="btn_expand"></a>
                        <textarea id="inbox_message"></textarea>
                        <a href="javascript:" class="btn_send"><img src="../theme/basic/img/mobile/inbox/btn_send.png" alt="전송"></a>
                    </div>
                    <!--
                    <p class="btn_box" id="btn_list">
                        <a href="#none"><img src="../theme/basic/img/mobile/inbox/icon_photo.png">사진</a>
                        <a href="#none"><img src="../theme/basic/img/mobile/inbox/icon_file.png">파일</a>

                        <a href="javascript:" id="btn_pricing"><img src="../theme/basic/img/mobile/inbox/icon_money.png">거래합의</a>
                    </p>
                    -->
                    <div class="btn_box" id="btn_list">
                        <!--
                        <p>
                            <a href="#none" onclick="document.getElementById('file1').click();"><img src="../theme/basic/img/mobile/inbox/icon_photo.png">사진</a>
                            <input type="file" id="file1" name="file" class="hidden"/>
                        </p>
                        -->
                        <p>
                            <a href="#none" id="btn_file" onclick="document.getElementById('file2').click();"><img src="../theme/basic/img/mobile/inbox/icon_file.png">파일</a>
                            <input type="file" id="file2" name="file" class="hidden"/>
                        </p>
                        <?php if ("3" == $member['mb_gubun']) { ?>
                            <p>
                                <a href="javascript:" id="btn_pricing"><img src="../theme/basic/img/mobile/inbox/icon_money.png">결제요청</a>
                            </p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- //메시지 -->

<!-- 메시지 - 팝업 -->
<div class="message_m_popup_wrap" id="message_m_popup_wrap">
    <div class="popup_box">
        <div class="payment_box">
            <div class="popup_close">
                <a href="javascript:" id="popup_close">X</a>
            </div>
            <p class="text1">결제요청이 보내기</p>
            <table class="tb_m_message">
                <caption>
                    <span>결제요청 정보 테이블입니다.</span>
                </caption>
                <colgroup>
                    <col style="width:10%;"/>
                    <col style="width:45%;"/>
                    <col style="width:45%;"/>
                </colgroup>
                <tbody>
                <tr>
                    <td class="ta_c" rowspan="2">01</td>
                    <td colspan="2"><input type="text" id="payment_title" name="" placeholder="제목을 입력 해 주세요" value=""/></td>
                </tr>
                <tr>
                    <td>
                        <select id="payment_category" name="">
                            <option value="0">분류를 선택하세요</option>
                            <option value="10">광고</option>
                            <option value="11">홍보</option>
                            <option value="12">방송</option>
                            <option value="13">만화</option>
                            <option value="14">게임</option>
                            <option value="15">영화예고</option>
                            <option value="16">이벤트</option>
                            <option value="17">오디오북, 교재</option>
                            <option value="18">기기음성, 성대모사</option>
                            <option value="19">ARS, 안내멘트</option>
                            <option value="20">홈쇼핑</option>
                            <option value="21">비상업용</option>
                        </select>
                    </td>
                    <td class="ta_c"><span>￦</span> <input type="text" id="payment_pricing" name="" placeholder="가격을 입력 해 주세요" value="" class="money"/></td>
                </tr>
                <!--
                <tr>
                    <td colspan="4">
                        <a href="#none" class="btn_add"><img src="../theme/basic/img/mobile/inbox/btn_add_list.png" alt="결제 항목 추가하기"></a>
                    </td>
                </tr>
                -->
                <tr>
                    <td colspan="3" class="total" id="payment_total">합계 : ￦ 0</td>
                </tr>
                </tbody>
            </table>
            <p class="text2"><img src="../theme/basic/img/mobile/inbox/icon_notice.png"> 보내기 전 최종 금액을 확인 후 버튼을 눌러주세요</p>
            <p class="btn3"><a href="javascript:" id="popupPricing"><img src="../theme/basic/img/mobile/inbox/button_03.png" alt="결제요청 보내기"></a></p>
        </div>
    </div>
</div>
<!-- //메시지 - 팝업 -->

<script type="text/javascript">
    $(document).ready(function () {
        console.log("ready!");

        // $("#message_m_popup_wrap").hide();

        let chatroomId = <?php echo $chatroomId ?>;

        $(".chat_area").empty();

        chatManager.queryChatMembers(chatroomId);   //
        chatManager.queryChatLis(chatroomId);
    });

    $("#inbox_message").on('keyup', function() {
        let textEle = $("#inbox_message");
        textEle.css('height', 32);
        let textEleHeight = textEle.prop('scrollHeight');
        textEle.css('height', textEleHeight);

        let test = textEleHeight + 20;
        $(".write_box").css("height", test);

        let offset = $("#inbox_message").offset();
        $('html, body').animate({scrollTop: offset.top}, 0);
    });

    $(function () {
        let idKey = 0;

        // 메세지 전송
        $(".btn_send").click(function () {

            chatManager.write(this, 1, "");

            // clear message
            $("#inbox_message").val("");

            $(".write_box").css("height", 54);
            $("#inbox_message").css("height", 34);
        });

        // <a href="javascript:" class="btn_more on" id="btn_expand"></a>
        $("#btn_expand").click(function () {
            // alert($(this).attr("class"));
            let className = $(this).attr("class");

            if (className === "btn_more") {
                $(this).attr("class", "btn_more on");
                $("#btn_list").attr("class", "btn_box on");

                let offset = $("#btn_file").offset();
                $('html, body').animate({scrollTop: offset.top}, 0);

            } else if (className === "btn_more on") {
                $(this).attr("class", "btn_more");
                $("#btn_list").attr("class", "btn_box");
            }
        });

        $("#file2").change(function () {
            let fileValue = $("#file2").val().split("\\");
            let fileName = fileValue[fileValue.length - 1]; // 파일명
            let size = document.getElementById("file2").files[0].size;
            let mbId = "<?php echo $member['mb_id']; ?>";
            let file = document.getElementById("file2").files[0];
            let formData = new FormData();

            formData.append('mb_id', mbId);

            idKey = addPrgressBar(fileName, idKey);
            let progressBarId = "progressBar" + idKey;
            let opChatId = "opponent_chat" + idKey;

            let sizeM = 1024 * 1024 * 100;

            if (size > sizeM) {

                formData.append('fileToUpload', file);
                //formData.append('filename', fileName);

                let request = new XMLHttpRequest();
                request.open('POST', 'https://file.allvoice.kr/upload.php', true);
                //request.setRequestHeader("Content-Type", "multipart/form-data");
                // request.setRequestHeader("Access-Control-Allow-Origin", "*");

                request.upload.onprogress = function(e)
                {
                    $('#' + progressBarId).attr('value', e.loaded);
                    $('#' + progressBarId).attr('max', e.total);
                    // console.log(e);
                };

                request.onload = function () {
                    console.log("Server responded with2 %o", request.responseText);
                    chatManager.write(this, 5, request.responseText);
                    $('#' + opChatId).remove();
                };

                request.send(formData);
            }
            else {
                formData.append('attachment', file);

                let request = new XMLHttpRequest();
                request.open('POST', '../inbox/inbox_upload.php', true);

                request.upload.onprogress = function(e)
                {
                    $('#' + progressBarId).attr('value', e.loaded);
                    $('#' + progressBarId).attr('max', e.total);
                };

                request.onload = function () {
                    console.log("Server responded with %o", request.responseText);
                    chatManager.write(this, 2, request.responseText);
                    $('#' + opChatId).remove();
                };

                request.send(formData);
            }
        });

        $("#btn_pricing").click(function () {
            //alert($("#message_m_popup_wrap").attr("class"));
            //message_m_popup_wrap
            $("#message_m_popup_wrap").attr("class", "message_m_popup_wrap on");
            // $("tn_list").attr("class", "btn_box on");
            //$(".message_m_popup_wrap").show();
        });

        $("#popup_close").click(function () {
            $("#message_m_popup_wrap").attr("class", "message_m_popup_wrap");
        });


        $("#payment_pricing").on("change keyup paste", function () {
            let dispText = "";
            let pricing = $("#payment_pricing").val();
            pricing = pricing.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            dispText = "합계 : ￦ " + pricing;

            console.log(pricing);

            $("#payment_total").text(dispText);
        });

        $("#popupPricing").click(function () {
            // check data
            let title = $("#payment_title").val();
            let category = $("#payment_category option:selected").val();
            let pricing = $("#payment_pricing").val();

            if (1 > title.length) {
                alert("제목을 입력해주세요.");
                return;
            }

            if (10 > category) {
                alert("분류를 선택해주세요.");
                return;
            }

            if (1 > pricing.length) {
                alert("가격을 입력해주세요.");
                return;
            }

            $("#message_m_popup_wrap").attr("class", "message_m_popup_wrap");

            chatManager.write(this, 3, "");
        });

        /*
        $(".popupPricing").click(function () {
            // check data
            let title = $("#payment_title").val();
            let category = $("#payment_category option:selected").val();
            let pricing = $("#payment_pricing").val();

            if (1 > title.length) {
                alert("제목을 입력해주세요.");
                return;
            }

            if (10 > category) {
                alert("분류를 선택해주세요.");
                return;
            }

            if (1 > pricing.length) {
                alert("가격을 입력해주세요.");
                return;
            }

            //addPricingToChatBox();
            $(".message_popup_wrap").hide();
            chatManager.write(this, 3, "");
        });
         */
    });

    function addMySideChatData(data) {

        //let chatDate = getFormatDate(to_date2(data.chat_date));
        let chatDate = getFormatDate(data.chat_date);

        let content = '<div class="my_chat">';
        content += '<div class="chat">';
        content += '<div class="box">';
        content += '<span class="arrow"></span>';
        content += '<p>' + data.message + '</p>';
        content += '<span class="date">' + chatDate + '</span>'
        content += '</div>'
        content += '</div>'
        content += '</div>'

        $('.chat_area').append(content);
        // $(".chat_box").scrollTop($(".chat_area").height());

        let offset = $("#inbox_message").offset();
        $('html, body').animate({scrollTop: offset.top}, 0);
        //$('html, body').scrollTop({scrollTop : offset.top}, 0);
        //$('html, body').scrollTop($("#inbox_message").height());
        // $(window).scrollTop($("#inbox_message").height());

        chatManager.updateReadYn();
    }

    function addOtherSideChatData(data) {
        //let chatDate = getFormatDate(to_date2(data.chat_date));
        let chatDate = getFormatDate(data.chat_date);


        let content = '<div class="opponent_chat">';
        content += '<div class="chat">';
        content += '<p class="name">' + data.mb_name + '</p>';
        content += '<div class="box">';
        content += '<span class="arrow"></span>';
        content += '<p>' + data.message + '</p>';
        content += '<span class="date">' + chatDate + '</span>'
        content += '</div>'
        content += '</div>'
        content += '</div>'

        $('.chat_area').append(content);
        // $(".chat_box").scrollTop($(".chat_area").height());

        let offset = $("#inbox_message").offset();
        // $('html, body').scrollTop({scrollTop : offset.top}, 0);
        $('html, body').animate({scrollTop: offset.top}, 0);

        //$('html, body').scrollTop({scrollTop : offset.top}, 400);
        // $('html, body').scrollTop($("#inbox_message").height());
        //$(window).scrollTop(500);
    }

    function addMySideFileData(data) {
        let message = data.message;
        let fileMessage = JSON.parse(message);
        //let chatDate = getFormatDate(to_date2(data.chat_date));
        let chatDate = getFormatDate(data.chat_date);
        //let fileLink = "../data/chatroom/" + data.mb_id + "/" + fileMessage.filePath;
        let filePath  = fileMessage.filePath;
        filePath = filePath.replace(/, /g, '');
        //let fileLink = (data.chat_type === "5") ? "https://file.allvoice.kr/download.php?fileName=" + filePath + "&fileNameBase=" + fileMessage.fileName: "../data/chatroom/" + data.mb_id + "/" + filePath;
        let fileLink = (data.chat_type === "5") ? "https://file.allvoice.kr/download.php?fileName=" + filePath + "&fileNameBase=" + fileMessage.fileName: "https://allvoice.kr/data/chatroom/" + data.mb_id + "/" + filePath;
        let fileName = 'download=' + '"' + fileMessage.fileName + '"';

        let content = '<div class="my_chat">';
        content += '<div class="chat">';
        content += '<div class="file">';
        //content += '<a href=' + fileLink + ' ' + fileName + '>';
        <?php
        if ( !$_set_device ) {
        ?>
        content += '<a href=' + fileLink + ' ' + fileName + '>';
        <?php
        }
        else {
        ?>
        fileName = 'download_name$' + fileMessage.fileName;
        content += '<a href="#download_functions|download_url$'+fileLink + '|' + fileName + '">';
        <?php
        }
        ?>

        content += '<span class="arrow"></span>';
        content += '<p class="text1">' + fileMessage.fileName + '</p>';
        content += '<p class="text2">용량 : ' + getHumanSize(fileMessage.size) + '</p>';
        content += '<span class="date">' + chatDate + '</span>';
        content += '</a>';
        content += '</div>';
        content += '</div>';
        content += '</div>';

        $('.chat_area').append(content);

        let offset = $("#inbox_message").offset();
        $('html, body').animate({scrollTop: offset.top}, 0);
    }

    function addOtherSideFileData(data) {
        let message = data.message;
        let fileMessage = JSON.parse(message);
        //let chatDate = getFormatDate(to_date2(data.chat_date));
        let chatDate = getFormatDate(data.chat_date);
        // let fileLink = "../data/chatroom/" + data.mb_id + "/" + fileMessage.filePath;
        let filePath  = fileMessage.filePath;
        filePath = filePath.replace(/, /g, '');
        //let fileLink = (data.chat_type === "5") ? "https://file.allvoice.kr/download.php?fileName=" + filePath + "&fileNameBase=" + fileMessage.fileName: "../data/chatroom/" + data.mb_id + "/" + filePath;
        let fileLink = (data.chat_type === "5") ? "https://file.allvoice.kr/download.php?fileName=" + filePath + "&fileNameBase=" + fileMessage.fileName: "https://allvoice.kr/data/chatroom/" + data.mb_id + "/" + filePath;
        let fileName = 'download=' + '"' + fileMessage.fileName + '"';

        let content = '<div class="opponent_chat">';
        content += '<div class="chat">';
        content += '<p class="name">' + data.mb_name + '</p>';
        content += '<div class="file">';
        //content += '<a href=' + fileLink + ' download = ' + fileMessage.fileName + '>';
        //content += '<a href=' + fileLink + ' ' + fileName + '>';
        <?php
        if ( !$_set_device ) {
        ?>
        content += '<a href=' + fileLink + ' ' + fileName + '>';
        <?php
        }
        else {
        ?>
        //fileName = 'download_name$' + fileMessage.fileName;
        //content += '<a href="#download_functions|download_url$'+fileLink + '|' + fileName + '>';
        fileName = 'download_name$' + fileMessage.fileName;
        content += '<a href="#download_functions|download_url$'+fileLink + '|' + fileName + '">';
        <?php
        }
        ?>
        content += '<span class="arrow"></span>';
        content += '<p class="text1">' + fileMessage.fileName + '</p>';
        content += '<p class="text2">용량 : ' + getHumanSize(fileMessage.size) + '</p>';
        content += '<span class="date">' + chatDate + '</span>';
        content += '</a>';
        content += '</div>';
        content += '</div>';
        content += '</div>';

        $('.chat_area').append(content);

        let offset = $("#inbox_message").offset();
        $('html, body').animate({scrollTop: offset.top}, 0);
    }

    function addPricingData(data) {
        let message = data.message;
        let pricingData = JSON.parse(message);
        let pricing = pricingData.pricing.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        let projectLink = '../shop/voiceMypageOrderDetail.php?it_id=' + data.project_id + '&od_id=' + data.project_order_id + '&it_gubun=3';
        let memberType = <?php echo $member['mb_gubun']; ?>

            let
        content = '<div class="payment_box">';
        content += '<p class="text1">결제요청이 도착했습니다</p>';
        content += '<table class="tb_m_message">';
        content += '<caption>';
        content += '<span>결제요청 정보 테이블입니다. No, 제목, 분류, 가격 포함</span>';
        content += '</caption>';
        content += '<colgroup>';
        content += '<col style="width: 5%;"/>';
        content += '<col style="width: *;"/>';
        content += '<col style="width: 25%;"/>';
        content += '<col style="width: 25%;"/>';
        content += '</colgroup>';
        content += '<thead>';
        content += '<tr>';
        content += '<th scope="col" class="ta_c">No.</th>';
        content += '<th scope="col">제목</th>';
        content += '<th scope="col">분류</th>';
        content += '<th scope="col" class="ta_c">가격</th>';
        content += '</tr>';
        content += '</thead>';
        content += '<tbody>';
        content += '<tr>';
        content += '<td class="ta_c">1</td>';
        content += '<td>' + pricingData.title + ' </td>';
        content += '<td>' + getCategoryText(pricingData.category) + '</td>';
        content += '<td class="ta_c">￦ ' + pricing + '</td>';
        content += '</tr>';
        content += '<tr>';
        content += '<td colspan="4" class="total">합계 : ￦ ' + pricing + '</td>';
        content += '</tr>';
        content += '</tbody>';
        content += '</table>';
        if ("3" != memberType)
            content += '<p class="btn2"><a href=' + projectLink + '><img src="../theme/basic/img/mobile/inbox/button_02.png" alt="결제하러 가기"></a></p>';
        content += '</div>';

        $('.chat_area').append(content);

        let offset = $("#inbox_message").offset();
        $('html, body').animate({scrollTop: offset.top}, 0);
    }

    function updatePricingData(data) {
        let message = data.message;
        let pricingData = JSON.parse(message);
        let pricing = pricingData.pricing.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        let projectLink = '../shop/voiceMypageOrderDetail.php?it_id=' + data.project_id + '&od_id=' + data.project_order_id + '&it_gubun=3';

        let content = '<div class="payment_box">';
        content += '<p class="text1">결제정보가 변경되었습니다.</p>';
        content += '<table class="tb_m_message">';
        content += '<caption>';
        content += '<span>결제요청 정보 테이블입니다. No, 제목, 분류, 가격 포함</span>';
        content += '</caption>';
        content += '<colgroup>';
        content += '<col style="width: 5%;"/>';
        content += '<col style="width: *;"/>';
        content += '<col style="width: 25%;"/>';
        content += '<col style="width: 25%;"/>';
        content += '</colgroup>';
        content += '<thead>';
        content += '<tr>';
        content += '<th scope="col" class="ta_c">No.</th>';
        content += '<th scope="col">제목</th>';
        content += '<th scope="col">분류</th>';
        content += '<th scope="col" class="ta_c">가격</th>';
        content += '</tr>';
        content += '</thead>';
        content += '<tbody>';
        content += '<tr>';
        content += '<td class="ta_c">1</td>';
        content += '<td>' + pricingData.title + ' </td>';
        content += '<td>' + getCategoryText(pricingData.category) + '</td>';
        content += '<td class="ta_c">￦ ' + pricing + '</td>';
        content += '</tr>';
        content += '<tr>';
        content += '<td colspan="4" class="total">합계 : ￦ ' + pricing + '</td>';
        content += '</tr>';
        content += '</tbody>';
        content += '</table>';
        content += '</div>';

        $('.chat_area').append(content);

        let offset = $("#inbox_message").offset();
        $('html, body').animate({scrollTop: offset.top}, 0);
    }

    function addPrgressBar(fileName, idKey) {
        idKey++;
        let today = new Date();

        let progressBarId =  "progressBar" + idKey;

        let modal_content = '<div class="opponent_chat" id = opponent_chat' + idKey + '>';
        modal_content += '<div class="chat">';
        modal_content += '<p class="name">' + fileName + '</p>';
        modal_content += '<progress id=' + progressBarId + ' value="0" max="100" style="width:100%"></progress>'
        modal_content += '</div>';
        modal_content += '</div>';

        $('.chat_area').append(modal_content);
        $(".chat_box").scrollTop($(".chat_area").height());

        return idKey;
    }

    /**
     *  yyyyMMdd 포맷으로 반환
     */
    function getFormatDate(date) {

        date = new Date(String(date).replace(/-/g, "/"));

        let year = date.getFullYear();              //yyyy
        let month = (1 + date.getMonth());          //M
        month = month >= 10 ? month : '0' + month;  //month 두자리로 저장
        let day = date.getDate();                   //d
        day = day >= 10 ? day : '0' + day;          //day 두자리로 저장
        console.log(date.getHours());
        return month + '월 ' + day + '일 ' + date.getHours() + ':' + leadingZeros(date.getMinutes(), 2);
    }

    function to_date2(date_str) {
        let yyyyMMdd = String(date_str);
        let sYear = yyyyMMdd.substring(0, 4);
        let sMonth = yyyyMMdd.substring(5, 7);
        let sDate = yyyyMMdd.substring(8, 10);

        //alert("sYear :"+sYear +"   sMonth :"+sMonth + "   sDate :"+sDate);
        //return new Date(Number(sYear), Number(sMonth)-1, Number(sDate));

        return new Date(date_str);
    }

    function leadingZeros(n, digits) {
        let zero = '';
        n = n.toString();

        if (n.length < digits) {
            for (i = 0; i < digits - n.length; i++)
                zero += '0';
        }
        return zero + n;
    }

    // yyyymmdd 형태로 포매팅된 날짜 반환
    /*
    Date.prototype.yyyymmdd = function()
    {
        var yyyy = this.getFullYear().toString();

        var mm = (this.getMonth() + 1).toString();

        var dd = this.getDate().toString();

        return yyyy + (mm[1] ? mm : '0'+mm[0]) + (dd[1] ? dd : '0'+dd[0]);
    }
    */

    function getCategoryText(category) {
        let categoryText;

        switch (category) {
            case "10":
                categoryText = "광고";
                break;
            case "11":
                categoryText = "홍보";
                break;
            case  "12":
                categoryText = "방송";
                break;
            case "13":
                categoryText = "만화";
                break;
            case "14":
                categoryText = "게임";
                break;
            case "15":
                categoryText = "영화예고";
                break;
            case "16":
                categoryText = "이벤트";
                break;
            case "17":
                categoryText = "오디오북, 교재";
                break;
            case "18":
                categoryText = "기기음성, 성대모사";
                break;
            case "19":
                categoryText = "ARS, 안내멘트";
                break;
            case "20":
                categoryText = "홈쇼핑";
                break;
            case "21":
                categoryText = "비상업용";
                break;
        }

        return categoryText;
    }


    function getHumanSize(fileSize) {
        let sizeK = 1024;
        let sizeM = 1024 * 1024;
        let sizeG = 1024 * 1024 * 1024;
        let humanSize = 0.00;
        let humanText = "";

        if (fileSize < sizeM) {
            humanSize = fileSize / sizeK;
            humanText = humanSize.toFixed(2) + "K";
        } else if (fileSize < sizeG) {
            humanSize = fileSize / sizeM;
            humanText = humanSize.toFixed(2) + "M";
        } else {
            humanSize = fileSize / sizeG;
            humanText = humanSize.toFixed(2) + "G";
        }

        return humanText;
    }

    let chatManager = new function () {
        let idle = true;
        //var interval = 500;
        let interval = 1000;
        let xmlHttp = new XMLHttpRequest();
        let xmlHttp2 = new XMLHttpRequest();
        let xmlHttpVoiceProject = new XMLHttpRequest();
        let xmlHttpReadYn = new XMLHttpRequest();
        let finalDate = '';
        let curChatroomId = "<?php echo $chatroomId; ?>";
        console.log(curChatroomId);
        let lastno = 0;
        let messsageId = 0;
        //let chatroomId = "<?php echo $member['mb_id']; ?>";

        // Ajax Setting
        xmlHttp.onreadystatechange = function () {

            if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                // JSON 포맷으로 Parsing
                res = JSON.parse(xmlHttp.responseText);
                // finalDate = res.date;

                lastno = res.lastno;

                // 채팅내용 보여주기
                chatManager.show(res.data);

                // 중복실행 방지 플래그 OFF
                idle = true;
            }
        }

        // Ajax Setting
        xmlHttp.onreadystatechange = function () {

            if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {

                console.log("http2");

                // xmlHttp.
                // JSON 포맷으로 Parsing
                res = JSON.parse(xmlHttp.responseText);
                // finalDate = res.date;

                // 채팅내용 보여주기
                //chatManager.show(res.data);
                let data = res.data;

                //console.log(data);

                let mb_id = "<?php echo $member['mb_id']; ?>";


                for (let i = 0; i < data.length; i++) {

                    // make_chat_dialog_box(false, data[i].mb_id, "", data[i].message, data[i].chat_date);
                    // make_op_chat_dialog_box(data[i].mb_id, "", data[i].message, data[i].chat_date);

                    if (mb_id === data[i].mb_id) {
                        if ("2" === data[i].chat_type || "5" === data[i].chat_type) {
                            addMySideFileData(data[i]);
                        } else if ("3" === data[i].chat_type) {
                            addPricingData(data[i]);
                        } else if ("4" === data[i].chat_type) {
                            updatePricingData(data[i])
                        } else {
                            addMySideChatData(data[i]);
                        }
                    } else {
                        //make_op_chat_dialog_box(data[i].mb_id, "", data[i].message, data[i].chat_date);
                        if ("2" === data[i].chat_type || "5" === data[i].chat_type) {
                            addOtherSideFileData(data[i]);
                        } else if ("3" === data[i].chat_type) {
                            addPricingData(data[i]);
                        } else if ("4" === data[i].chat_type) {
                            updatePricingData(data[i])
                        } else {
                            addOtherSideChatData(data[i]);
                        }
                    }

                    messsageId = data[i].message_id;

                    //dt = document.createElement('dt');
                    //dt.appendChild(document.createTextNode(data[i].name));
                    //o.appendChild(dt);

                    //dd = document.createElement('dd');
                    //dd.appendChild(document.createTextNode(data[i].msg));
                    //o.appendChild(dd);
                }

                // 중복실행 방지 플래그 OFF
                idle = true;
            }
        }

        xmlHttp2.onreadystatechange = function () {

            if (xmlHttp2.readyState == 4 && xmlHttp2.status == 200) {

                // JSON 포맷으로 Parsing
                res = JSON.parse(xmlHttp2.responseText);

                let data = res.data;
                let mb_id = "<?php echo $member['mb_id']; ?>";

                for (let i = 0; i < data.length; i++) {

                    if (data[i].mb_id != mb_id) {
                        //makeUserInfo(data[i]);
                        console.log(data[i].mb_name);

                        $("#other_name").text(data[i].mb_name);
                        break;
                    }

                }
            }
        }


        // 채팅내용 가져오기
        this.queryChatLis = function ($) {

            let url = "../inbox/inbox_query.php";

            let chatroomID = '';
            chatroomID = $;
            curChatroomId = chatroomID;
            let mb_id = "<?php echo $member['mb_id']; ?>";

            // Ajax 통신
            xmlHttp.open("GET", url + "?chatroom_id=" + chatroomID + "&mb_id=" + mb_id, true);
            xmlHttp.send();
        }

        this.updateReadYn = function () {
            let mb_id = "<?php echo $member['mb_id']; ?>";

            let param = [];
            param.push("chatroom_id=" + encodeURIComponent(curChatroomId));
            param.push("mb_id=" + encodeURIComponent(mb_id));

            let url = "../inbox/inbox_check_read_yn.php";
            // Ajax 통신
            xmlHttpReadYn.open("POST", url, true);
            xmlHttpReadYn.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlHttpReadYn.send(param.join('&'));
        }

        this.queryChatMembers = function (chatroomID) {

            let url = "../inbox/inbox_proc.php";

            // Ajax 통신
            xmlHttp2.open("GET", url + "?type=2&chatroom_id=" + chatroomID, true);
            xmlHttp2.send();
        }


        // 마지막 채팅내용 가져오기
        this.proc = function () {

            // 중복실행 방지 플래그가 ON이면 실행하지 않음
            if (!idle) {
                return false;
            }

            // 중복실행 방지 플래그 ON
            idle = false;

            let mb_id = "<?php echo $member['mb_id']; ?>";
            let url = "../inbox/inbox_proc.php";

            // Ajax 통신
            xmlHttp.open("GET", url + "?type=1&chatroom_id=" + curChatroomId + "&message_id=" + messsageId + "&mb_id=" + mb_id, true);
            xmlHttp.send();
        }

        // 채팅내용 보여주기
        this.show = function (data) {
            //console.log("");

            //var o = document.getElementById('list');
            //var dt, dd;

            // 채팅내용 추가
            for (var i = 0; i < data.length; i++) {
                //make_op_chat_dialog_box(data[i].mb_id, data[i].op_id, data[i].msg)
                //dt = document.createElement('dt');
                //dt.appendChild(document.createTextNode(data[i].name));
                //o.appendChild(dt);

                //dd = document.createElement('dd');
                //dd.appendChild(document.createTextNode(data[i].msg));
                //o.appendChild(dd);
            }

            // 가장 아래로 스크롤
            //o.scrollTop = o.scrollHeight;

        }

        // 채팅내용 작성하기
        this.write = function (frm, msgType, filePath) {
            console.log("write");

            let xmlHttpWrite = new XMLHttpRequest();

            let chatroom_id = curChatroomId;
            //console.log("chatroom_id : " + curChatroomId);
            let chat_type = msgType;
            let mb_id = "<?php echo $member['mb_id']; ?>";
            let op_id = "<?php echo $_GET['me_recv_mb_id']; ?>";

            let message = $("#inbox_message").val();
            message = message.replace(/(?:\r\n|\r|\n)/g, '<br />');

            // 파일 타입
            if (2 === msgType || 5===msgType) {
                let fileValue = $("#file2").val().split("\\");
                let fileName = fileValue[fileValue.length - 1]; // 파일명
                //alert(fileName);

                let size = document.getElementById("file2").files[0].size;

                // 객체 생성
                let fileMessage = new Object();

                fileMessage.fileName = fileName;
                fileMessage.size = size;
                fileMessage.filePath = filePath;

                message = JSON.stringify(fileMessage);

            } else if (3 === msgType) {
                let voiceProject = new Object();

                voiceProject.title = $("#payment_title").val();
                voiceProject.category = $("#payment_category option:selected").val();
                voiceProject.pricing = $("#payment_pricing").val();

                message = JSON.stringify(voiceProject);
            }

            // 이름이나 내용이 입력되지 않았다면 실행하지 않음
            /*
            if(name.length == 0 || msg.length == 0)
            {
                return false;
            }
            */


            // POST Parameter 구축
            let param = [];
            param.push("chatroom_id=" + encodeURIComponent(chatroom_id));
            param.push("chat_type=" + encodeURIComponent(chat_type));
            param.push("mb_id=" + encodeURIComponent(mb_id));
            param.push("message=" + encodeURIComponent(message));
            //param.push("msg=" + encodeURIComponent(msg));

            let url = "../inbox/inbox_insert.php";
            // Ajax 통신
            xmlHttpWrite.open("POST", url, true);
            xmlHttpWrite.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlHttpWrite.send(param.join('&'));

            // 채팅내용 갱신
            chatManager.proc();
        }

        // interval에서 지정한 시간 후에 실행
        setInterval(this.proc, interval);
    }

</script>
