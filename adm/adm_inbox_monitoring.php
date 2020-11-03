<?php
$sub_menu = '300800';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");


$g5['title'] = '1:1채팅 모니터링';
// include_once(G5_ADMIN_PATH . '/admin.head.php');

//$g5['title'] = '게시판관리';
include_once('./admin.head.php');

$colspan = 15;

?>


<?php
include_once('../inbox/chatMngr.php');

if ($is_guest)
    alert('회원만 이용하실 수 있습니다.', G5_URL);


$toId = $_GET['me_recv_mb_id'];
$chatroomId = "0";

if (!empty($toId)) {
    $chatManager = new chatMngr();
    $chatroomId = $chatManager->checkChatroomId($toId, $member['mb_id']);
}

// include_once('./_head.php');
include_once('./admin.head.php');

?>

<!--
<div class="commonLocation">
    <ul>
        <li><img src="../theme/basic/img/img_home2.png"/></li>
        <li>1:1 문의</li>
    </ul>
</div>
-->

<div id="message_wrap">
    <div class="message_box">
        <div class="body_area">
            <div class="left_box">
                <ul class="chat_room_list">
                </ul>
            </div>
            <div class="right_box">
                <div class="user_info">
                </div>
                <div class="chat_box">
                    <dl class="chat_area">
                        <div class="opponent_chat">
                            <p class="profile"><img src="../theme/basic/img/inbox/img_profile.jpg"></p>
                            <div class="chat">
                                <p class="name">류혜윤</p>
                                <div class="box">
                                    <span class="arrow"></span>
                                    <p>후반작업까지 의뢰 하려고 하는데 얼마정도 하나요? 라고 두줄짜리 질문을 지금 적고 있습니다. 한줄 높이는 27px입니다</p>
                                    <span class="date">8월 19일 13:45</span>
                                </div>
                                <div class="box">
                                    <span class="arrow"></span>
                                    <p>한줄일때 나오는 정도입니다</p>
                                    <span class="date">8월 19일 13:45</span>
                                </div>
                                <div class="box">
                                    <span class="arrow"></span>
                                    <p>세줄로 표시되는 상태입니다. 최대 길이와 영역을 확인해주세요~<br/>어떻게 표시를 해드려야할지 몰라서 최대한 구체적으로 표시를
                                        해두었습니다!! 네모 찾아서 수치를 봐주시면 됩니다!</p>
                                    <span class="date">8월 19일 13:45</span>
                                </div>
                            </div>
                        </div>

                        <div class="my_chat">
                            <div class="chat">
                                <div class="box">
                                    <span class="arrow"></span>
                                    <p>후반작업까지 의뢰 하려고 하는데 얼마정도 하나요? 라고 두줄짜리 질문을 지금 적고 있습니다. 한줄 높이는 27px입니다</p>
                                    <span class="date">8월 19일 13:45</span>
                                </div>
                                <div class="box">
                                    <span class="arrow"></span>
                                    <p>한줄일때 나오는 정도입니다</p>
                                    <span class="date">8월 19일 13:45</span>
                                </div>
                                <div class="box">
                                    <span class="arrow"></span>
                                    <p>세줄로 표시되는 상태입니다. 최대 길이와 영역을 확인해주세요~<br/>어떻게 표시를 해드려야할지 몰라서 최대한 구체적으로 표시를
                                        해두었습니다!! 네모 찾아서 수치를 봐주시면 됩니다!</p>
                                    <span class="date">8월 19일 13:45</span>
                                </div>
                            </div>
                        </div>

                        <div class="opponent_chat">
                            <p class="profile"><img src="../theme/basic/img/inbox/img_profile.jpg"></p>
                            <div class="chat">
                                <p class="name">류혜윤</p>
                                <div class="box">
                                    <span class="arrow"></span>
                                    <p>넵 성우님! 대본 먼저 전달드리겠습니다!<br/>대본보시고 견적 나오시면 전달부탁드리겠습니다!</p>
                                    <span class="date">8월 19일 13:45</span>
                                </div>
                                <div class="file">
                                    <span class="arrow"></span>
                                    <p class="text1">파일 : 김주호 성우님 대본.txt</p>
                                    <p class="text2">1.9MB<a href="#none">다운로드</a></p>
                                    <span class="date">8월 19일 13:45</span>
                                </div>
                            </div>
                        </div>

                        <div class="my_chat">
                            <div class="chat">
                                <div class="box">
                                    <span class="arrow"></span>
                                    <p>파일 확인 했습니다~ 대본이 생각보다 많은듯 해서 성우료 50만원으로 진행 해야 할듯 하네요~ 결제요청 드리겠습니다~</p>
                                    <span class="date">8월 19일 13:45</span>
                                </div>
                            </div>
                        </div>

                        <div class="payment_box">
                            <p class="text1">결제요청이 도착했습니다</p>
                            <table class="tb_message">
                                <caption>
                                    <span>결제요청 정보 테이블입니다. No, 제목, 분류, 가격 포함</span>
                                </caption>
                                <colgroup>
                                    <col style="width: 5%;"/>
                                    <col style="width: *;"/>
                                    <col style="width: 25%;"/>
                                    <col style="width: 25%;"/>
                                </colgroup>
                                <thead>
                                <tr>
                                    <th scope="col" class="ta_c">No.</th>
                                    <th scope="col">제목</th>
                                    <th scope="col">분류</th>
                                    <th scope="col" class="ta_c">가격</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="ta_c">01</td>
                                    <td>성우 김주호_ 오디오북 녹음</td>
                                    <td>오디오북</td>
                                    <td class="ta_c">￦ 480,000</td>
                                </tr>
                                <tr>
                                    <td class="ta_c">02</td>
                                    <td>성우 김주호_ 광고 10초 분량 녹음</td>
                                    <td>광고</td>
                                    <td class="ta_c">￦ 480,000</td>
                                </tr>
                                <tr>
                                    <td class="ta_c">03</td>
                                    <td>성우 김주호_ ARS 녹음</td>
                                    <td>ARS,안내멘트</td>
                                    <td class="ta_c">￦ 480,000</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="total">합계 : ￦ 3,480,000</td>
                                </tr>
                                </tbody>
                            </table>
                            <a href="#none"><img src="../theme/basic/img/inbox/button_02.gif"
                                                 onmouseover="this.src='../theme/basic/img/inbox/button_02_hover.gif'"
                                                 onmouseout="this.src='../theme/basic/img/inbox/button_02.gif'"></a>
                        </div>

                        <div class="opponent_chat">
                            <p class="profile"><img src="../theme/basic/img/inbox/img_profile.jpg"></p>
                            <div class="chat">
                                <p class="name">류혜윤</p>
                                <div class="box">
                                    <span class="arrow"></span>
                                    <p>결제했습니다!! 녹음 진행 부탁드려요!<br/>감사합니다~!</p>
                                    <span class="date">8월 19일 13:45</span>
                                </div>
                                <div class="file">
                                    <span class="arrow"></span>
                                    <p class="text1">파일 : 김주호 성우님 최종대본.txt</p>
                                    <p class="text2">1.9MB<a href="#none">다운로드</a></p>
                                    <span class="date">8월 19일 13:45</span>
                                </div>
                            </div>
                        </div>
                    </dl>
                </div>
                <div class="write_box">
                    <div class="btn_box">
                        <p>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- //메시지 -->

<script type="text/javascript">

    $(document).ready(function () {
        console.log("ready!");

        let temp = <?php echo $chatroomId ?>;
        console.log("init chatrromid : " + temp);

        $(".user_info").empty();
        $(".chat_area").empty();

        $(".message_popup_wrap").hide();

        inboxListMngr.queryChatLis();

        chatManager.queryChatMembers(temp);
        chatManager.queryChatLis(temp);
    });


    $(document).on("click", ".chat_room_list  li", function () {
        //chat_area
        let chatroomID = "";
        chatroomID = $(this).attr('id');

        chatroomID = chatroomID.replace("chatroom_id", "");

        $(".user_info").empty();
        $(".chat_area").empty();

        chatManager.queryChatMembers(chatroomID);
        chatManager.queryChatLis(chatroomID);
        chatManager.updateReadYn();
    });

    $(function () {

        $(".fr").click(function () {

            console.log("input message:  " + $("#inbox_message").val());

            let message = $("#inbox_message").val();
            let today = new Date();
            console.log("today" + today);
            // make_chat_dialog_box(true, "test", "test2", message, new Date());
            // make_op_chat_dialog_box("test", "test2", message);

            chatManager.write(this, 1, "");

            // clear message
            $("#inbox_message").val("");
        });

    });

    function makeUserInfo(data) {

        //let modal_content = '<p class="profile"><img src=' + data.profile_img_src + '></p>';
        let modal_content = '<p class="name">' + data + '</p>'
        //modal_content += '<a href="#none" class="favorite on"></a>'

        $('.user_info').append(modal_content);
    }

    function make_chat_dialog_box(isQuery, to_user_id, to_user_name, message, inbox_date) {

        //console.log(getFormatDate(to_date2(inbox_date)));
        let chatDate = getFormatDate(to_date2(inbox_date));

        let modal_content = '<div class="my_chat">';
        modal_content += '<div class="chat">';
        modal_content += '<div class="box">';
        modal_content += '<span class="arrow"></span>';
        //modal_content += '<p>파일 확인 했습니다~ 대본이 생각보다 많은듯 해서 성우료 50만원으로 진행 해야 할듯 하네요~ 결제요청 드리겠습니다~</p>';
        modal_content += '<p>' + message + '</p>';
        //modal_content += '<span class="date">8월 19일 13:45</span>'
        modal_content += '<span class="date">' + chatDate + '</span>'
        modal_content += '</div>'
        modal_content += '</div>'
        modal_content += '</div>'

        $('.chat_area').append(modal_content);

        $(".chat_box").scrollTop($(".chat_area").height());

        if (true == isQuery) {
            // Jquery
            //chatManager.write(this);
        }
    }

    function make_op_chat_dialog_box(data) {

        let chatDate = getFormatDate(to_date2(data.chat_date));

        let modal_content = '<div class="opponent_chat">';
        //modal_content += '<p class="profile"><img src="../theme/basic/img/inbox/img_profile.jpg"></p>';
        modal_content += '<p class="profile"><img src=' + data.profile_img_src + '></p>';
        modal_content += '<div class="chat">';
        modal_content += '<p class="name">' + data.mb_name + '</p>';
        modal_content += '<div class="box">';
        modal_content += '<span class="arrow"></span>';
        //modal_content += '<p>넵 성우님! 대본 먼저 전달드리겠습니다!<br/>대본보시고 견적 나오시면 전달부탁드리겠습니다!</p>';
        modal_content += '<p>' + data.message + '</p>';
        modal_content += '<span class="date">' + chatDate + '</span>';
        modal_content += '</div>';
        modal_content += '</div>';
        modal_content += '</div>';

        $('.chat_area').append(modal_content);

        $(".chat_box").scrollTop($(".chat_area").height());

        chatManager.updateReadYn();
    }

    function addMyFileMessageToChatBox(data) {

        let chatDate = getFormatDate(to_date2(data.chat_date));
        let message = data.message;
        let fileMessage = JSON.parse(message);
        let filePath  = fileMessage.filePath;
        filePath = filePath.replace(/, /g, '');
        let fileLink = "../data/chatroom/" + data.mb_id + "/" + filePath;
        let fileName = 'download=' + '"' + fileMessage.fileName + '"';

        let modal_content = '<div class="my_chat">';
        modal_content += '<div class="chat">'
        modal_content += '<div class="box">';
        modal_content += '<div class="file">';
        modal_content += '<span class="arrow"></span>';
        modal_content += '<p class="text1">파일 : ' + fileMessage.fileName + '</p>';
        //modal_content += '<p class="text2">' + getHumanSize(fileMessage.size) + '<a href=' + fileLink + ' download = ' + fileMessage.fileName + '>다운로드</a></p>';
        modal_content += '<p class="text2">' + getHumanSize(fileMessage.size) + '<a href=' + fileLink + ' ' + fileName + '>다운로드</a></p>';
        modal_content += '<span class="date">' + chatDate + '</span>';
        modal_content += '</div>';
        modal_content += '</div>';
        modal_content += '</div>';

        $('.chat_area').append(modal_content);
        $(".chat_box").scrollTop($(".chat_area").height());
    }

    function addFileMessageToChatBox(data) {

        let chatDate = getFormatDate(to_date2(data.chat_date));
        let message = data.message;
        let fileMessage = JSON.parse(message);

        // let filePath = data.mb_id + '/' + fileMessage.filePath;
        let filePath  = fileMessage.filePath;
        filePath = filePath.replace(/, /g, '');
        let fileLink = "../data/chatroom/" + data.mb_id + "/" + filePath;
        let fileName = 'download=' + '"' + fileMessage.fileName + '"';

        let modal_content = '<div class="opponent_chat">';
        modal_content += '<p class="profile"><img src=' + data.profile_img_src + '></p>';
        modal_content += '<div class="chat">';
        modal_content += '<p class="name">' + data.mb_name + '</p>';
        modal_content += '<div class="file">';
        modal_content += '<span class="arrow"></span>';
        modal_content += '<p class="text1">파일 : ' + fileMessage.fileName + '</p>';
        //modal_content += '<p class="text2">' + getHumanSize(fileMessage.size) + '<a href=' + fileLink + ' download = ' + fileMessage.fileName + '>다운로드</a></p>';
        modal_content += '<p class="text2">' + getHumanSize(fileMessage.size) + '<a href=' + fileLink + ' ' + fileName + '>다운로드</a></p>';
        modal_content += '<span class="date">' + chatDate + '</span>';
        modal_content += '</div>';
        modal_content += '</div>';
        modal_content += '</div>';

        $('.chat_area').append(modal_content);
        $(".chat_box").scrollTop($(".chat_area").height());
    }

    function makeChatRoomList(data) {

        if ("2" === data.chat_type || "5" === data.chat_type) {
            data.message = "파일 전송";
        } else if ("3" === data.chat_type) {
            data.message = "결제정보 전송";
        } else if ("4" === data.chat_type) {
            data.message = "결제정보 변경";
        }

        console.log("read_yn " + data.read_yn);

        let content = '<li id = chatroom_id' + data.chatroom_id + '>';
        content += '<a href="#none">';
        content += '<div>';
        //content += '<p class="profile"><img src=' + data.not_me_profile_img_src + '></p>';
        if (data.read_yn < 1) {
            content += '<p class="new"><img src="../theme/basic/img/inbox/icon_newchat.gif"></p>';
        }
        content += '<p class="name">' + data.chatroom_id + '<span>' + data.chat_date + '</span></p>';
        //content += '<p class="chat">' + data.message + '</p>';
        content += '</div>';
        content += '</a>';
        content += '</li>';

        $('.chat_room_list').append(content);
    }

    function addPricingToChatBox(data) {

        let message = data.message;
        let pricingData = JSON.parse(message);
        let pricing = pricingData.pricing.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        let projectLink = 'voiceMypageOrderDetail.php?it_id=' + data.project_id + '&od_id=' + data.project_order_id + '&it_gubun=3';
        let memberType = <?php echo $member['mb_gubun']; ?>;

        let content = '<div class="payment_box">';
        content += '<p class="text1">결제요청이 도착했습니다</p>';
        content += '<table class="tb_message">';
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
        content += '<td>' + pricingData.title + '</td>';
        content += '<td>' + getCategoryText(pricingData.category) + '</td>';
        content += '<td class="ta_c">￦ ' + pricing + '</td>';
        content += '</tr>';
        content += '<tr>';
        content += '<td colspan="4" class="total">합계 : ￦ ' + pricing + '</td>';
        content += '</tr>';
        content += '</tbody>';
        content += '</table>';

        $('.chat_area').append(content);
        $(".chat_box").scrollTop($(".chat_area").height());
    }

    function updatePricingData(data) {
        let message = data.message;
        let pricingData = JSON.parse(message);
        let pricing = pricingData.pricing.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        let projectLink = 'voiceMypageOrderDetail.php?it_id=' + data.project_id + '&od_id=' + data.project_order_id + '&it_gubun=3';

        let content = '<div class="payment_box">';
        content += '<p class="text1">결제정보가 변경되었습니다.</p>';
        content += '<table class="tb_message">';
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
        content += '<td>' + pricingData.title + '</td>';
        content += '<td>' + getCategoryText(pricingData.category) + '</td>';
        content += '<td class="ta_c">￦ ' + pricing + '</td>';
        content += '</tr>';
        content += '<tr>';
        content += '<td colspan="4" class="total">합계 : ￦ ' + pricing + '</td>';
        content += '</tr>';
        content += '</tbody>';
        content += '</table>';

        $('.chat_area').append(content);
        $(".chat_box").scrollTop($(".chat_area").height());
    }

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


    //
    function addVoiceProject() {
        let title = $("#payment_title").val();
        let category
        let pricing = $("#payment_pricing").val();

        console.log(title + pricing);
    }

    /**
     *  yyyyMMdd 포맷으로 반환
     */
    function getFormatDate(date) {
        let year = date.getFullYear();              //yyyy
        let month = (1 + date.getMonth());          //M
        month = month >= 10 ? month : '0' + month;  //month 두자리로 저장
        let day = date.getDate();                   //d
        day = day >= 10 ? day : '0' + day;          //day 두자리로 저장
        console.log(date.getHours());
        console.log(date.getMinutes());
        return month + '월 ' + day + '일 ' + date.getHours() + ':' + leadingZeros(date.getMinutes(), 2);
    }

    function to_date2(date_str) {
        console.log(date_str);
        var yyyyMMdd = String(date_str);
        var sYear = yyyyMMdd.substring(0, 4);
        var sMonth = yyyyMMdd.substring(5, 7);
        var sDate = yyyyMMdd.substring(8, 10);

        //alert("sYear :"+sYear +"   sMonth :"+sMonth + "   sDate :"+sDate);
        //return new Date(Number(sYear), Number(sMonth)-1, Number(sDate));

        return new Date(date_str);
    }

    function leadingZeros(n, digits) {
        var zero = '';
        n = n.toString();

        if (n.length < digits) {
            for (i = 0; i < digits - n.length; i++)
                zero += '0';
        }
        return zero + n;
    }


    let inboxListMngr = new function () {
        let idle = true;
        //var interval = 500;
        let interval = 5000;
        var xmlHttp = new XMLHttpRequest();
        let xmlHttp2 = new XMLHttpRequest();
        let finalDate = '';
        let lastno = 0;

        // Ajax Setting
        xmlHttp.onreadystatechange = function () {

            if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                // JSON 포맷으로 Parsing
                res = JSON.parse(xmlHttp.responseText);
                // finalDate = res.date;
                // lastno = res.lastno;

                console.log(res.data);
                // 채팅내용 보여주기
                inboxListMngr.show(res.data);

                // 중복실행 방지 플래그 OFF
                idle = true;
            }
        }

        // Ajax Setting
        xmlHttp2.onreadystatechange = function () {

            if (xmlHttp2.readyState == 4 && xmlHttp2.status == 200) {

                // JSON 포맷으로 Parsing
                res = JSON.parse(xmlHttp2.responseText);
                // finalDate = res.date;

                // 채팅내용 보여주기
                //chatManager.show(res.data);
                let data = res.data;

                let mb_id = "<?php echo $member['mb_id']; ?>";

                $(".chat_room_list").empty();

                for (let i = 0; i < data.length; i++) {
                    makeChatRoomList(data[i]);
                }

                // 중복실행 방지 플래그 OFF
                //idle = true;
            }
        }

        // 채팅내용 가져오기
        this.queryChatLis = function () {

            //let url = g5_bbs_url + "/inbox_proc.php";
            let url = "../inbox/inbox_adm_proc.php";

            let mbId = "<?php echo $member['mb_id']; ?>";
            // Ajax 통신
            xmlHttp2.open("GET", url + "?mb_id=" + mbId, true);
            xmlHttp2.send();
        }

        // 마지막 채팅내용 가져오기
        this.proc = function () {

            inboxListMngr.queryChatLis();

            /*
             // 중복실행 방지 플래그가 ON이면 실행하지 않음
            if (!idle) {
                return false;
            }

            // 중복실행 방지 플래그 ON
            idle = false;

            let url = g5_bbs_url + "/inbox_proc.php";

            // Ajax 통신
            xmlHttp.open("GET", url + "?op_id=voicetest1&lastno=" + lastno, true);
            xmlHttp.send();

            console.log("interval2");
            */


        }

        // 채팅내용 보여주기
        this.show = function (data) {
            return;

            console.log("chat room show");
            // 500-600

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

                makeChatRoomList(data[i]);
            }

            // 가장 아래로 스크롤
            //o.scrollTop = o.scrollHeight;

        }

        // interval에서 지정한 시간 후에 실행
        //setInterval(this.proc, interval);
    }

    let chatManager = new function () {
        let idle = true;
        //var interval = 500;
        let interval = 5000;
        let xmlHttp = new XMLHttpRequest();
        let xmlHttp2 = new XMLHttpRequest();
        let xmlHttpReadYn = new XMLHttpRequest();
        let xmlHttpVoiceProject = new XMLHttpRequest();
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

                console.log(data);

                let mb_id = "<?php echo $member['mb_id']; ?>";


                for (let i = 0; i < data.length; i++) {

                    if (i === 0)
                        mb_id = data[i].mb_id;


                    if (mb_id === data[i].mb_id) {
                        if ("3" === data[i].chat_type) {
                            addPricingToChatBox(data[i]);
                        } else if ("2" === data[i].chat_type || "5" === data[i].chat_type) {
                            addMyFileMessageToChatBox(data[i]);
                        } else if ("4" === data[i].chat_type) {
                            updatePricingData(data[i]);
                        } else {
                            make_chat_dialog_box(false, data[i].mb_id, "", data[i].message, data[i].chat_date);
                        }

                    } else {
                        //make_op_chat_dialog_box(data[i].mb_id, "", data[i].message, data[i].chat_date);
                        if ("3" === data[i].chat_type) {
                            addPricingToChatBox(data[i]);
                        } else if ("2" === data[i].chat_type || "5" === data[i].chat_type) {
                            addFileMessageToChatBox(data[i]);
                        } else if ("4" === data[i].chat_type) {
                            updatePricingData(data[i]);
                        } else {
                            make_op_chat_dialog_box(data[i]);
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
                //let mb_id = "<?php echo $member['mb_id']; ?>";
                let members = "";


                for (let i = 0; i < data.length; i++) {
                    members = data[i].mb_name + " (" + data[i].mb_id + ")";
                    if (i+1 < data.length)
                        members += "," + '&nbsp';

                    makeUserInfo(members);
                }
            }
        }


        // 채팅내용 가져오기
        this.queryChatLis = function ($) {

            let url = "../inbox/inbox_adm_query.php";

            let chatroomID = '';
            chatroomID = $;
            //chatroomID2 =chatroomID;

            //chatroomID = chatroomID.replace("chatroom_id", "");

            curChatroomId = chatroomID;

            let mb_id = "<?php echo $member['mb_id']; ?>";

            //chatroomID2 = chatroomID;
            //chatroomID2 = chatroomID2.replace("chatroom_id", "");

            //console.log("click " + chatroomID);

            console.log("click " + chatroomID);
            console.log("click2 " + mb_id);

            // Ajax 통신
            xmlHttp.open("GET", url + "?chatroom_id=" + chatroomID + "&mb_id=" + mb_id, true);
            xmlHttp.send();
        }

        this.updateReadYn = function () {
            // curChatroomId = chatroomID;
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
            //xmlHttp.open("GET", url + "?type=1&chatroom_id="+voicetest1&message_id=" + messsageId, true);
            xmlHttp.open("GET", url + "?type=1&chatroom_id=" + curChatroomId + "&message_id=" + messsageId + "&mb_id=" + mb_id, true);
            xmlHttp.send();
        }

        // 채팅내용 보여주기
        this.show = function (data) {

            // 채팅내용 추가
            for (var i = 0; i < data.length; i++) {
            }
        }

        // 채팅내용 작성하기
        this.write = function (frm, msgType, filePath) {
        }
    }
</script>


<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>
