<?php

include_once('../shop/_common.php');

class voiceProjectItem
{
    // public index
    public $projectId;          // 프로젝트 아이디
    public $categoryId;         // 카테고리
    public $title;              // 제목
    public $pricing;            // 가격
    public $fromMemberId;       // 성우
    public $toMemberId;         // 회원
    public $regDate;            // 등록 날짜.
}

class voiceProjectManager
{
    // $sql = "INSERT INTO ALLV_CHAT_MESSAGE(chatroom_id, chat_type, mb_id, message, read_yn, chat_date)

    public function addVoiceProject2($chatroom_id, $mb_id, $message)
    {
        global $g5;

        // 사용자를 확인.
        $sql = "SELECT mb_id AS to_id FROM ALLV_CHAT_MEMBER WHERE chatroom_id = '$chatroom_id' AND mb_id != '$mb_id'";
        $result = sql_fetch($sql);
        $to_id = $result['to_id'];      // 상대방 아이디.
        //

        $it_id = time();
        // $it_maker = $member['mb_id'];

        //$jsonData = json_decode(html_entity_decode($message));
        //$title = $jsonData->{'title'};

        //$jsonData = stripslashes($message);

        $test = stripslashes($message);

        $jsonData = json_decode($test);

        // $last = json_last_error_msg();




        $test = addslashes($jsonData->title);
        //var_dump($jsonData);

        // voiceProject.title = $("#payment_title").val();
        // voiceProject.category = $("#payment_category option:selected").val();
        // voiceProject.pricing = $("#payment_pricing").val();

        $sql_common = " ca_id               = '$jsonData->category',
				        it_maker            = '$to_id',
				        it_origin           = '$mb_id',
                        it_name             = '" . addslashes($jsonData->title) . "', 
                        it_explan           = '',
                        it_explan2          = '$last',
                        it_mobile_explan    = '$test',
                        it_price            = '$jsonData->pricing',
				        it_use              = '1',
                        it_soldout          = '0',
                        it_stock_qty        = '9999',
                        it_ip               = '{$_SERVER['REMOTE_ADDR']}',
                        it_info_gubun       = 'etc',
				        it_basic            = '기본설명',
				        it_head_html        = ' ',
				        it_tail_html        = ' ',
				        it_mobile_head_html = ' ',
				        it_mobile_tail_html = ' ',
				        it_info_value       = ' ',
				        it_use_avg          = '0.0',
				        it_shop_memo        = ' ',
                        it_1                = '',
                        it_2                = '',
                        it_3                = '',
                        it_4                = '',
                        it_5                = '',
                        it_6                = '',
                        it_view_time        = NOW(),
				        it_gubun            = '3' ";


        $sql_common .= " , it_time = '" . G5_TIME_YMDHIS . "' ";
        $sql_common .= " , it_update_time = '" . G5_TIME_YMDHIS . "' ";

        $sql = "INSERT INTO {$g5['g5_shop_item_table']}
        	    SET it_id = '$it_id',
        		{$sql_common}";

        $result = sql_query($sql);

        $od_id = get_uniqid();

        $sql = " insert {$g5['g5_shop_cart_table']}
					set it_id             = '" . $it_id . "',
						od_id             = '" . $od_id . "',
						mb_id             = '" . $mb_id . "',
						ct_qty            = '1',
						ct_status         = '거래합의중',
						ct_price          = '" . $jsonData->pricing . "',
						it_name           = '" . addslashes($jsonData->title) . "',
						ct_time           = '" . G5_TIME_YMDHIS . "',
						ct_ip             = '" . $_SERVER['REMOTE_ADDR'] . "',
						ct_direct         = '1',
						ct_select         = '1',
						ct_select_time    = '" . G5_TIME_YMDHIS . "'
						";

        $result = sql_query($sql);

        $sql = "select * from  {$g5['member_table']} where mb_id = '$to_id'";
        $clientMember = sql_fetch($sql);

        $od_tax_mny = round($jsonData->pricing / 1.1);
        $od_vat_mny = $jsonData->pricing - $od_tax_mny;
        $od_free_mny = 0;
        /*
        if($default['de_tax_flag_use']) {
            $od_tax_mny = (int)$_POST['comm_tax_mny'];
            $od_vat_mny = (int)$_POST['comm_vat_mny'];
            $od_free_mny = (int)$_POST['comm_free_mny'];
        }
        */
        // $od_tax_flag = $default['de_tax_flag_use'];


        // 주문서에 입력
        $sql = " insert {$g5['g5_shop_order_table']}
					set od_id             = '" . $od_id . "',
						mb_id             = '" . $member['mb_id'] . "',
						od_pwd            = '" . $member['mb_password'] . "',
						od_name           = '" . $member['mb_name'] . "',
						od_email          = '" . $member['mb_email'] . "',
						od_tel            = '" . $member['mb_hp'] . "',
						od_hp             = '" . $member['mb_hp'] . "',
						od_zip1           = '" . $member['mb_zip1'] . "',
						od_zip2           = '" . $member['mb_zip2'] . "',
						od_addr1          = '" . $member['mb_addr1'] . "',
						od_addr2          = '" . $member['mb_addr2'] . "',
						od_addr3          = '" . $member['mb_addr3'] . "',
						od_addr_jibeon    = '" . $member['mb_addr_jibeon'] . "',
						od_b_name         = '" . $member['mb_name'] . "',
						od_b_tel          = '" . $member['mb_hp'] . "',
						od_b_hp           = '" . $member['mb_hp'] . "',
						od_b_zip1         = '" . $member['mb_zip1'] . "',
						od_b_zip2         = '" . $member['mb_zip2'] . "',
						od_b_addr1        = '" . $member['mb_addr1'] . "',
						od_b_addr2        = '" . $member['mb_addr2'] . "',
						od_b_addr3        = '" . $member['mb_addr3'] . "',
						od_b_addr_jibeon  = '" . $member['mb_addr_jibeon'] . "',
						od_deposit_name   = '" . $member['mb_name'] . "',
						od_memo           = '" . $_REQUEST['od_memo'] . "',
						od_cart_count     = '1',
						od_cart_price     = '" . $jsonData->pricing . "',
						od_origin_price   = '" . $jsonData->pricing . "',
						od_cart_coupon    = '0',
						od_send_cost      = '0',
						od_send_coupon    = '0',
						od_send_cost2     = '0',
						od_coupon         = '0',
						od_receipt_price  = '0',
						od_receipt_point  = '0',
						od_misu           = '" . $jsonData->pricing . "',
						od_pg             = '',
						od_escrow         = '',
						od_tax_flag       = '',
						od_tax_mny        = '" . $od_tax_mny . "',
						od_vat_mny        = '" . $od_vat_mny . "',
						od_free_mny       = '" . $od_free_mny . "',
						od_status         = '거래합의중',
						od_shop_memo      = '',
						od_gubun          = '2',
						od_time           = '" . G5_TIME_YMDHIS . "',
						od_ip             = '" . $_SERVER['REMOTE_ADDR'] . "',
						od_test           = '',
						chatroom_id       = '$chatroom_id'
						";

        $result = sql_query($sql);

        $projectInfo = array();
        $projectInfo['project_id'] = $it_id;
        $projectInfo['project_order_id'] = $od_id;
        return $projectInfo;
    }

    public function updateVoiceProject($od_id)
    {
        global $g5;

        // 결제 정보
        $sql = " SELECT chatroom_id FROM {$g5['g5_shop_order_table']} WHERE od_id = '$od_id'";
        $result = sql_fetch($sql);

        if ($result['chatroom_id']) {
            // 과거 주문지를 확인
            $sql = "SELECT chatroom_id, message_id, chat_type, mb_id, message, read_yn, read_yn_mb_id, chat_date, project_id, project_order_id, file_path 
                    FROM ALLV_CHAT_MESSAGE WHERE project_order_id = '$od_id' AND chatroom_id = '" . $result['chatroom_id'] . "' LIMIT 1";
            $result = sql_fetch($sql);

            if ($result['chatroom_id']) {

                $members = array();
                $sql = "SELECT mb_id FROM ALLV_CHAT_MEMBER WHERE chatroom_id = '{$result['chatroom_id']}'";
                $members = sql_query($sql);

                for ($i = 0; $row = sql_fetch_array($members); $i++) {

                    $sqlMessage = "INSERT INTO ALLV_CHAT_MESSAGE(chatroom_id, chat_type, mb_id, message, read_yn, read_yn_mb_id, chat_date, project_id, project_order_id, file_path)
                    VALUES('{$result['chatroom_id']}', 4, '{$result['mb_id']}', '{$result['message']}', 0,  '{$row['mb_id']}', NOw(), '{$result['project_id']}', '{$result['project_order_id']}', '')";

                    sql_query($sqlMessage);
                }
            }
        }
    }

    public function addVoiceProject($vpItem)
    {
    }

    public function addNonCommercialProject($vcItem)
    {

    }

    public
    function checkNonCommercialProject()
    {
    }
}