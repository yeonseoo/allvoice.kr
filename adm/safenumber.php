<?php
$sub_menu = '200400';
include_once('./_common.php');


// 관리자 권한 확인
auth_check($auth[$sub_menu], 'r');

// 전체 성우 회원 수
// 안심번호 사용 가능 회선 수

// No, 아이디, 이름, 핸드폰, 안심번호


$sql_common = " from {$g5['mail_table']} ";


// 테이블의 전체 레코드수만 얻음
$sql = " select COUNT(*) as cnt {$sql_common} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$page = 1;

$sql = " select * {$sql_common} order by ma_id desc ";
$result = sql_query($sql);

$g5['title'] = '회원안심번호 관리';
include_once('./admin.head.php');

$colspan = 7;
?>

<?php
$sql_common = " from {$g5['member_table']} ";

$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'mb_point' :
            $sql_search .= " ({$sfl} >= '{$stx}') ";
            break;
        case 'mb_level' :
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
        case 'mb_tel' :
        case 'mb_hp' :
            $sql_search .= " ({$sfl} like '%{$stx}') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

$mb_gubun_arr = array("", "일반회원", "기업회원", "성우회원");

$_REQUEST['mb_gubun'] = (isset($_REQUEST['mb_gubun'])) ? $_REQUEST['mb_gubun'] : "3";
if ($_REQUEST['mb_gubun'] != "all") {
    $sql_search .= " AND mb_gubun='" . $_REQUEST['mb_gubun'] . "' ";
    $qstr .= "&mb_gubun=" . $_REQUEST['mb_gubun'];
}

if ($is_admin != 'super')
    $sql_search .= " and mb_level <= '{$member['mb_level']}' ";

if (!$sst) {
    $sst = "mb_datetime";
    $sod = "desc";
}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

// 탈퇴회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and mb_leave_date <> '' {$sql_order} ";
$row = sql_fetch($sql);
$leave_count = $row['cnt'];

// 차단회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and mb_intercept_date <> '' {$sql_order} ";
$row = sql_fetch($sql);
$intercept_count = $row['cnt'];

$listall = '<a href="' . $_SERVER['SCRIPT_NAME'] . '" class="ov_listall">전체목록</a>';

$g5['title'] = '회원관리';
include_once('./admin.head.php');

// $sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$sql = " select * {$sql_common} {$sql_search} {$sql_order} ";
$result = sql_query($sql);

$colspan = 16;
?>
    <div class="local_desc01 local_desc">
        <p>
            성우 회원의 안심번호는 다우기술(콜믹스)와 연동되어 관리됩니다.
        </p>
    </div>

    <div class="local_ov01 local_ov">
        <span class="btn_ov01"><span class="ov_txt">성우 회원수 </span>
            <span class="ov_num"> <?php echo number_format($total_count) ?>명 </span>
        </span>
        <a href="?sst=mb_intercept_date&amp;sod=desc&amp;sfl=<?php echo $sfl ?>&amp;stx=<?php echo $stx ?>"
           class="btn_ov01"> <span class="ov_txt">차단 </span><span
                    class="ov_num"><?php echo number_format($intercept_count) ?>명</span></a>
        <a href="?sst=mb_leave_date&amp;sod=desc&amp;sfl=<?php echo $sfl ?>&amp;stx=<?php echo $stx ?>"
           class="btn_ov01"> <span class="ov_txt">탈퇴  </span><span
                    class="ov_num"><?php echo number_format($leave_count) ?>명</span></a>
    </div>

    <form name="fmemberlist" id="fmemberlist" action="./member_list_update.php"
          onsubmit="return fmemberlist_submit(this);" method="post" width="880">
        <input type="hidden" name="sst" value="<?php echo $sst ?>">
        <input type="hidden" name="sod" value="<?php echo $sod ?>">
        <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
        <input type="hidden" name="stx" value="<?php echo $stx ?>">
        <input type="hidden" name="page" value="<?php echo $page ?>">
        <input type="hidden" name="token" value="">

        <div class="tbl_head01 tbl_wrap">
            <table width="880" style="table-layout:fixed; word-break:break-all;">
                <caption><?php echo $g5['title']; ?> 목록</caption>
                <thead>
                <tr>
                    <th scope="col" id="mb_list_index" width="80">
                        No.
                    </th>
                    <th scope="col" id="mb_list_id" width="150">
                        아이디
                    </th>
                    <th scope="col"  id="mb_list_username" width="200">
                        이름
                    </th>
                    <th scope="col" id="mb_list_mobile" width="150">
                        휴대폰
                    </th>
                    <th scope="col" id="mb_list_safe_number" width="150">
                        안심번호
                    </th>
                    <th scope="col" id="mb_list_callmix_number" width="150">
                        콜믹스번호
                    </th>
                    <th scope="col" id="mb_list_modify" width="100">
                        관리
                    </th>
                </tr>

                </thead>
                <tbody>
                <?php
                for ($i = 0; $row = sql_fetch_array($result); $i++) {
                    // 접근가능한 그룹수
                    $sql2 = " select count(*) as cnt from {$g5['group_member_table']} where mb_id = '{$row['mb_id']}' ";
                    $row2 = sql_fetch($sql2);
                    $group = '';
                    if ($row2['cnt'])
                        $group = '<a href="./boardgroupmember_form.php?mb_id=' . $row['mb_id'] . '">' . $row2['cnt'] . '</a>';

                    if ($is_admin == 'group') {
                        $s_mod = '';
                    } else {
                        $s_mod = '<a href="./member_form.php?' . $qstr . '&amp;w=u&amp;mb_id=' . $row['mb_id'] . '" class="btn btn_03">수정</a>';
                    }
                    $s_grp = '<a href="./boardgroupmember_form.php?mb_id=' . $row['mb_id'] . '" class="btn btn_02">그룹</a>';

                    $leave_date = $row['mb_leave_date'] ? $row['mb_leave_date'] : date('Ymd', G5_SERVER_TIME);
                    $intercept_date = $row['mb_intercept_date'] ? $row['mb_intercept_date'] : date('Ymd', G5_SERVER_TIME);

                    $mb_nick = get_sideview($row['mb_id'], get_text($row['mb_nick']), $row['mb_email'], $row['mb_homepage']);

                    $mb_id = $row['mb_id'];
                    $leave_msg = '';
                    $intercept_msg = '';
                    $intercept_title = '';
                    if ($row['mb_leave_date']) {
                        $mb_id = $mb_id;
                        $leave_msg = '<span class="mb_leave_msg">탈퇴함</span>';
                    } else if ($row['mb_intercept_date']) {
                        $mb_id = $mb_id;
                        $intercept_msg = '<span class="mb_intercept_msg">차단됨</span>';
                        $intercept_title = '차단해제';
                    }
                    if ($intercept_title == '')
                        $intercept_title = '차단하기';

                    $address = $row['mb_zip1'] ? print_address($row['mb_addr1'], $row['mb_addr2'], $row['mb_addr3'], $row['mb_addr_jibeon']) : '';

                    $bg = 'bg' . ($i % 2);

                    switch ($row['mb_certify']) {
                        case 'hp':
                            $mb_certify_case = '휴대폰';
                            $mb_certify_val = 'hp';
                            break;
                        case 'ipin':
                            $mb_certify_case = '아이핀';
                            $mb_certify_val = '';
                            break;
                        case 'admin':
                            $mb_certify_case = '관리자';
                            $mb_certify_val = 'admin';
                            break;
                        default:
                            $mb_certify_case = '&nbsp;';
                            $mb_certify_val = 'admin';
                            break;
                    }
                    ?>

                    <tr class="tr_member_list2" id="tr_member_list">
                        <td headers="mb_list_index" class="td_chk" >
                            <?php echo $i+1; ?>
                        </td>
                        <td  headers="mb_list_id" class="td_left" id="td_id">
                            <?php echo $row['mb_id']; ?>
                        </td>
                        <td headers="mb_list_username"  class="td_left">
                            <?php echo $row['mb_name']; ?>
                        </td>
                        <td headers="mb_list_mobile">
                            <?php echo get_text($row['mb_hp']); ?>
                        </td>
                        <td headers="mb_list_safe_number">
                            <?php
                            $safe_no_format = $row['mb_safe_no'];
                            if (12 == strlen($row['mb_safe_no'])) {
                                $safe_no_format = preg_replace("/([0-9]{4})([0-9]{4})([0-9]{4})/", "$1-$2-$3", $row['mb_safe_no']);
                            }
                            echo $safe_no_format;
                            ?>
                        </td>
                        <td headers="mb_list_callmix_number">
                        </td>
                        <td headers="mb_list_safe_number" >
                            <?php echo $s_mod ?>
                        </td>
                    </tr>

                    <?php
                }
                if ($i == 0)
                    echo "<tr><td colspan=\"" . $colspan . "\" class=\"empty_table\">자료가 없습니다.</td></tr>";
                ?>
                </tbody>
            </table>
        </div>

        <!--
        <div class="btn_fixed_top">
            <input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value"
                   class="btn btn_02">
            <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value"
                   class="btn btn_02">
            <?php // if ($is_admin == 'super') { ?>
                <a href="./member_form.php" id="member_add" class="btn btn_01">회원추가</a>
            <?php //} ?>

        </div>
        -->
        <div class="btn_fixed_top">
            <input class="btn btn_02" type="button" name="act_button" value="안심번호 맵핑" onclick="button1_click()">
        </div>

    </form>


    <script>
        function button1_click() {

            var userid = document.getElementsByName("td_mb_id");

            console.log("test");

            $('tbody > tr').each(function(index, tr) {

                let td = $(this).children();
                let text = td.eq(1).text();
                console.log(text);

                $.ajax({
                    type: "POST",
                    url: g5_admin_url+"/member_safe_number_regist.php",
                    dataType: "json",
                    data: { "mb_id" : td.eq(1).text(), "mb_hp" : td.eq(3).text()},
                    success: function(response) {

                        let safe_number = response.safe_no;

                        if(safe_number)
                            safe_number = safe_number.replace(/(\d{4})(\d{4})(\d{4})/, '$1-$2-$3');
                        else
                            safe_number = "";

                        td.eq(5).text(safe_number);
                        console.log(response);
                    },
                    error:function(e){
                        // alert("error");
                    }
                });
            });

            alert("조회를 완료하였습니다!");
            $('#tr_member_list2 tr:first td').each(function(k, v) {
                $('.tr_member_list2 tr').each(function() {
                   // console.log("1");
                });
            });


            $('#tr_member_list').each(function(k, v) {
                //console.log("test2");

                $('#td_id').each(function(index, tr) {
                  //  console.log(index);
                    //console.log(tr);
                });

               // let customerId = $(this).find(".td_mb_id").html();
                //console.log(customerId);

                //var customerId = $(this).find(".customerIDCell").html();
                //if (!this.rowIndex) return; // skip first row
                //var teamName = $(this).find("td").eq(0).html();
                //var selPosition = $(this).find('#position option:selected').val();

            });
        }

        function fmemberlist_submit(f) {

            if(document.pressed == "안심번호 맵핑") {
                if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
                    return false;
                }
            }


            var userid = document.getElementsByName("td_mb_id");
            for (var i=0; i<userid.length; i++) {
               console.log(userid);
            }



        }
    </script>

    <script>
        $(function () {
            $('#fmaillist').submit(function () {
                if (confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
                    if (!is_checked("chk[]")) {
                        alert("선택삭제 하실 항목을 하나 이상 선택하세요!!!.");
                        return false;
                    }

                    return true;
                } else {
                    return false;
                }
            });
        });
    </script>

<?php
include_once('./admin.tail.php');
?>