<?php
//include_once('./_common.php');
include_once('../shop/_common.php');

class chatMngr
{
    // func: 채팅방 리스트 조회
    public function queryChatRoomList($mb_id)
    {
        $sql = "select AA.chatroom_id, AA.mb_id, (select message from ALLV_CHAT_MESSAGE where chatroom_id = AA.chatroom_id order by message_id desc limit 1) as message
                from ALLV_CHAT_MEMBER as AA join ALLV_CHAT_ROOM as BB where BB.mb_id = 'admin' and  AA.chatroom_id = BB.chatroom_id";

        // 해당 아이디의 채팅방 리스트를 가져옴.
        //$sql = "SELECT chatroom_id FROM ALLV_CHAT_ROOM WHERE mb_id = 'admin'";
        //
        /*
        $sql = "SELECT a.chatroom_id, a.mb_id, b.message_id, b.chat_type, b.message, b.chat_date
                FROM ALLV_CHAT_ROOM a
                INNER JOIN (
                SELECT chatroom_id, message_id, chat_type, message, chat_date
                FROM
                (SELECT MAX(message_id) as max_id FROM ALLV_CHAT_MESSAGE group by chatroom_id ) c
                    INNER JOIN ALLV_CHAT_MESSAGE d on d.message_id = c.max_id
                ) b ON a.chatroom_id = b.chatroom_id and a.mb_id = 'admin' order by b.chat_date desc";
        */


        /*
        $sql = "SELECT a.chatroom_id, a.mb_id, b.message_id, b.chat_type, b.message, b.chat_date, D.mb_id as not_me_id, D.mb_name as not_me_name, b.read_yn 
                FROM ALLV_CHAT_ROOM a
                INNER JOIN (
                    SELECT chatroom_id, message_id, chat_type, message, chat_date, c.read_yn
                    FROM
                        (SELECT message_id as max_id, read_yn FROM ALLV_CHAT_MESSAGE
                        WHERE message_id = (SELECT MAX(message_id) FROM ALLV_CHAT_MESSAGE WHERE read_yn_mb_id = '$mb_id') group by chatroom_id ) c
                        INNER JOIN ALLV_CHAT_MESSAGE d on d.message_id = c.max_id 
                )   b ON a.chatroom_id = b.chatroom_id and a.mb_id = '$mb_id'
                left join
                (
                    select A.chatroom_id, A.mb_id, B.mb_name
                    from ALLV_CHAT_MEMBER A  left join g5_member as B On A.mb_id = B.mb_id WHERE A.mb_id != '$mb_id' group by  A.chatroom_id
                ) AS D on a.chatroom_id = D.chatroom_id order by b.chat_date desc";
        */

        /*
        $sql = "SELECT a.chatroom_id, a.mb_id, b.message_id, b.chat_type, b.message, b.chat_date, D.mb_id as not_me_id, D.mb_name as not_me_name, b.read_yn 
                FROM ALLV_CHAT_ROOM a
                INNER JOIN (
                    SELECT chatroom_id, message_id, chat_type, message, chat_date, c.read_yn
                    FROM
                        (SELECT MAX(message_id) as max_id, read_yn FROM ALLV_CHAT_MESSAGE  WHERE read_yn_mb_id = '$mb_id' group by chatroom_id ) c
                        INNER JOIN ALLV_CHAT_MESSAGE d on d.message_id = c.max_id
                )   b ON a.chatroom_id = b.chatroom_id and a.mb_id = '$mb_id'
                left join
                (
                    select A.chatroom_id, A.mb_id, B.mb_name
                    from ALLV_CHAT_MEMBER A  left join g5_member as B On A.mb_id = B.mb_id WHERE A.mb_id != '$mb_id' group by  A.chatroom_id
                ) AS D on a.chatroom_id = D.chatroom_id order by b.chat_date desc";
        */

        /*
        $sql = "SELECT a.chat_type, a.chatroom_id, a.mb_id, a.message_id, b.max_id, a.message, a.read_yn, a.read_yn_mb_id, b.read_yn_mb_id, a.mb_id, D.mb_id as not_me_id, D.mb_name as not_me_name
    FROM ALLV_CHAT_MESSAGE a
             INNER JOIN (
        SELECT chatroom_id,  MAX(message_id) as max_id, read_yn_mb_id, chat_date
        FROM ALLV_CHAT_MESSAGE
        GROUP BY chatroom_id
    ) b ON a.chatroom_id = b.chatroom_id and a.message_id = max_id
    left join
    (
        select A.chatroom_id, A.mb_id, B.mb_name
    from ALLV_CHAT_MEMBER A left join g5_member as B On A.mb_id = B.mb_id WHERE A.mb_id != '$mb_id' group by  A.chatroom_id
) AS D on a.chatroom_id = D.chatroom_id WHERE a.read_yn_mb_id = '$mb_id' order by a.chat_date desc";
        */
        $sql = "select f.chat_type, a.chatroom_id, a.mb_id, f.message_id, b.max_id, f.message, f.read_yn, f.read_yn_mb_id, f.read_yn_mb_id, f.chat_date, a.mb_id, D.mb_id as not_me_id, D.mb_name as not_me_name
from ALLV_CHAT_MEMBER as a
         left JOIN (
        SELECT chat_type, chatroom_id, MAX(message_id) as max_id, read_yn_mb_id, chat_date, message_id, message, read_yn
    FROM ALLV_CHAT_MESSAGE where read_yn_mb_id = '$mb_id'
    group by chatroom_id
) b ON a.chatroom_id = b.chatroom_id
  left join (
        SELECT chat_type, chatroom_id, read_yn_mb_id, chat_date, message_id, message, read_yn
        FROM ALLV_CHAT_MESSAGE where read_yn_mb_id = '$mb_id'
    ) f on f.message_id = b.max_id
         left join
    (
        select A.chatroom_id, A.mb_id, B.mb_name
         from ALLV_CHAT_MEMBER A
                  left join g5_member as B On A.mb_id = B.mb_id
         WHERE A.mb_id != '$mb_id'
         group by A.chatroom_id
     ) AS D on a.chatroom_id = D.chatroom_id where a.mb_id ='$mb_id'  order by f.chat_date desc";

        // 조회
        $result = sql_query($sql);

        // 데이터
        $data = array();

        for ($i = 0; $row = sql_fetch_array($result); $i++) {

            $mb_dir = substr($row['not_me_id'], 0, 2);
            $icon_url = G5_DATA_URL . '/member_image/' . $mb_dir . '/' . $row['not_me_id'] . '.gif';
            $icon_url = is_file(G5_DATA_PATH . '/member_image/' . $mb_dir . '/' . $row['not_me_id'] . '.gif') ? $icon_url : "../theme/basic/img/profileSample.jpg";
            // $gen_img_url = $mem_dt['mb_sex'] == "m" ? "../theme/basic/img/img_male.png" : "../theme/basic/img/img_female.png";

            $row['not_me_profile_img_src'] = $icon_url;

            $data[] = $row;
        }

        return $data;
    }

    public function checkChatroomId($toId, $mb_id)
    {
        $chatroom_id = 0;
        //$sql = "select chatroom_id from ALLV_CHAT_ROOM where mb_id = '$toId' and  chatroom_id = (select chatroom_id from ALLV_CHAT_ROOM where mb_id = '$mb_id')";

        $sql = "select A.chatroom_id
        from ALLV_CHAT_ROOM A left join ALLV_CHAT_MEMBER as B On A.chatroom_id = B.chatroom_id WHERE  A.mb_id = '$mb_id' AND B.mb_id = '$toId'";

        // 조회
        $result = sql_fetch($sql);
        $chatroom_id = $result['chatroom_id'];

        if (1 > $chatroom_id) {
            $sql = "SELECT MAX(chatroom_id) as chatroom_id FROM ALLV_CHAT_ROOM";

            // 조회
            $result = sql_fetch($sql);

            $chatroom_id = $result['chatroom_id'];
            $chatroom_id = $chatroom_id + 1;

            $sql = "INSERT INTO ALLV_CHAT_ROOM (chatroom_id, mb_id, date_created) VALUES ('$chatroom_id', '$toId', NOW())";
            sql_query($sql);

            $sql = "INSERT INTO ALLV_CHAT_ROOM (chatroom_id, mb_id, date_created) VALUES ('$chatroom_id', '$mb_id', NOW())";
            sql_query($sql);

            $sql = "INSERT INTO ALLV_CHAT_MEMBER (chatroom_id, mb_id) VALUES ('$chatroom_id', '$toId')";
            sql_query($sql);

            $sql = "INSERT INTO ALLV_CHAT_MEMBER (chatroom_id, mb_id) VALUES ('$chatroom_id', '$mb_id')";
            sql_query($sql);
        }

        return $chatroom_id;
    }

    public function queryChatMembers($chatroomId)
    {
        //$sql = "SELECT * FROM ALLV_CHAT_MEMBER WHERE chatroom_id = '$chatroomId'";

        $sql = "select A.chatroom_id, A.mb_id, B.mb_name
                from ALLV_CHAT_MEMBER A left join g5_member as B On A.mb_id = B.mb_id WHERE chatroom_id = {$chatroomId}";

        //$sql = "SELECT * FROM ALLV_CHAT_MEMBER";

        // 조회
        $result = sql_query($sql);

        // 데이터
        $data = array();

        for ($i = 0; $row = sql_fetch_array($result); $i++) {

            $mb_dir = substr($row['mb_id'], 0, 2);
            $icon_url = G5_DATA_URL . '/member_image/' . $mb_dir . '/' . $row['mb_id'] . '.gif';
            $icon_url = is_file(G5_DATA_PATH . '/member_image/' . $mb_dir . '/' . $row['mb_id'] . '.gif') ? $icon_url : "../theme/basic/img/profileSample.jpg";

            $row['profile_img_src'] = $icon_url;

            $data[] = $row;
        }

        return $data;
    }
    public function queryChatRoomAllList($mb_id)
    {
        $sql = "select a.chatroom_id, f.chat_date from ALLV_CHAT_ROOM as a
                left JOIN (
                        SELECT  chat_type,
                                chatroom_id,
                                MAX(message_id) as max_id,
                                read_yn_mb_id,
                                chat_date,
                                message_id,
                                message,
                                read_yn
                        FROM ALLV_CHAT_MESSAGE
                        group by chatroom_id
                ) b ON a.chatroom_id = b.chatroom_id
                left join (
                        SELECT chat_type, chatroom_id, read_yn_mb_id, chat_date, message_id, message, read_yn
                        FROM ALLV_CHAT_MESSAGE
                ) f on f.message_id = b.max_id group by a.chatroom_id order by f.chat_date desc";

        // 조회
        $result = sql_query($sql);

        // 데이터
        $data = array();

        for ($i = 0; $row = sql_fetch_array($result); $i++) {

            $data[] = $row;
        }

        return $data;
    }
}


