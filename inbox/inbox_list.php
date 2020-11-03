<?php
include_once('./_common.php');

if ($is_guest)
    alert('회원만 이용하실 수 있습니다.', G5_URL);

if (G5_IS_MOBILE) {
    //include_once(G5_MSHOP_PATH . '/voiceMypage.php');
    return;
}

include_once('./_head.php');
?>
    <div class="commonLocation">
        <ul>
            <li><img src="../theme/basic/img/img_home2.png"/></li>
            <li>1:1 문의</li>
        </ul>
    </div>

    <div id="message_wrap">
        <div class="message_box">
            <div class="top_area">
                <p class="title">1:1 메시지</p>
                <p class="text1">내 대화 가능 시간 : 평일 오전 9시 ~ 오후 6시<a href="#none"><img src="../theme/basic/img/inbox/button_chat_option.gif"></a>
                </p>
            </div>
            <div class="body_area">
                <div class="left_box">
                    <ul class="chat_room_list">
                        <li>
                            <a href="#none">
                                <div>
                                    <p class="profile"><img src="../theme/basic/img/inbox/img_profile.jpg"></p>
                                    <p class="new"><img src="../theme/basic/img/inbox/icon_newchat.gif"></p>
                                    <p class="name">성우 오진훈<span>20:39</span></p>
                                    <p class="chat">아뇨 견적가는 50만원이구요~! 제가 말씀드리는건 추가로 녹음실을 빌리는 빌리는 빌리는</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#none">
                                <div>
                                    <p class="profile"><img src="../theme/basic/img/inbox/img_profile.jpg"></p>
                                    <p class="name">류혜윤<span>05:18</span></p>
                                    <p class="chat">파일을 전달 하였습니다</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#none">
                                <div>
                                    <p class="profile"><img src="../theme/basic/img/inbox/img_profile.jpg"></p>
                                    <p class="name">성우 안지혜<span>어제</span></p>
                                    <p class="chat">네^^ 말씀 해주세요</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#none">
                                <div>
                                    <p class="profile"><img src="images/img_profile.jpg"></p>
                                    <p class="name">엔지니어 장효진<span>17년 5월 26일</span></p>
                                    <p class="chat">네~ 대본 확인 해보겠습니다 ~<br/>일단 그 분량이면 30만원 이상 고려해주세요 세요 세요</p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="right_box">
                    <div class="user_info">
                        <p class="profile"><img src="../theme/basic/img/inbox/img_profile.jpg"></p>
                        <p class="name">류혜윤</p>
                        <a href="#none" class="favorite on"></a>
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
                        <textarea id="inbox_message"></textarea>
                        <p class="btn_box">
                            <a href="#none"><img src="../theme/basic/img/inbox/icon_photo.gif"></a>
                            <a type="file" href="javascript:" class="select_file"><img src="../theme/basic/img/inbox/icon_file.gif"></a>
                            <input type="file"><img src="../theme/basic/img/inbox/icon_file.gif"></a>
                            <a href="javascript:" class="inbox_send_message"><img src="../theme/basic/img/inbox/button_01.gif"></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- //메시지 -->


    <script type="text/javascript">

        $(document).ready(function () {
            console.log("ready!");

            inboxListMngr.queryChatLis();
            chatManager.queryChatLis();
        });

        $(function () {
            $(".inbox_send_message").click(function () {
                console.log("input message:  " + $("#inbox_message").val());

                let message = $("#inbox_message").val();
                let today = new Date();
                console.log("today" + today);
                // make_chat_dialog_box(true, "test", "test2", message, new Date());
                // make_op_chat_dialog_box("test", "test2", message);

                chatManager.write(this);

                // clear message
                $("#inbox_message").val("");
            });

            $(".select_file").click(function () {
                console.log("select_file");

                function fileUpload(fis) {
                    var str = fis.value;
                    alert("파일네임: " + fis.value.substring(str.lastIndexOf("\\") + 1));
                }

                var reader = new FileReader();

                reader.onload = function (e) {
                    var data3ds = e.target.result.split(',');
                    //  work2(data3ds);
//                    readFile(index + 1);
                };

            });
        });


        function make_chat_dialog_box(isQuery, to_user_id, to_user_name, message, inbox_date) {
            console.log(inbox_date);

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

            //let modal_content = '<div id="user_dialog_'+to_user_id+'" class="user_dialog" title="You have chat with '+to_user_name+'">';
            //modal_content += '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
            //modal_content += '</div>';
            //modal_content += '<div class="form-group">';
            //modal_content += '<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control"></textarea>';
            //modal_content += '</div><div class="form-group" align="right">';
            //modal_content+= '<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat">Send</button></div></div>';
            $('.chat_area').append(modal_content);

            // o.scrollTop = o.scrollHeight;
            //$('.chat_area').scrollTop(0);
            //let o = document.getElementById('chat_box');
            //o.scrollTop = o.scrollHeight;
            $(".chat_box").scrollTop($(".chat_area").height());

            if (true == isQuery) {
                // Jquery
                //chatManager.write(this);
            }
            // Jquery
            //chatManager.write(this);
        }

        function make_op_chat_dialog_box(to_user_id, to_user_name, message, inbox_date) {

            console.log("make_op_chat_dialog_box");

            console.log(message);

            console.log(getFormatDate(to_date2(inbox_date)));

            let modal_content = '<div class="opponent_chat">';
            modal_content += '<p class="profile"><img src="../theme/basic/img/inbox/img_profile.jpg"></p>';
            modal_content += '<div class="chat">';
            modal_content += '<p class="name">류혜윤</p>';
            modal_content += '<div class="box">';
            modal_content += '<span class="arrow"></span>';
            //modal_content += '<p>넵 성우님! 대본 먼저 전달드리겠습니다!<br/>대본보시고 견적 나오시면 전달부탁드리겠습니다!</p>';
            modal_content += '<p>' + message + '</p>';
            modal_content += '<span class="date">8월 19일 13:45</span>';
            modal_content += '</div>';
            modal_content += '</div>';
            modal_content += '</div>';

            $('.chat_area').append(modal_content);

            $(".chat_box").scrollTop($(".chat_area").height());
        }

        function addFileMessageToChatBox() {

            let modal_content = '<div class="opponent_chat">
            modal_content = '<p class="profile"><img src="../theme/basic/img/inbox/img_profile.jpg"></p>'
            modal_content = '<div class="chat">'
            modal_content = '<p class="name">류혜윤</p>'
            modal_content = '<div class="box">'
            modal_content = '<span class="arrow"></span>'
            modal_content = '<p>결제했습니다!! 녹음 진행 부탁드려요!<br/>감사합니다~!</p>'
            modal_content = '<span class="date">8월 19일 13:45</span>'
            modal_content = '</div>'
            modal_content = '<div class="file">'
            modal_content = '<span class="arrow"></span>'
            modal_content = '<p class="text1">파일 : 김주호 성우님 최종대본.txt</p>'
            modal_content = '<p class="text2">1.9MB<a href="#none">다운로드</a></p>'
            modal_content = '<span class="date">8월 19일 13:45</span>
            modal_content = '</div>
            modal_content = '</div>
            modal_content = '</div>


            let modal_content = '<div class="opponent_chat">';
            modal_content += '<p class="profile"><img src="../theme/basic/img/inbox/img_profile.jpg"></p>';
            modal_content += '<div class="chat">';
            modal_content += '<p class="name">류혜윤</p>';
            modal_content += '<div class="box">';
            modal_content += '<span class="arrow"></span>';
            //modal_content += '<p>넵 성우님! 대본 먼저 전달드리겠습니다!<br/>대본보시고 견적 나오시면 전달부탁드리겠습니다!</p>';
            modal_content += '<p>' + message + '</p>';
            modal_content += '<span class="date">8월 19일 13:45</span>';
            modal_content += '</div>';
            modal_content += '</div>';
            modal_content += '</div>';

            $('.chat_area').append(modal_content);

            $(".chat_box").scrollTop($(".chat_area").height());

        }

        function makeChatRoomList(data) {

            let imageSrc = '';
            let mb_id = data.mb_id;

            console.log(data);

            //$member['mb_id']

            <?php
            $mb_id = '';// '<script>document.write (mb_id);</script>';
            $mb_dir = substr($mb_id, 0, 2);
            $icon_url = G5_DATA_URL . '/member_image/' . $mb_dir . '/' . $mb_id . '.gif';
            $icon_url = is_file(G5_DATA_PATH . '/member_image/' . $mb_dir . '/' . $mb_id . '.gif') ? $icon_url : "../theme/basic/img/profileSample.jpg";
            //$icon_url = "../theme/basic/img/profileSample.jpg";
            //$gen_img_url = $mem_dt['mb_sex'] == "m"
            ?>

            imageSrc = "<?php echo $icon_url; ?>";

            console.log(imageSrc);

            let content = '<li>';
            content += '<a href="#none">';
            content += '<div>';
            content += '<p class="profile"><img src=' + imageSrc + '></p>';
            content += '<p class="new"><img src="../theme/basic/img/inbox/icon_newchat.gif"></p>';
            content += '<p class="name">' + data.not_me_name + '<span>' + data.chat_date + '</span></p>';
            content += '<p class="chat">' + data.message + '</p>';
            content += '</div>';
            content += '</a>';
            content += '</li>';

            console.log(content);

            $('.chat_room_list').append(content);
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
            return month + '월 ' + day + '일 ' + date.getHours() + ':' + leadingZeros(date.getSeconds(), 2);
        }

        function to_date2(date_str) {
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
            var idle = true;
            //var interval = 500;
            var interval = 10000;
            var xmlHttp = new XMLHttpRequest();
            let xmlHttp2 = new XMLHttpRequest();
            var finalDate = '';
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

                    console.log("http2");

                    // JSON 포맷으로 Parsing
                    res = JSON.parse(xmlHttp2.responseText);
                    // finalDate = res.date;

                    // 채팅내용 보여주기
                    //chatManager.show(res.data);
                    let data = res.data;

                    let mb_id = "<?php echo $member['mb_id']; ?>";


                    for (let i = 0; i < data.length; i++) {

                        makeChatRoomList(data[i]);

                        /*
                        if (mb_id == data[i].mb_id) {
                            make_chat_dialog_box(false, data[i].mb_id, data[i].op_id, data[i].msg, data[i].date);
                        } else {
                            make_op_chat_dialog_box(data[i].mb_id, data[i].op_id, data[i].msg);
                        }
                                                */

                        //dt = document.createElement('dt');
                        //dt.appendChild(document.createTextNode(data[i].name));
                        //o.appendChild(dt);

                        //dd = document.createElement('dd');
                        //dd.appendChild(document.createTextNode(data[i].msg));
                        //o.appendChild(dd);
                    }

                    // 중복실행 방지 플래그 OFF
                    //idle = true;
                }
            }

            // 채팅내용 가져오기
            this.queryChatLis = function () {

                let url = g5_bbs_url + "/inbox_proc.php";

                // Ajax 통신
                xmlHttp2.open("GET", url + "?mb_id=admin", true);
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

                let url = g5_bbs_url + "/inbox_proc.php";

                // Ajax 통신
                xmlHttp.open("GET", url + "?op_id=voicetest1&lastno=" + lastno, true);
                xmlHttp.send();

                console.log("interval2");
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

            // 채팅내용 작성하기
            this.write = function (frm) {
                console.log("write");

                let xmlHttpWrite = new XMLHttpRequest();

                let chatroom_id = '1';
                let chat_type = '1';
                let mb_id = "<?php echo $member['mb_id']; ?>";
                let op_id = "<?php echo $_GET['me_recv_mb_id']; ?>";
                //$('.chat_area');
                //$("#inbox_message").val();`
                let message = $("#inbox_message").val();
                let param = [];

                // 이름이나 내용이 입력되지 않았다면 실행하지 않음
                /*
                if(name.length == 0 || msg.length == 0)
                {
                    return false;
                }
                */

                // chatroom_id, message_id, chat_type, mb_id, message, read_yn, chat_date

                // POST Parameter 구축
                param.push("chatroom_id=" + encodeURIComponent(chatroom_id));
                param.push("chat_type=" + encodeURIComponent(chat_type));
                param.push("mb_id=" + encodeURIComponent(mb_id));
                param.push("message=" + encodeURIComponent(message));
                //param.push("msg=" + encodeURIComponent(msg));

                let url = g5_bbs_url + "/inbox_insert.php";
                // Ajax 통신
                xmlHttpWrite.open("POST", url, true);
                xmlHttpWrite.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlHttpWrite.send(param.join('&'));

                // 내용 입력란 비우기
                //frm.msg.value = '';

                // 채팅내용 갱신
                chatManager.proc();

            }

            // interval에서 지정한 시간 후에 실행
            setInterval(this.proc, interval);
        }

        let chatManager = new function () {

            var idle = true;
            //var interval = 500;
            var interval = 3000;
            var xmlHttp = new XMLHttpRequest();
            let xmlHttp2 = new XMLHttpRequest();
            var finalDate = '';
            let lastno = 0;
            let messsageId = 0;

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

                    // JSON 포맷으로 Parsing
                    res = JSON.parse(xmlHttp.responseText);
                    // finalDate = res.date;

                    // 채팅내용 보여주기
                    //chatManager.show(res.data);
                    let data = res.data;

                    console.log(data);

                    let mb_id = "<?php echo $member['mb_id']; ?>";


                    for (let i = 0; i < data.length; i++) {

                        // make_chat_dialog_box(false, data[i].mb_id, "", data[i].message, data[i].chat_date);
                        // make_op_chat_dialog_box(data[i].mb_id, "", data[i].message, data[i].chat_date);

                        if (mb_id === data[i].mb_id) {
                            make_chat_dialog_box(false, data[i].mb_id, "", data[i].message, data[i].chat_date);
                        } else {
                            make_op_chat_dialog_box(data[i].mb_id, "", data[i].message, data[i].chat_date);
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

            // 채팅내용 가져오기
            this.queryChatLis = function () {

                let url = g5_bbs_url + "/inbox_query.php";

                // Ajax 통신
                xmlHttp.open("GET", url + "?mb_id=admin", true);
                xmlHttp.send();
            }

            // 마지막 채팅내용 가져오기
            this.proc = function () {

                console.log("interval666");

                // 중복실행 방지 플래그가 ON이면 실행하지 않음
                if (!idle) {
                    return false;
                }

                // 중복실행 방지 플래그 ON
                idle = false;

                let url = g5_bbs_url + "/inbox_proc.php";

                // Ajax 통신
                xmlHttp.open("GET", url + "?type=1&op_id=voicetest1&message_id=" + messsageId, true);
                xmlHttp.send();

                console.log("interval555");
            }

            // 채팅내용 보여주기
            this.show = function (data) {
                //console.log("");
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
                }

                // 가장 아래로 스크롤
                //o.scrollTop = o.scrollHeight;

            }

            // 채팅내용 작성하기
            this.write = function (frm) {
                console.log("write");

                let xmlHttpWrite = new XMLHttpRequest();

                let chatroom_id = '1';
                let chat_type = '1';
                let mb_id = "<?php echo $member['mb_id']; ?>";
                let op_id = "<?php echo $_GET['me_recv_mb_id']; ?>";
                //$('.chat_area');
                //$("#inbox_message").val();`
                let message = $("#inbox_message").val();
                let param = [];

                // 이름이나 내용이 입력되지 않았다면 실행하지 않음
                /*
                if(name.length == 0 || msg.length == 0)
                {
                    return false;
                }
                */

                // chatroom_id, message_id, chat_type, mb_id, message, read_yn, chat_date

                // POST Parameter 구축
                param.push("chatroom_id=" + encodeURIComponent(chatroom_id));
                param.push("chat_type=" + encodeURIComponent(chat_type));
                param.push("mb_id=" + encodeURIComponent(mb_id));
                param.push("message=" + encodeURIComponent(message));
                //param.push("msg=" + encodeURIComponent(msg));


                let url = g5_bbs_url + "/inbox_insert.php";
                // Ajax 통신
                xmlHttpWrite.open("POST", url, true);
                xmlHttpWrite.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlHttpWrite.send(param.join('&'));

                // 내용 입력란 비우기
                //frm.msg.value = '';

                console.log("write ==============");

                // 채팅내용 갱신
                chatManager.proc();

            }

            // interval에서 지정한 시간 후에 실행
            setInterval(this.proc, interval);
        }

    </script>

<?php
include_once("./_tail.php");
?>