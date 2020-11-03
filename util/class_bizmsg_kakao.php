<?php
//include_once('../_common.php');
include_once('./_common.php');
//include_once(G5_PATH.'/head.sub.php');

//$cmid = 1;

abstract class biz_msg_type
{
    const biz_msg_code_1 = 1;
    const biz_msg_code_2 = 2;
    const biz_msg_code_3 = 3;
    const biz_msg_code_4 = 4;
    const biz_msg_code_5 = 5;
    const biz_msg_code_6 = 6;
    const biz_msg_code_7 = 7;
    const biz_msg_code_8 = 8;
    const biz_msg_code_9 = 9;
    const biz_msg_code_10 = 10;

}

class class_bizmsg_kakao
{
    public function insertBizMsgToDB($destPhone, $sendPhone, $msgType)
    {
        // 메세지 타입 확인.
        $destPhone = '01045217750';
        $sendPhone = '15442055';

        //$cmid = $cmid + 1;

        $test = date_create('now')->format('YmdHis');
        $cmid = $this->getCmid();
        $templeteCode = $this->getTempleteCode($msgType);
        $bizMsg = $this->getMsgBody($msgType);
        $smsMsgBody = $this->getSmsMsgBody($msgType);

        echo "<script>console.log( '6: " . $cmid . "' );</script>";

        $bizSql = "
            INSERT INTO BIZ_MSG
             SET    MSG_TYPE        = 6, 
                    CMID            = '" . $cmid . "', 
                    REQUEST_TIME    = " . $test . ", 
                    SEND_TIME       = " . $test . ", 
                    DEST_PHONE      = '" . $destPhone . "', 
                    SEND_PHONE      = '" . $sendPhone . "',  
                    MSG_BODY        = '" . $bizMsg . "', 
                    TEMPLATE_CODE   = '" . $templeteCode . "', 
                    SENDER_KEY      = '" . SENDER_KEY . "', 
                    NATION_CODE     = '82', 
                    ATTACHED_FILE   = 'kakao_button.json', 
                    RE_TYPE         = 'SMS', 
                    RE_BODY         = '" . $smsMsgBody . "' 
        ";

        sql_query($bizSql);
    }

    private function getCmid()
    {
        $cmid = 0;

        $sql = "SELECT biz_msg_cmid as CMID FROM ALLV_LAST_SEQ";
        $result = sql_fetch($sql);

        if ($result) {
            $cmid = $result['CMID'];

            echo "<script>console.log( '8: " . $cmid . " '  );</script>";

            if ($cmid > 1000000) {
                $date = intval($cmid / 1000000);
                $today = date_create('now')->format('Ymd');

                echo "<script>console.log( '7: " . $date . " " . $today . "'  );</script>";

                if ($date != $today) {
                    $cmid = $today * 1000000 + 1;
                } else {
                    $cmid++;
                }
            } else {
                $today = date_create('now')->format('Ymd');
                $cmid = $today * 1000000 + 1;
            }

            echo "<script>console.log( '9: " . $cmid . " '  );</script>";

            $sql = "UPDATE ALLV_LAST_SEQ SET biz_msg_cmid = '" . $cmid . "'";

            echo "<script>console.log( '10: " . $sql . " '  );</script>";

            $result = sql_fetch($sql);
        }

        return $cmid;
    }

    private function getTempleteCode($msgType)
    {
        $templeteCode = '';

        switch ($msgType) {
            case biz_msg_type::biz_msg_code_1:
                $templeteCode = "bizp_2020041316395721562341841";    //  쪽지 수신(2)(200413 수정)
                break;
            case biz_msg_type::biz_msg_code_2:
                $templeteCode = "bizp_2020041316391903031588917";   // 의뢰취소>To.성우(200413 수정)
                break;
            case biz_msg_type::biz_msg_code_3:
                $templeteCode = "bizp_2020041316380903031864916";    // 작업의뢰>성우지원시>To.일반(200413 수정)
                break;
            case biz_msg_type::biz_msg_code_4:
                $templeteCode = "bizp_2020041316362903031831915";     // 작업의뢰>채택시>To.성우(200413 수정)
                break;
            case biz_msg_type::biz_msg_code_5:
                $templeteCode = "bizp_2020041316342403031107914";     // 합의주문>작업완료>To.성우(200413 수정)
                break;
            case biz_msg_type::biz_msg_code_6:
                $templeteCode = "bizp_2020041316334303031166913";     // 합의주문>작업물도착>To.일반(200413 수정)
                break;
            case biz_msg_type::biz_msg_code_7:
                $templeteCode = "bizp_2020041316321203031079912";     // 합의주문>주문발생>To.성우(200413 수정)
                break;
            case biz_msg_type::biz_msg_code_8:
                $templeteCode = "bizp_2020041316310321562467840";     // 합의주문>견적금액도착>To.일반(200413 수정)
                break;
            case biz_msg_type::biz_msg_code_9:
                $templeteCode = "bizp_2020041316284303031003911";     // 결제완료>To.성우(200413 수정)
                break;
            case biz_msg_type::biz_msg_code_10:
                $templeteCode = "bizp_2020041316274103031088910";     // 결제완료>To.일반(200413 수정)
                break;
        }

        return $templeteCode;
    }

    private function getMsgBody($msgType)
    {
        $msgBody = "";

        // '\r\n'
        switch ($msgType) {
            case biz_msg_type::biz_msg_code_1:
                //  쪽지 수신(2)(200413 수정)
                $msgBody = '[올보이스]\r\n\r\n작업에 대한 문의 내용이 도착했습니다. 쪽지함을 확인해주세요.';
                break;
            case biz_msg_type::biz_msg_code_2:
                // 의뢰취소>To.성우(200413 수정)
                $msgBody = '[올보이스]\r\n\r\n고객님이 작업 의뢰를 취소하셨습니다.\r\n기타 문의가 있을 경우, 올보이스 채널쪽으로 연락 부탁드립니다.';
                break;
            case biz_msg_type::biz_msg_code_3:
                // 작업의뢰>성우지원시>To.일반(200413 수정)
                $msgBody = '[올보이스]\r\n\r\n';
                $msgBody = $msgBody.'고객님이 등록하신 작업에 성우님이 지원하였습니다.\r\n\r\n';
                $msgBody = $msgBody.'[로그인]-[올보이스 첫화면 하단 작업의뢰 섹션]-[고객님의 작업]-[지원현황]에서 상세한 지원현황 확인이 가능합니다.\r\n\r\n';
                $msgBody = $msgBody.'언제든 ‘쪽지’를 통해 작업 세부 내용을 조율하실 수 있고, 결제 후에는 성우님의 안심번호가 고객님에게 안내될 예정입니다.\r\n\r\n';
                $msgBody = $msgBody.'(해당 메시지는 고객님께서 등록하신 작업에 성우 지원이 있을 경우 발송됩니다.)';
                break;
            case biz_msg_type::biz_msg_code_4:
                // 작업의뢰>채택시>To.성우(200413 수정)
                $msgBody = '[올보이스]\r\n\r\n';
                $msgBody = $msgBody.'지원하신 작업에 채택되셨습니다. 결제가 완료되면 작업을 진행해주세요.\r\n\r\n';
                $msgBody = $msgBody.'[마이페이지]-[문의 주문 내역]-[해당 주문서] 에서 상세한 작업내용 확인이 가능합니다.\r\n\r\n';
                $msgBody = $msgBody.'고객님과는 언제든 ‘쪽지’를 통해 작업 세부 내용을 조율하실 수 있고, 결제 후에는 성우님의 안심번호가 고객님에게 안내될 예정입니다.';
                break;
            case biz_msg_type::biz_msg_code_5:
                // 합의주문>작업완료>To.성우(200413 수정)
                $msgBody = '[올보이스]\r\n\r\n고객님이 작업완료를 인증하셨습니다.\r\n감사합니다.';
                break;
            case biz_msg_type::biz_msg_code_6:
                // 합의주문>작업물도착>To.일반(200413 수정)
                $msgBody = '[올보이스]\r\n\r\n';
                $msgBody = $msgBody.'작업물이 도착했습니다.\r\n\r\n';
                $msgBody = $msgBody.'[마이페이지]-[문의 주문 내역]-[해당 주문서] 클릭 후, 하단에 첨부된 파일을 다운로드 할 수 있습니다.\r\n\r\n';
                $msgBody = $msgBody.'확인 후, 작업 완료 인증을 해주세요.';
                break;
            case biz_msg_type::biz_msg_code_7:
                // 합의주문>주문발생>To.성우(200413 수정)
                $msgBody = '[올보이스]\r\n\r\n';
                $msgBody = $msgBody.'합의주문의뢰가 도착했습니다.\r\n\r\n';
                $msgBody = $msgBody.'주문상세 내역은 [마이페이지]-[문의 주문 내역]에서 확인 가능하며 제시된 성우료확인과 조정요청은 해당 페이지 하단에서 진행 가능 하십니다.\r\n\r\n';
                $msgBody = $msgBody.'고객님과는 언제든 ‘쪽지’를 통해 작업 세부 내용을 조율하실 수 있고, 결제 후에는 성우님의 안심번호가 고객님에게 안내될 예정입니다.';
                break;
            case biz_msg_type::biz_msg_code_8:
                // 합의주문>견적금액도착>To.일반(200413 수정)
                $msgBody = '[올보이스]\r\n\r\n';
                $msgBody = $msgBody.'성우님의 견적합의 내용이 도착 하였습니다.\r\n\r\n';
                $msgBody = $msgBody.'[마이페이지]-[문의 주문 내역] 클릭 후, ‘거래합의중’인 주문을 클릭하시면 페이지 하단에 성우님의 견적 금액 확인이 가능하며 금액에 합의 하실경우 결제를 진행 해주세요.\r\n\r\n';
                $msgBody = $msgBody.'견적금액의 추가 합의가 필요한 경우 ‘쪽지’를 통해 조율이 가능하며, 결제 후에는 성우의 안심번호가 안내됩니다.';
                break;
            case biz_msg_type::biz_msg_code_9:
                // 결제완료>To.성우(200413 수정)
                $msgBody = '[올보이스]\r\n\r\n';
                $msgBody = $msgBody.'결제가 완료되었습니다. 작업을 진행해주세요.\r\n\r\n';
                $msgBody = $msgBody.'고객님에게 성우님의 안심번호가 안내 되었으며 작업세부 조율을 위해 고객님께서 전화를 걸 수 있습니다.\r\n\r\n';
                $msgBody = $msgBody.'작업 완료후 [마이페이지]-[문의 주문 내역]-[해당 주문서] 클릭하면 하단에 위치한 [작업 완료 파일 등록] 란에서 파일을 업로드하실 수 있습니다.\r\n\r\n';
                $msgBody = $msgBody.'첨부 후, 반드시 저장을 눌러주세요.';
                break;
            case biz_msg_type::biz_msg_code_10:
                // 결제완료>To.일반(200413 수정)
                $msgBody = '[올보이스]\r\n\r\n';
                $msgBody = $msgBody.'결제가 완료되었습니다.\r\n\r\n';
                $msgBody = $msgBody.'성우님의 안심번호를 프로필 페이지에서 확인해주세요.\r\n\r\n';
                $msgBody = $msgBody.'[올보이스 사이트 접속]-[성우 이름 검색]-[성우 이름] 클릭 후, 우측 프로필 사진 아래에서 안심번호를 확인 하실 수 있습니다.\r\n\r\n';
                $msgBody = $msgBody.'안심번호 통화로 작업 세부내용을 조율해주시면 작업이 더욱 쉬워집니다.';
                break;
        }

        return $msgBody;
    }

    // 80 자리 미만
    private function getSmsMsgBody($msgType) {
        $smsMsgBody = '';

        switch ($msgType) {
            case biz_msg_type::biz_msg_code_1:
                //  쪽지 수신
                $smsMsgBody = '작업에 대한 문의 내용이 도착했습니다. 쪽지함을 확인해주세요. -올보이스';
                break;
            case biz_msg_type::biz_msg_code_2:
                // 의뢰취소>To.성우
                $smsMsgBody = '고객님이 작업 의뢰를 취소하셨습니다. -올보이스-';
                break;
            case biz_msg_type::biz_msg_code_3:
                // 작업의뢰>성우지원시>To.일반
                $smsMsgBody = '고객님이 등록하신 작업에 성우가 지원하였습니다. -올보이스-';
                break;
            case biz_msg_type::biz_msg_code_4:
                // 작업의뢰>채택시>To.성우
                $smsMsgBody = "지원하신 작업에 채택되셨습니다. 결제가 완료되면 작업을 진행해주세요. -올보이스-";
                break;
            case biz_msg_type::biz_msg_code_5:
                // 합의주문>작업완료>To.성우
                $smsMsgBody = '고객님이 작업완료를 인증하셨습니다. -올보이스-';
                break;
            case biz_msg_type::biz_msg_code_6:
                // 합의주문>작업물도착>To.일반
                $smsMsgBody = '작업물 도착. 마이페이지에서 확인 후 작업완료 인증을 해주세요. -올보이스-';
                break;
            case biz_msg_type::biz_msg_code_7:
                // 합의주문>주문발생>To.성우
                $smsMsgBody = '합의주문의뢰가 도착했습니다. -올보이스-';
                break;
            case biz_msg_type::biz_msg_code_8:
                // 합의주문>견적금액도착>To.일반
                $smsMsgBody = "성우의 견적 금액이 도착 했습니다. 마이페이지에서 확인해주세요. -올보이스-";
                break;
            case biz_msg_type::biz_msg_code_9:
                // 결제완료>To.성우
                $smsMsgBody = "결제완료, 작업을 진행해주세요. 성우님의 안심번호를 안내하였습니다. -올보이스-";
                break;
            case biz_msg_type::biz_msg_code_10:
                // 결제완료>To.일반
                $smsMsgBody = "결제가 완료되어, 사이트 내에서 성우의 안심번호를 확인할 수 있습니다. -올보이스-";
                break;
        }

        return $smsMsgBody;
    }
}