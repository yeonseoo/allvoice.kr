<?php
include_once('./_common.php');


if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH . '/how.php');
    return;
}

include_once('./_head.php');
?>
    <style type="text/css" xmlns="http://www.w3.org/1999/html">
        #contentsWrap {
            margin-top: 56px;
            padding-bottom: 0;
        }

        #subCate {
            border-bottom: 0;
        }

        #contentsWrap > div {
            width: 100%;
        }
    </style>


    <div class="ectCont">
        <div class="contTop">
            <strong>ALL VOICE 이용방법 안내</strong>
            <hr/>
            <span>올보이스에서는 고객님의 신속하고 편리한 작업진행을 위해 두가지 판매 옵션을 제공하고 있습니다.</span>
        </div>

        <!--
	<div class="contMidW" style="padding-bottom:0;">
		<div>
			<div class="centerDiv">
				<span class="blueBox">이용가이드 다운로드</span>
			</div>
			<div class="ContButtons">
				<a href="<?php echo G5_SHOP_URL; ?>/Site Use Guide-Client.pdf" download>클라이언트 가이드 다운로드</a>
				<a href="<?php echo G5_SHOP_URL; ?>/Site Use Guide-Voice actor.pdf" download>프로성우 가이드 다운로드</a>
			</div>
		</div>
	</div>
	-->

        <div class="contMidW">
            <div>
                <div style="text-align:left;font-size:19px;margin-bottom:10px;font-weight: bold;">올보이스 이용방법</div>
                    <ul class="step01">
                        <li style="margin-top: -20px;">
                            <span> </span>
                            <strong style="margin-bottom: 10px;">성우님과 채팅 하기</strong>

                            <p> - 보이스샘플 재생플레이어 1:1 채팅하기 버튼 이용</p>
                            <p> - 성우님 이름 검색후 프로필 페이지내 사진 하단 1:1채팅 버튼 이용</p>
                        </li>
                    </ul>
                </br></br>

                <div style="text-align:left;font-size:19px;margin-top: 15px;margin-bottom:20px;font-weight: bold;">거래 이용방법</div>
                <div class="centerDiv">
                    <span class="blueBox">OPTION 1. 성우에게 바로 작업요청 하기</span>
                </div>
                <ul class="stepB">
                    <li class="l2">목소리<br/>샘플 듣기</li>
                    <li class="l2">1:1<br/>채팅문의</li>
                    <li>결제</li>
                    <li>안심번호 통화</li>
                    <li class="l2">녹음작업<br/>완료</li>
                </ul>
                <ol class="step01">
                    <li>
                        <span>01</span>
                        <strong>원하시는 목소리의 성우 선택</strong>
                        <p>작업에 맞는 성우를 각 카테고리별로 검색하여 쉽게 선택하세요. </p>
                    </li>
                    <li>
                        <span>02</span>
                        <strong>1:1 채팅문의</strong>
                        <p>성우에게 1:1 채팅으로 빠르고 편리하게 작업을 문의 하세요.</p>
                    </li>
                    <li>
                        <span>03</span>
                        <strong>결제</strong>
                        <p>성우님이 직접 채팅창에 합의된 성우료의 결제창을 올려줍니다. 결제를 진행해 주세요.</p>
                    </li>
                    <li>
                        <span>04</span>
                        <strong>안심번호 통화</strong>
                        <p>결제가 완료되면 안심번호를 성우님 프로필 페이지에서 확인할 수 있습니다.
                        <br/>음성통화를 통해 작업내용 및 목소리를 조율해 주세요.</p>
                    </li>
                    <li>
                        <span>05</span>
                        <strong>녹음 작업 완료</strong>
                        <p>완성된 녹음파일을 채팅창을 통해 전송 받으세요.</p>
                    </li>
                </ol>
            </div>
        </div>

        <div class="contMidG">
            <div>
                <div class="centerDiv">
                    <span class="redBox">OPTION 2. 오디션 등록하기</span>
                </div>
                <ul class="stepR">
                    <li>오디션 등록</li>
                    <li class="l2">성우님<br/>지원받기</li>
                    <li>성우님 선택</li>
                    <li>결제</li>
                    <li>안심번호 통화</li>
                    <li>작업 완료</li>
                </ul>
                <ol class="step01">
                    <li>
                        <span>01</span>
                        <strong>오디션 등록</strong>
                        <p>원하는 녹음 작업을 등록해주세요. 등록시 듣고자 하는 샘플 한 문장을 등록해 주시면 해당 문장의 녹음본을 들어보실 수 있습니다.</p>
                    </li>
                    <li>
                        <span>02</span>
                        <strong>성우님 지원받기</strong>
                        <p>등록된 작업에 성우님들의 지원을 받으세요.</p>
                    </li>
                    <li>
                        <span>03</span>
                        <strong>성우님 선택</strong>
                        <p>녹음된 샘플문장을 들어보고 성우님을 선택 하세요.</p>
                    </li>
                    <li>
                        <span>04</span>
                        <strong>결제</strong>
                        <p>성우님 선택시 결제창이 자동 생성됩니다. 마이페이지에서 확인 하세요.</p>
                    </li>
                    <li>
                        <span>05</span>
                        <strong>안심번호 통화</strong>
                        <p>결제가 완료되면 안심번호를 성우님 프로필 페이지에서 확인할 수 있습니다.
                        <br/>음성통화를 통해 작업 내용 및 목소리를 조율 해주세요. 1:1 채팅창을 통해 성우님께 요청사항을 전달하실 수도 있습니다.</p>
                    </li>
                    <li>
                        <span>06</span>
                        <strong>작업완료</strong>
                        <p>완성된 녹음 파일을 채팅창을 통해 받으시거나 마이페이지에서 다운로드하세요.</p>
                    </li>
                </ol>
            </div>
        </div>

        <div class="contHowB">
            <div>
                <img src="../theme/basic/img/img_whatAfter.png"/>
                <strong>성우의 목소리가 녹음된 파일에 음악을 더하는 등의 작업을 말하며<br/>올보이스에서는 현재 프로로 활동 중인 엔지니어들이 후반작업을 전담하여 최고의 결과물을 제공합니다.</strong>
                <ol class="step01">
                    <li>
                        <span>01</span>
                        <strong>후반작업의뢰</strong>
                        <p>홈페이지 상단의 ‘후반작업’ 버튼을 클릭하여 후반작업의뢰 페이지에 접속합니다.</p>
                    </li>
                    <li>
                        <span>02</span>
                        <strong>작업조율 및 결정</strong>
                        <p>후반작업에 필요한 내용을 조율하고 최종 가격을 결정하여, 작업비용을 지불합니다.</p>
                    </li>
                    <li>
                        <span>03</span>
                        <strong>작업진행</strong>
                        <p>올보이스등록 프로엔지니어들이 완벽한 결과물을 빠르게 작업합니다.</p>
                    </li>
                    <li>
                        <span>04</span>
                        <strong>작업완료</strong>
                        <p>최고의 결과물을 빠르고 쉽게 받아보실수 있습니다.</p>
                    </li>
                </ol>
            </div>
        </div>
        <a name="payDefault" style="display:block;margin-top:-120px;margin-bottom:120px;"></a>
        <div class="contHowG">
            <div>
                <img src="../theme/basic/img/img_payDefault.png"/>
                <strong>
                    올보이스는 소속 성우 개개인의 녹음단가를 바탕으로카테고리별 합리적인 기본가격을 책청 하였습니다.<br/>
                    최종가격은 성우의 개개인의 특성과 경력, 녹음 분량에 따라 결정되며<br/>
                    이는 고객과 성우가 직접 협의하는 과정을 거치게 됩니다.
                </strong>
                <ol class="payDefault">
                    <li>
                        <hr/>
                        <div><span><strong>01</strong> 성우협회 소속 성우</span>&nbsp;&nbsp;ㅣ&nbsp;&nbsp;1:1 문의 필수</div>
                        <em>150,000 ~</em></li>
                    <li>
                        <hr/>
                        <div><span><strong>02</strong> 비협회 성우(오픈준비중)</span>&nbsp;&nbsp;ㅣ&nbsp;&nbsp;1:1문의 필수</div>
                        <em>50,000 ~</em></li>
                </ol>
                <div style="text-align:right;font-size:14px;margin-top:10px;">* 단위 : 원</div>
                <div style="text-align:left;font-size:15px;margin-top:10px;">
                    * 올보이스 결제 시스템 이용 캠페인</br>
                    안전하고 편리한 올보이스 결제 시스템을 이용해주세요.</div>
            </div>
        </div>
    </div>


<?php
include_once("./_tail.php");
?>