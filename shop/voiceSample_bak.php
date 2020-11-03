<?php
include_once('./_common.php');


if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/mypage.php');
    return;
}

include_once('./_head.php');

// 분류리스트
$category_select = '';
$script = '';
$sql = " select * from {$g5['g5_shop_category_table']} ";
if ($is_admin != 'super')
    $sql .= " where ca_mb_id = '{$member['mb_id']}' ";
$sql .= " order by ca_order, ca_id ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++)
{
    $len = strlen($row['ca_id']) / 2 - 1;

    $nbsp = "";
    for ($i=0; $i<$len; $i++)
        $nbsp .= "&nbsp;&nbsp;&nbsp;";

    $category_select .= "<option value=\"{$row['ca_id']}\">$nbsp{$row['ca_name']}</option>\n";

    $script .= "ca_use['{$row['ca_id']}'] = {$row['ca_use']};\n";
    $script .= "ca_stock_qty['{$row['ca_id']}'] = {$row['ca_stock_qty']};\n";
    //$script .= "ca_explan_html['$row[ca_id]'] = $row[ca_explan_html];\n";
    $script .= "ca_sell_email['{$row['ca_id']}'] = '{$row['ca_sell_email']}';\n";
}
?>

<!-- 성우상세 { -->

<div class="commonLocation">
	<ul>
		<li><img src="../theme/basic/img/img_home2.png" /></li>
		<li>MY PAGE</li>
		<li>샘플 음성 및 관리</li>
	</ul>
</div>


<div class="voiceMypage">
	<div class="voiceDetailInfo">
		<div class="voiceSampleSection">
			<strong>샘플음성관리</strong>
			<span>대표 샘플음성</span>
			<ul>
				<li>
					<strong><input type="text" placeholder="샘플제목" /></strong>
					<ul>
						<li>
							<span class="slcWrap">
								<select>
									<option>Category</option>
									<?php echo conv_selected_option($category_select, $it['ca_id']); ?>
								</select>
							</span>
						</li>
						<li>
							<span class="slcWrap">
								<select>
									<option>Gender</option>
								</select>
							</span>
						</li>
						<li>
							<span class="slcWrap">
								<select>
									<option>Age</option>
								</select>
							</span>
						</li>
						<li>
							<span class="slcWrap">
								<select>
									<option>Style</option>
								</select>
							</span>
						</li>
						<li>
							<span class="slcWrap">
								<select>
									<option>Tone</option>
								</select>
							</span>
						</li>
						<li>
							<span class="slcWrap">
								<select>
									<option>Language</option>
								</select>
							</span>
						</li>
						<li>
							<div class="fakeFile">
								<input type="text" />
								<div><input type="file" /></div>
							</div>
						</li>
					</ul>
					<!-- 
					<span>음성파일 다운로드 여부</span>
					<input type="radio" /><label for="">허용</label>
					<input type="radio" /><label for="">비허용</label>
					 -->
				</li>
			</ul>
			<div class="newSample">
				<a href="javascript:;"><img src="../theme/basic/img/btn_plus.png" /><span>샘플 음성 추가하기</span></a>
			</div>
		</div>
		<div class="ctrler">
			<a href="javascript:;" class="vSave">저장</a>
			<a href="javascript:;" class="vCancel">취소</a>
		</div>
	</div>
	
<?php
include_once('./voiceRight.php');
?>
</div>


<script type="text/javascript">
$(function(){
	var newSampleHtml = "<li>" + $(".voiceSampleSection > ul > li:first-child").html() + "</li>";	
	$(".newSample a").click(function(){
		$(".voiceSampleSection > ul").append(newSampleHtml);
	});

	$(".memoPop").click(function(){
        window.open(this.href, "itemuse_form", "width=810,height=550,scrollbars=1");
        return false;
    });
});
</script>



<!-- } 성우상세 끝 -->

<?php
include_once("./_tail.php");
?>