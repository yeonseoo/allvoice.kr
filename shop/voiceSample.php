<?php
include_once('./_common.php');


if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/voiceSample.php');
    return;
}

include_once('./_head.php');

// 분류리스트
$category_select = '';
$script = '';
$sql = " select * from {$g5['g5_shop_category_table']} ";
//if ($is_admin != 'super')
//    $sql .= " where ca_mb_id = '{$member['mb_id']}' ";
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

$qry = "SELECT * FROM ".$g5['member_voice']." WHERE mb_id='".$member['mb_id']."' ORDER BY mv_dae";
//echo $qry;
$res = sql_query($qry);
$row_cnt = sql_num_rows($res);
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
		<form name="fmember" id="fmember" action="./voiceSample_update.php" method="post" enctype="multipart/form-data">
		<div class="voiceSampleSection">
			<strong>샘플음성관리</strong>
			<!--span>대표 샘플음성</span-->
			<ul>
<?php
if ( $row_cnt <= 0 ) {
?>
				<li><input type="hidden" name="mv_no[]" value=""><input type="hidden" name="mv_dae[]" value="">
					<b>대표샘플음성<input type="radio" name="dae[]" value="y"><span class="xi-check-circle-o"></span><span class="xi-check-circle"></span>
						<!--i>삭제 시 체크<input type="checkbox" name="del_chk[]" value=""><span class="xi-close-circle-o"></span><span class="xi-close-circle"></span></i-->
					</b>
					<strong><input type="text" name="title[]" value="" placeholder="샘플제목" /></strong>
					<ul>
						<li>
							<span class="slcWrap">
								<select name="cat[]">
									<option value="">Category</option>
									<?php echo conv_selected_option($category_select, ''); ?>
								</select>
							</span>
						</li>
						<li>
							<span class="slcWrap">
								<select name="gen[]">
									<option value="">Gender</option>
									<?php echo conv_selected_option($gender_select, ''); ?>
								</select>
							</span>
						</li>
						<li>
							<span class="slcWrap">
								<select name="age[]">
									<option value="">Age</option>
									<?php echo conv_selected_option($age_select, ''); ?>
								</select>
							</span>
						</li>
						<li>
							<span class="slcWrap">
								<select name="sty[]">
									<option value="">Style</option>
									<?php echo conv_selected_option($style_select, ''); ?>
								</select>
							</span>
						</li>
						<li>
							<span class="slcWrap">
								<select name="ton[]">
									<option value="">Tone</option>
									<?php echo conv_selected_option($tone_select, ''); ?>
								</select>
							</span>
						</li>
						<li>
							<span class="slcWrap">
								<select name="lan[]">
									<option value="">Language</option>
									<?php echo conv_selected_option($language_select, ''); ?>
								</select>
							</span>
						</li>
						<li>
							<div class="fakeFile">
								<input type="hidden" name="del_file[]" value="" />
								<input type="text" name="voice_name[]" value="" />
								<div><input type="file" name="voice[]" onChange="change_file(this)" /></div>
							</div>
						</li>
					</ul>
					<!-- 
					<span>음성파일 다운로드 여부</span>
					<input type="radio" /><label for="">허용</label>
					<input type="radio" /><label for="">비허용</label>
					 -->
				</li>
<?php
}
else {
	while ( $row=sql_fetch_array($res) ) {
?>
				<li><input type="hidden" name="mv_no[]" value="<?php echo $row['mv_no']; ?>"><input type="hidden" name="mv_dae[]" value="<?php echo $row['mv_dae']; ?>">
					<b>대표샘플음성<input type="radio" name="dae[]" value="y" <?php echo $row['mv_dae'] == "y" ? "checked" : ""; ?>><span class="xi-check-circle-o"></span><span class="xi-check-circle"></span>
						<i>삭제 시 체크<input type="checkbox" name="del_chk[]" value="<?php echo $row['mv_no']; ?>"><span class="xi-close-circle-o"></span><span class="xi-close-circle"></span></i>
					</b>
					<!--span>대표샘플음성<input type="radio" name="dae[]" value="y" <?php echo $row['mv_dae'] == "y" ? "checked" : ""; ?>></span>
					<span style="float:right;">삭제시체크<input type="checkbox" name="del_chk[]" value="<?php echo $row['mv_no']; ?>"></span-->
					<strong><input type="text" name="title[]" value="<?php echo $row['mv_title']; ?>" placeholder="샘플제목" /></strong>
					<ul>
						<li>
							<span class="slcWrap">
								<select name="cat[]">
									<option value="">Category</option>
									<?php echo conv_selected_option($category_select, $row['mv_cat']); ?>
								</select>
							</span>
						</li>
						<li>
							<span class="slcWrap">
								<select name="gen[]">
									<option value="">Gender</option>
									<?php echo conv_selected_option($gender_select, $row['mv_gen']); ?>
								</select>
							</span>
						</li>
						<li>
							<span class="slcWrap">
								<select name="age[]">
									<option value="">Age</option>
									<?php echo conv_selected_option($age_select, $row['mv_age']); ?>
								</select>
							</span>
						</li>
						<li>
							<span class="slcWrap">
								<select name="sty[]">
									<option value="">Style</option>
									<?php echo conv_selected_option($style_select, $row['mv_sty']); ?>
								</select>
							</span>
						</li>
						<li>
							<span class="slcWrap">
								<select name="ton[]">
									<option value="">Tone</option>
									<?php echo conv_selected_option($tone_select, $row['mv_ton']); ?>
								</select>
							</span>
						</li>
						<li>
							<span class="slcWrap">
								<select name="lan[]">
									<option value="">Language</option>
									<?php echo conv_selected_option($language_select, $row['mv_lan']); ?>
								</select>
							</span>
						</li>
						<li>
							<div class="fakeFile">
								<input type="hidden" name="del_file[]" value="<?php echo $row['mv_voice']; ?>">
								<input type="text" name="voice_name[]" value="<?php echo $row['mv_voice_origin']; ?>" />
								<div><input type="file" name="voice[]" onChange="change_file(this)" /></div>
							</div>
						</li>
					</ul>
					<!-- 
					<span>음성파일 다운로드 여부</span>
					<input type="radio" /><label for="">허용</label>
					<input type="radio" /><label for="">비허용</label>
					 -->
				</li>
<?php
	}
}
?>
			</ul>
			<div class="newSample">
				<a href="javascript:;"><img src="../theme/basic/img/btn_plus.png" /><span>샘플 음성 추가하기</span></a>
			</div>
		</div>
		<div class="ctrler">
			<a class="vSave" style="cursor:pointer;">저장</a>
			<a href="javascript:;" class="vCancel">취소</a>
		</div>
		</form>
	</div>
	
<?php
include_once('./voiceRight.php');
?>
</div>


<script type="text/javascript">
$(function(){
	var newSampleHtml = "<li>" + $(".voiceSampleSection > ul > li:first-child").html() + "</li>";	
	$(".newSample a").click(function(){
		var radio_cnt = $('input[name="dae[]"]').length;
		var chk = "";
		$('input[name="dae[]"]').each(function(i) {
			if ( $(this).attr('checked') == "checked" ) {
				$("input[name='mv_dae[]']:eq(" + i + ")").val("y");
				chk = i;
			}
		});
		$(".voiceSampleSection > ul").append(newSampleHtml);
		$(".voiceSampleSection > ul > li:last").find('select, input[type="text"], input[type="hidden"], input[type="file"]').val('');
		//alert($('input[name="dae[]"]').eq(radio_cnt).attr('checked'));
		$('input[name="dae[]"]').eq(radio_cnt).attr('checked', false);
		$('input[name="dae[]"]').eq(chk).attr('checked', true);
	});

	$(".memoPop").click(function(){
        window.open(this.href, "itemuse_form", "width=810,height=550,scrollbars=1");
        return false;
    });

	$(".vSave").click(function(){
		var cnt = 0;
		var cnt2 = 0;
		$(".voiceSampleSection > ul > li").each(function (index, item) {
			$("input[name='mv_dae[]']:eq(" + index + ")").val("n");
			if ( $("input[name='dae[]']:eq(" + index + ")").attr('checked') == "checked" ) {
				$("input[name='mv_dae[]']:eq(" + index + ")").val("y");
				cnt2 ++;
			}

			if ( $("input[name='title[]']:eq(" + index + ")").val() != "" || $("select[name='cat[]']:eq(" + index + ")").val() != "" || $("select[name='gen[]']:eq(" + index + ")").val() != "" || $("select[name='age[]']:eq(" + index + ")").val() != "" || $("select[name='sty[]']:eq(" + index + ")").val() != "" || $("select[name='ton[]']:eq(" + index + ")").val() != "" || $("select[name='lan[]']:eq(" + index + ")").val() != "" || $("input[name='voice[]']:eq(" + index + ")").val() != "" ) {

				if ( $("input[name='title[]']:eq(" + index + ")").val() == "" ) {
					alert("샘플제목을 입력해 주세요.");
					$("input[name='title[]']:eq(" + index + ")").focus();
					return;
				}
				if ( $("select[name='cat[]']:eq(" + index + ")").val() == "" ) {
					alert("Category를 선택해 주세요.");
					$("select[name='cat[]']:eq(" + index + ")").focus();
					return;
				}
				if ( $("select[name='gen[]']:eq(" + index + ")").val() == "" ) {
					alert("Gender를 선택해 주세요.");
					$("select[name='gen[]']:eq(" + index + ")").focus();
					return;
				}
				if ( $("select[name='age[]']:eq(" + index + ")").val() == "" ) {
					alert("Age를 선택해 주세요.");
					$("select[name='age[]']:eq(" + index + ")").focus();
					return;
				}
				if ( $("select[name='sty[]']:eq(" + index + ")").val() == "" ) {
					alert("Style을 선택해 주세요.");
					$("select[name='sty[]']:eq(" + index + ")").focus();
					return;
				}
				if ( $("select[name='ton[]']:eq(" + index + ")").val() == "" ) {
					alert("Tone을 선택해 주세요.");
					$("select[name='ton[]']:eq(" + index + ")").focus();
					return;
				}
				if ( $("select[name='lan[]']:eq(" + index + ")").val() == "" ) {
					alert("Language를 선택해 주세요.");
					$("select[name='lan[]']:eq(" + index + ")").focus();
					return;
				}
				/*if ( $("input[name='voice[]']:eq(" + index + ")").val() == "" ) {
					alert("음성파일을 선택해 주세요.");
					$("input[name='voice[]']:eq(" + index + ")").focus();
					return;
				}*/

				cnt ++;
			}
		});

		if ( cnt2 <= 0 ) {
			alert("대표샘플음성을 선택해 주세요.");
			return;
		}

		if ( cnt > 0 ) {
			$("#fmember").submit();
		}
		else {
			alert("샘플제목을 입력해 주세요.");
			$("input[name='title[]']:eq(0)").focus();
			return;
		}

	});
/*
	$("input[name='voice[]']").change(function() {
		console.log("test");
		//console.log("TEst == >" + $(this).parents("div").parents("div").children().next().attr("name"));
		$(this).parents("div").parents("div").children().next().val($(this).val());
	});
*/
	$("input[name='dae[]']").click(function() {
		$('input[name="dae[]"]').each(function(i) {
			if ( $(this).attr('checked') == "checked" ) {
				$('input[name="mv_dae[]"]').eq(i).val('y');
			}
			else {
				$('input[name="mv_dae[]"]').eq(i).val('n');
			}
		});
	});
});

function change_file(obj) {
	//console.log("test");
	//console.log("TEst == >" + $(obj).parents("div").parents("div").children().next().attr("name"));
	$(obj).parents("div").parents("div").children().next().val($(obj).val());
}

function changeValue(obj){
	//alert(obj.value);
	$(".file-name").val(obj.value);
}

</script>



<!-- } 성우상세 끝 -->

<?php
include_once("./_tail.php");
?>