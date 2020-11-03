<?php
include_once('./_common.php');

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/search.php');
    return;
}

$g5['title'] = "상품 검색 결과";
include_once('./_head.php');

$page_rows = 25;
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$_REQUEST['orderby'] = isset($_REQUEST['orderby']) ? $_REQUEST['orderby'] : "mb_no";

$q       = utf8_strcut(get_search_string(trim($_GET['q'])), 30, "");

if ($q) {
    $arr = explode(" ", $q);
    $detail_where = array();
    for ($i=0; $i<count($arr); $i++) {
        $word = trim($arr[$i]);
        if (!$word) continue;

        $concat = array();
        $concat[] = "a.mb_name";
        $concat[] = "a.mb_id";
        //$concat[] = "a.it_id";
        //$concat[] = "a.it_basic";
        $concat_fields = "concat(".implode(",' ',",$concat).")";

        $detail_where[] = $concat_fields." like '%$word%' ";

        // 인기검색어
        insert_popular($concat, $word);
    }

    $where[] = "(".implode(" and ", $detail_where).")";
}

if ($q) {
    $arr = explode(" ", $q);
    $detail_where2 = array();
    for ($i=0; $i<count($arr); $i++) {
        $word = trim($arr[$i]);
        if (!$word) continue;
        
        $concat = array();
        $concat[] = "a.mb_name";
        $concat[] = "a.mb_id";
        //$concat[] = "a.it_id";
        //$concat[] = "a.it_basic";
        $concat_fields = "concat(".implode(",' ',",$concat).")";
        
        $detail_where2[] = $concat_fields." like '%$word%' ";
        
        // 인기검색어
        insert_popular($concat, $word);
    }
    
    $where2[] = "(".implode(" and ", $detail_where2).")";
}

$sql_where = " where a.mb_gubun='3' AND c.mv_dae='y' AND " . implode(" and ", $where);
$sql_where2 = " where a.mb_gubun='3' AND c.mv_dae='y' AND " . implode(" and ", $where2);
//echo $sql_where;
$query_string = "q=".$q;
// 총몇개 = 한줄에 몇개 * 몇줄
$items = $default['de_search_list_mod'] * $default['de_search_list_row'];
// 페이지가 없으면 첫 페이지 (1 페이지)
if ($page < 1) $page = 1;
// 시작 레코드 구함
$from_record = ($page - 1) * $items;

// 검색된 내용이 몇행인지를 얻는다

$qry = "SELECT count(*) as cnt FROM ".$g5['member_table']." AS a JOIN ".$g5['member_voice']." AS c ON a.mb_id=c.mb_id ".$sql_where." ";
$tot_dt = sql_fetch($qry);
$total_count = $tot_dt['cnt'];
$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함
//echo $qry;
$qry = "SELECT a.*, c.mv_voice FROM ".$g5['member_table']." AS a JOIN ".$g5['member_voice']." AS c ON a.mb_id=c.mb_id ".$sql_where." ORDER BY  ".$_REQUEST['orderby']." DESC LIMIT ".$from_record.", ".$page_rows." ";
//echo $qry;
$res = sql_query($qry);
$row_cnt = sql_num_rows($res);

$q = get_text($q);
$search_skin = G5_SHOP_SKIN_PATH.'/search.skin.php';
//echo $search_skin;
if(!file_exists($search_skin)) {
    echo str_replace(G5_PATH.'/', '', $search_skin).' 스킨 파일이 존재하지 않습니다.';
} else {
    include_once($search_skin);
}

include_once('./_tail.php');
?>
