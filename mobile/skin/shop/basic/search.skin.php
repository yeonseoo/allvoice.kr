<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<div class="listWrap" style="padding-top:0;">
	<div class="listCont searchMode">
		<div class="listInfo">
			<div class="listLocation">
				<ul>
					<li><img src="../theme/basic/img/img_home.png" /></li>
					<li>검색</li>
					<!--li>카테고리명01</li-->
				</ul>
			</div>
			<div class="listOrder">
				<ul>
					<li><a href="javascript:location.href='<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $query_string; ?>&orderby=mb_no';" <?php echo ( $_REQUEST['orderby'] == "mb_no" ) ? "class='on'" : ""; ?>>최신순</a></li>
					<li><a href="javascript:location.href='<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $query_string; ?>&orderby=it_use_cnt';" <?php echo ( $_REQUEST['orderby'] == "it_use_cnt" ) ? "class='on'" : ""; ?>>후기많은순</a></li>
					<li><a href="javascript:location.href='<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $query_string; ?>&orderby=it_use_avg';" <?php echo ( $_REQUEST['orderby'] == "it_use_avg" ) ? "class='on'" : ""; ?>>평점높은순</a></li>
					<li><a href="javascript:;">판매많은순</a></li>
				</ul>
			</div>
		</div>
		
		<div>
    		<ul class="listDataM" style="padding:0;">

<?php
for ($i=0; $row=sql_fetch_array($res); $i++) {
	$mb_dir = substr($row['mb_id'],0,2);
	$icon_url = G5_DATA_URL.'/member_image/'.$mb_dir.'/'.$row['mb_id'].'.gif';
	$icon_url = is_file(G5_DATA_PATH.'/member_image/'.$mb_dir.'/'.$row['mb_id'].'.gif') ? $icon_url : "/theme/basic/img/profileSample.jpg";
	$audio_url = G5_DATA_URL.'/member_voice/'.$mb_dir.'/'.$row['mv_voice'];
?>
			<li>
    			<a href="/shop/voiceDetail.php?mb_id=<?php echo $row['mb_id']; ?>">
    				<img src="<?php echo $icon_url ?>" />
    			</a>
    			<strong><?php echo $row['mb_name']; ?> (<?php echo $row['mb_id']; ?>)</strong>
    			<div>
    				<div class="audioPlayer">
    					<audio class="listen" preload="none" src="<?php echo $audio_url ?>"></audio>
    				</div>
    			</div>
    		</li>
<?php
}
?>

        	</ul>
        	
<?php
echo get_paging($page_rows, $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$query_string.'&amp;page=');
?>
		</div>
		
	</div>

<script type="text/javascript">
$(function(){
	//var h = '<audio controls src="../theme/basic/img/audio-test-01.mp3"></audio>'
	//$('.audioPlayer').html(h);
	maudio({
	    obj:'audio',
	    fastStep:10
	});

	
});
</script>
	
</div>