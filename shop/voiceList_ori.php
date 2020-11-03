<?php
include_once('./_common.php');


if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/voiceList.php');
    return;
}

$page_rows = 10;
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$_REQUEST['orderby'] = isset($_REQUEST['orderby']) ? $_REQUEST['orderby'] : "a.mv_no";
$_REQUEST['cat'] = isset($_REQUEST['cat']) ? $_REQUEST['cat'] : "10";

include_once('./_head.php');

$qstr = "cat=".$_REQUEST['cat'];
$qstr2 = "";
$qstr3 = "&orderby=".$_REQUEST['orderby'];
$sub_where = "";

$_REQUEST['gen'] = isset($_REQUEST['gen']) ? $_REQUEST['gen'] : "";
if ( $_REQUEST['gen'] != "" ) {
	$qstr2 .= "&gen=".$_REQUEST['gen'];
	$sub_where .= " AND a.mv_gen='".$_REQUEST['gen']."' ";
}
$_REQUEST['age'] = isset($_REQUEST['age']) ? $_REQUEST['age'] : "";
if ( $_REQUEST['age'] != "" ) {
	$qstr2 .= "&age=".$_REQUEST['age'];
	$sub_where .= " AND a.mv_age='".$_REQUEST['age']."' ";
}
$_REQUEST['sty'] = isset($_REQUEST['sty']) ? $_REQUEST['sty'] : "";
if ( $_REQUEST['sty'] != "" ) {
	$qstr2 .= "&sty=".$_REQUEST['sty'];
	$sub_where .= " AND a.mv_sty='".$_REQUEST['sty']."' ";
}
$_REQUEST['ton'] = isset($_REQUEST['ton']) ? $_REQUEST['ton'] : "";
if ( $_REQUEST['ton'] != "" ) {
	$qstr2 .= "&ton=".$_REQUEST['ton'];
	$sub_where .= " AND a.mv_ton='".$_REQUEST['ton']."' ";
}
$_REQUEST['lan'] = isset($_REQUEST['lan']) ? $_REQUEST['lan'] : "";
if ( $_REQUEST['lan'] != "" ) {
	$qstr2 .= "&lan=".$_REQUEST['lan'];
	$sub_where .= " AND a.mv_lan='".$_REQUEST['lan']."' ";
}

$sql = " SELECT * FROM ".$g5['g5_shop_category_table']." WHERE ca_id='".$_REQUEST['cat']."' ";
$cat_dt = sql_fetch($sql);

$qry = "SELECT count(*) as cnt FROM ".$g5['member_voice']." a JOIN ".$g5['member_table']." b ON a.mb_id=b.mb_id WHERE a.mv_cat='".$_REQUEST['cat']."' ".$sub_where." ";
$tot_dt = sql_fetch($qry);
$total_count = $tot_dt['cnt'];
$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함
//echo $qry;
$qry = "SELECT a.*, b.mb_name, b.it_use_avg FROM ".$g5['member_voice']." a JOIN ".$g5['member_table']." b ON a.mb_id=b.mb_id WHERE a.mv_cat='".$_REQUEST['cat']."' ".$sub_where." ORDER BY  ".$_REQUEST['orderby']." DESC LIMIT ".$from_record.", ".$page_rows." ";
//echo $qry;
$res = sql_query($qry);
$row_cnt = sql_num_rows($res);
//$dt = NULL;

?>

<!-- 성우리스트 { -->


<div class="listWrap">
	<div class="listCont">
		<div class="listInfo">
			<div class="listLocation">
				<ul>
					<li><img src="../theme/basic/img/img_home.png" /></li>
					<li><?php echo $cat_dt['ca_name']; ?></li>
					<!--li>카테고리명01</li-->
				</ul>
			</div>
			<div class="listOrder">
				<ul>
					<li><a href="javascript:location.href='<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $qstr.$qstr2; ?>&orderby=a.mv_no';" <?php echo ( $_REQUEST['orderby'] == "a.mv_no" ) ? "class='on'" : ""; ?>>최신순</a></li>
					<li><a href="javascript:location.href='<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $qstr.$qstr2; ?>&orderby=b.it_use_cnt';" <?php echo ( $_REQUEST['orderby'] == "b.it_use_cnt" ) ? "class='on'" : ""; ?>>후기많은순</a></li>
					<li><a href="javascript:location.href='<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $qstr.$qstr2; ?>&orderby=b.it_use_avg';" <?php echo ( $_REQUEST['orderby'] == "b.it_use_avg" ) ? "class='on'" : ""; ?>>평점높은순</a></li>
					<li><a href="javascript:;">판매많은순</a></li>
				</ul>
			</div>
		</div>
		
		
		<ul class="listData2">
<?php
for ($i=0; $row=sql_fetch_array($res); $i++) {
	$mb_dir = substr($row['mb_id'],0,2);
	$icon_url = G5_DATA_URL.'/member_image/'.$mb_dir.'/'.$row['mb_id'].'.gif';
	$icon_url = is_file(G5_DATA_PATH.'/member_image/'.$mb_dir.'/'.$row['mb_id'].'.gif') ? $icon_url : "/theme/basic/img/profileSample.jpg";
	$audio_url = G5_DATA_URL.'/member_voice/'.$mb_dir.'/'.$row['mv_voice'];
?>
			<li>
    			<a href="/shop/voiceDetail.php?cat=<?php echo $_REQUEST['cat']; ?>&mb_id=<?php echo $row['mb_id']; ?>">
    				<img src="<?php echo $icon_url; ?>" />
    			</a>
    			<div>
        			<strong><?php echo $row['mb_name']; ?> (<?php echo $row['mb_id']; ?>)</strong>
        			<img src="img/s_star<?php echo $row['it_use_avg'] <= 0 ? "1" : intval($row['it_use_avg']); ?>.png" /> <!-- 1~5 -->
        			<div class="tagPlayer">
    					<div>
    						<strong><?php echo $row['mv_title']; ?></strong>
    						<span><?php echo $gender_arr[$row['mv_gen']]; ?></span>
    						<span><?php echo $age_arr[$row['mv_age']]; ?></span>
    						<span><?php echo $style_arr[$row['mv_sty']]; ?></span>
    						<span><?php echo $tone_arr[$row['mv_ton']]; ?></span>
    						<span><?php echo $language_arr[$row['mv_lan']]; ?></span>
    					</div>
						<div class="audioPlayer" id="player01">
							<audio controls src="<?php echo $audio_url; ?>"></audio>
						</div>
    				</div>
    			</div>
			</li>
<?php
}
?>

		</ul>
<script type="text/javascript">
$(function(){
	//var h = '<audio controls src="../theme/basic/img/audio-test-01.mp3"></audio>'
	//$('.audioPlayer').html(h);
	maudio({
	    obj:'audio',
	    fastStep:10
	});
	$(".progress-bar").width( '400px' );
});
</script>
		<!--
		<div class="listData">
    		<ul>
        		<li>
        			<a href="/shop/voiceDetail.php"><img src="../theme/basic/img/voiceList/01.png" />이용신 (sin1111)</a>
        		</li>
        		<li>
        			<a href="/shop/voiceDetail.php"><img src="../theme/basic/img/voiceList/02.png" />이아영</a>
        		</li>
        		<li>
        			<a href="/shop/voiceDetail.php"><img src="../theme/basic/img/voiceList/03.png" />임정희</a>
        		</li>
        		<li>
        			<a href="/shop/voiceDetail.php"><img src="../theme/basic/img/voiceList/04.png" />홍길동</a>
        		</li>
        		<li>
        			<a href="/shop/voiceDetail.php"><img src="../theme/basic/img/voiceList/05.png" />이순신</a>
        		</li>
        		<li>
        			<a href="/shop/voiceDetail.php"><img src="../theme/basic/img/voiceList/06.png" />홍슬기</a>
        		</li>
        		<li>
        			<a href="/shop/voiceDetail.php"><img src="../theme/basic/img/voiceList/07.png" />김샛별</a>
        		</li>
        		<li>
        			<a href="/shop/voiceDetail.php"><img src="../theme/basic/img/voiceList/08.png" />이순신</a>
        		</li>
        		<li>
        			<a href="/shop/voiceDetail.php"><img src="../theme/basic/img/voiceList/01.png" />이용신 (sin1111)</a>
        		</li>
        		<li>
        			<a href="/shop/voiceDetail.php"><img src="../theme/basic/img/voiceList/02.png" />이아영</a>
        		</li>
        		<li>
        			<a href="/shop/voiceDetail.php"><img src="../theme/basic/img/voiceList/03.png" />임정희</a>
        		</li>
        		<li>
        			<a href="/shop/voiceDetail.php"><img src="../theme/basic/img/voiceList/04.png" />홍길동</a>
        		</li>
        		<li>
        			<a href="/shop/voiceDetail.php"><img src="../theme/basic/img/voiceList/05.png" />이순신</a>
        		</li>
        		<li>
        			<a href="/shop/voiceDetail.php"><img src="../theme/basic/img/voiceList/06.png" />홍슬기</a>
        		</li>
        		<li>
        			<a href="/shop/voiceDetail.php"><img src="../theme/basic/img/voiceList/07.png" />김샛별</a>
        		</li>
        		<li>
        			<a href="/shop/voiceDetail.php"><img src="../theme/basic/img/voiceList/08.png" />이순신</a>
        		</li>
        		<li>
        			<a href="/shop/voiceDetail.php"><img src="../theme/basic/img/voiceList/01.png" />이용신 (sin1111)</a>
        		</li>
        		<li>
        			<a href="/shop/voiceDetail.php"><img src="../theme/basic/img/voiceList/02.png" />이아영</a>
        		</li>
        		<li>
        			<a href="/shop/voiceDetail.php"><img src="../theme/basic/img/voiceList/03.png" />임정희</a>
        		</li>
        		<li>
        			<a href="/shop/voiceDetail.php"><img src="../theme/basic/img/voiceList/04.png" />홍길동</a>
        		</li>
        		<li>
        			<a href="/shop/voiceDetail.php"><img src="../theme/basic/img/voiceList/05.png" />이순신</a>
        		</li>
        		<li>
        			<a href="/shop/voiceDetail.php"><img src="../theme/basic/img/voiceList/06.png" />홍슬기</a>
        		</li>
        		<li>
        			<a href="/shop/voiceDetail.php"><img src="../theme/basic/img/voiceList/07.png" />김샛별</a>
        		</li>
        		<li>
        			<a href="/shop/voiceDetail.php"><img src="../theme/basic/img/voiceList/08.png" />이순신</a>
        		</li>
        	</ul>
		</div>
		-->
		
		<!--div class="ttrxPaging">
			<a href="javascript:;"><img src="../theme/basic/img/btn_listPrev.png" /></a>
			<ul>
				<li><a href="javascript:;">1</a></li>
				<li><a href="javascript:;">2</a></li>
				<li><a href="javascript:;">3</a></li>
				<li><a href="javascript:;">4</a></li>
				<li><a href="javascript:;">5</a></li>
				<li><a href="javascript:;">6</a></li>
				<li><a href="javascript:;">7</a></li>
				<li><a href="javascript:;">8</a></li>
				<li><a href="javascript:;">9</a></li>
				<li><a href="javascript:;">10</a></li>
			</ul>
			<a href="javascript:;"><img src="../theme/basic/img/btn_listNext.png" /></a>
		</div-->
		<?php echo get_paging($page_rows, $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.$qstr2.$qstr3.'&amp;page='); ?>
	</div>

	<div class="detailSearch">
		<strong>Detail Search</strong>
		<em></em>
		<div>
			<span class="slcWrap">
				<select name="gen" id="gen">
					<option value="">Gender</option>
					<?php echo conv_selected_option($gender_select, $_REQUEST['gen']); ?>
				</select>
			</span>
			<span class="slcWrap">
				<select name="age" id="age">
					<option value="">Age</option>
					<?php echo conv_selected_option($age_select, $_REQUEST['age']); ?>
				</select>
			</span>
			<span class="slcWrap">
				<select name="sty" id="sty">
					<option value="">Style</option>
					<?php echo conv_selected_option($style_select, $_REQUEST['sty']); ?>
				</select>
			</span>
			<span class="slcWrap">
				<select name="ton" id="ton">
					<option value="">Tone</option>
					<?php echo conv_selected_option($tone_select, $_REQUEST['ton']); ?>
				</select>
			</span>
			<span class="slcWrap">
				<select name="lan" id="lan">
					<option value="">Language</option>
					<?php echo conv_selected_option($language_select, $_REQUEST['lan']); ?>
				</select>
			</span>
		</div>
		<hr />
		<a id="search_btn" style="cursor:pointer;">Search</a>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$("#search_btn").click(function() {
		location.href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $qstr.$qstr3; ?>&gen="+$("#gen").val()+"&age="+$("#age").val()+"&sty="+$("#sty").val()+"&ton="+$("#ton").val()+"&lan="+$("#lan").val()+"";
	});
});
</script>
<!-- } 성우리스트 끝 -->

<?php
include_once("./_tail.php");
?>