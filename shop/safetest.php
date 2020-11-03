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
if (1) {
    $bizId = "allvoice";
    $mmdd = date("md");
    $secure = "67aec2b09241800da27133ea01d58a4d676034feb3a0c0a4dd2f907458c26c74";
    $secureCode = hash("sha256", $bizId . $mmdd . $secure);
    //echo $secureCode;
    $s_url = "https://bizapi.callmix.co.kr/biz050/BZV100?secureCode=" . $secureCode . "&bizId=" . $bizId . "&monthDay=" . $mmdd . "&selGbn=3&reqCnt=1";

    echo $s_url;
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

        echo  $vno_str;

        // 리소스 해제를 위해 세션 연결 닫음
        curl_close($ch);
    } else {
        // curl 라이브러리가 설치 되지 않음. 다른 방법 알아볼 것
    }
    $vno_arr = json_decode($vno_str);
    //echo $vno_str;
    //print_r($vno_arr->vnList);
    if ($vno_arr->resCd == "SUCCESS") {

        echo "gogogogo ";
        $vno = $vno_arr->vnList[0]->vn;
        //echo "<br>vn = ".$vno_arr->vnList[0]->vn."<br>";
        //https://bizapi.callmix.co.kr/biz050/BZV210?secureCode= 378767ad6a190b3ea595225a0f52109d6c15c72df9b4ceba55bf4fbb8bf936e1&bizId=aaa&mo nthDay=0519&tkGbn=1&rn=021231234&vn=05041231234&brNm=맛있는치킨
        $s2_url = "https://bizapi.callmix.co.kr/biz050/BZV210?secureCode=" . $secureCode . "&bizId=" . $bizId . "&monthDay=" . $mmdd . "&tkGbn=1&rn=" . str_replace("-", "", $mem_dt['mb_hp']) . "&vn=" . $vno . "&brNm=" . $mem_dt['mb_id'];

        echo $s2_url;

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

        echo $vno_res;

        //print_r($vno_res);print_r($vno);
        if ($vno_res->resCd == "SUCCESS") {
            $vtel = $vno;
            echo $vtel;
        }
    }



    echo "test";

}
