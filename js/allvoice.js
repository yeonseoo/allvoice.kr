$(document).on('ready', function () {

    //오늘의 오디션 슬라이드
    $(".variable").slick({
        dots: false,
        infinite: true,
        variableWidth: true,
        arrows: false
    });

    //
    $('.comName').click(function () {
        $('.infoBlind').toggle();
        $(this).children("small").toggleClass('reverse');
    })

    len_txt($(".txt1")); //글자수 자르기

    //전체선택 체크박스 클릭 
    $("#allCheck").click(function () { //만약 전체 선택 체크박스가 체크된상태일경우 
        if ($("#allCheck").prop("checked")) { //해당화면에 전체 checkbox들을 체크해준다 
            $("input[type=checkbox]").prop("checked", true); // 전체선택 체크박스가 해제된 경우 
        } else { //해당화면에 모든 checkbox들의 체크를해제시킨다. 
            $("input[type=checkbox]").prop("checked", false);
        }
    })

    //탭
    /*
    $(".tabconts").hide();
    $(".chkBoxImg").hide();

    $("ul.tabs li:first a").addClass("active").show();
    $(".tabconts:first").show();
    $(".chkBoxImg:first").show();
    //On Click Event
    $("ul.tabs li a").click(function () {

        $("ul.tabs li a").removeClass("active");
        $(this).addClass("active");
        $(this).parent('li').siblings().find(".tabconts").hide();
        $(this).parent('li').siblings().find(".chkBoxImg").hide();


        var chkBoxImg = $(this).children(".chkBoxImg");
        var activeTab = $(this).next(".tabconts");
        $(activeTab).fadeIn();
        $(chkBoxImg).fadeIn();
        return false;
    });
    */

    //파일첨부
    var fileTarget = $('.filebox .upload-hidden');
    fileTarget.on('change', function () {
        // 값이 변경되면 
        if (window.FileReader) { // modern browser 
            var filename = $(this)[0].files[0].name;
        } else { // old IE 
            var filename = $(this).val().split('/').pop().split('\\').pop(); // 파일명만 추출 
        }
        // 추출한 파일명 삽입 
        $(this).siblings('.upload-name').val(filename);
    });

    //셀렉트 콤보박스
    var selectTarget = $('.selectbox select');
    selectTarget.change(function () {
        var select_name = $(this).children('option:selected').text();
        $(this).siblings('label').text(select_name);
    });

    //검색 열기 닫기


    var clicks = 0;

    $('.openClose').click(function () {
        if (clicks == 0) {
            $(this).find('.openA').fadeToggle();
            $(this).find('.closeA').fadeToggle();
            $(this).parents('.schStep').siblings('.schWrap').find('.filters').fadeToggle()
        } else {
            $(this).find('.openA').fadeToggle();
            $(this).find('.closeA').fadeToggle();
            $(this).parents('.schStep').siblings('.schWrap').find('.filters').fadeToggle()
        }
        ++clicks;
    });

    //더보기
    $(".list").slice(0, 5).show(); // 최초 10개 선택
    $(".moreBtn").click(function (e) { // Load More를 위한 클릭 이벤트e
        e.preventDefault();
        if ($(".list:hidden").length == 0) { // 숨겨진 DIV가 있는지 체크
            alert("더 이상 항목이 없습니다"); // 더 이상 로드할 항목이 없는 경우 경고
        }

        $(".list:hidden").slice(0, 5).show(1300); // 숨김 설정된 다음 10개를 선택하여 표시
        console.log($(".list:hidden").length);
    });

    //성우를 찾으십니까 팝업열고닫기
    $('.topPopShow').click(function () {
        $('.topPop').slideToggle();
        $('.topPop').find('.topPopBox').slideToggle()
    });
    $('.closeBtn').click(function () {
        $('.topPop').slideToggle();
        $('.topPop').find('.topPopBox').slideToggle()
    });
    $('.topPopBg').click(function () {
        $('.topPop').slideToggle();
        $('.topPop').find('.topPopBox').slideToggle()
    });

    //이미지 변경
    $('.likeOn').click(function () {
        var src = ($(this).attr('src') === 'images/heart_off.svg') ? 'images/heart_on.svg' : 'images/heart_off.svg';
        $(this).attr('src', src);
    });

    //성우정보 팝업 열고 닫기


    $('.btmPopBg').click(function () {
        $('.bottomPop').slideToggle();
        $('.bottomPop').find('.btmPopBox').slideToggle()
    });
    $('.closeTxt').click(function () {
        $('.bottomPop').slideToggle();
        $('.bottomPop').find('.btmPopBox').slideToggle()
    });
});

//글자수 자르기
function len_txt(obj) {
    if ($(obj).text().length >= 35) {
        $(obj).text(($(obj).text().substr(0, 35) + "..."));
    }
}

function scrollToTop() {
    window.scrollTo(0, 0);
}