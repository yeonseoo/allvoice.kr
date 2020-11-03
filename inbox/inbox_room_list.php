<?php
include_once('../shop/_common.php');
include_once(G5_MSHOP_PATH . '/_head.php');

if ($is_guest)
    alert('회원만 이용하실 수 있습니다.', G5_URL);

?>

<div id="message_m_wrap">
    <div class="message_m_box">
        <!--
        <div class="top_area">
            <p class="title">1:1 메시지</p>
            <p class="text1">내 대화 가능 시간 : 평일 오전 9시 ~ 오후 6시<a href="#none"><img src="../theme/basic/img/mobile/inbox/button_chat_option.png" alt="채팅시간 설정"></a></p>
        </div>
        -->
        <div class="body_area">
            <div class="chat_list">
                <ul class = "chat_list_data">
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- //메시지 -->

<script type="text/javascript">

    $(document).ready(function () {
        console.log("ready!");

        inboxListMngr.queryChatRoomList();
    });


    function addChatRoomList(data) {

        if (!data.message)
            return;

        if ("2" === data.chat_type || "5" === data.chat_type) {
            data.message = "파일 전송";
        } else if ("3" === data.chat_type) {
            data.message = "결제정보 전송";
        } else if ("4" === data.chat_type) {
            data.message = "결제정보 변경";
        }

        let content = '<li>';
        content +=  '<a href="inboxChatBox.php?chatroom_id=' + data.chatroom_id + '">';
        content += '<div>';
        content += '<p class="profile"><img src=' + data.not_me_profile_img_src + '></p>';
        if (data.read_yn < 1) {
            content += '<p class="new"><img src="../theme/basic/img/mobile/inbox/icon_newchat.png"></p>'
        }
        content += '<p class="name">' + data.not_me_name + '<span>' + data.chat_date + '</span></p>';
        content += '<p class="chat">' + data.message + '</p>';
        content += '</div>';
        content += '</a>';
        content += '</li>';

        $('.chat_list_data').append(content);
    }

    //
    let inboxListMngr = new function () {
        let idle = true;
        let interval = 3000;
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

                $(".chat_list_data").empty();

                for (let i = 0; i < data.length; i++) {
                    addChatRoomList(data[i]);
                }

                // 중복실행 방지 플래그 OFF
                idle = true;
            }
        }

        // 채팅내용 가져오기
        this.queryChatRoomList = function () {

            if (!idle) {
                return false;
            }

            idle = false;
            console.log("queryChatLis");

            //let url = g5_bbs_url + "/inbox_proc.php";
            let url = "../inbox/inbox_proc.php";

            let mbId = "<?php echo $member['mb_id']; ?>";

            // Ajax 통신
            xmlHttp2.open("GET", url + "?mb_id=" + mbId, true);
            xmlHttp2.send();
        }

        // 마지막 채팅내용 가져오기
        this.proc = function () {

            inboxListMngr.queryChatRoomList();

            /*
             // 중복실행 방지 플래그가 ON이면 실행하지 않음


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
        setInterval(this.proc, interval);
    }
</script>

