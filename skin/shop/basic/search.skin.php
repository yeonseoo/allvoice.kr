<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<div class="listWrap">
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
<style type="text/css">
#topTen > ul{width:1220px;}
#topTen > ul li > div > img{height:220px;}
.mediPlayer > img:nth-child(2){width:224px;left:calc(50% - 112px);}
.mediPlayer{width:224px;height:224px;}
</style>
<script src="<?php echo G5_THEME_CSS_URL ?>/QTransform.js"></script>
<script type="text/javascript">
$(function(){
	$('.mediPlayer audio').each(function(idx){
		//console.log($(this).find("audio").attr("src"));
		//var song = new Audio($(this).find("audio").attr("src"),$(this).find("audio").attr("src"));
		console.log($(this));
		$(this).on("play",function(){
			$(this).parent().css("opacity",1);
    		//console.log(this.duration);
    		console.log(this.currentTime*1000);
    		$(this).prev().animate({
        		rotate : '360deg'
        	},this.duration*1000 + 1000 - this.currentTime*1000,"linear",function(){
        		$(this).parent().removeAttr("style");
        		$(this).animate({
            		rotate : '0deg'
            	},0);
            });
		});
		$(this).on("pause",function(){
			$(this).parent().removeAttr("style");
			$(this).prev().stop();
		});

		$(this).on("ended",function(){
			console.log("end");
			$(this).parent().removeAttr("style");
    		$(this).prev().stop().animate({
        		rotate : '0deg'
        	},0);
		});
	});
	$('.mediPlayer').mediaPlayer();
});
</script>
		
		<div id="topTen" style="background:none;padding:0;">
    		<ul>
<?php
for ($i=0; $row=sql_fetch_array($res); $i++) {
	$mb_dir = substr($row['mb_id'],0,2);
	$icon_url = G5_DATA_URL.'/member_image/'.$mb_dir.'/'.$row['mb_id'].'.gif';
	$icon_url = is_file(G5_DATA_PATH.'/member_image/'.$mb_dir.'/'.$row['mb_id'].'.gif') ? $icon_url : "../theme/basic/img/profileSample.jpg";
	$audio_url = G5_DATA_URL.'/member_voice/'.$mb_dir.'/'.$row['mv_voice'];
?>
        		<li>
        			<div class="circularPlayerWrap">
        				<img src="<?php echo $icon_url ?>" />
        				<div class="mediPlayer">
                			<img src="../theme/basic/img/img_playerPoint.png" />
                			<img src="../theme/basic/img/img_circlePlayer.png" />
        					<audio class="listen" preload="metadata" src="<?php echo $audio_url ?>"></audio>
        				</div>
        			</div>
        			<a href="/shop/voiceDetail.php?cat=<?php echo $row['mv_cat']; ?>&mb_id=<?php echo $row['mb_id']; ?>"><?php echo $row['mb_name']; ?>(<?php echo $row['mb_id']; ?>)</a>
			
        		</li>
<?php
}
?>

        	</ul>
		</div>
		
<?php
echo get_paging($page_rows, $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$query_string.'&amp;page=');
?>
	</div>
	
</div>