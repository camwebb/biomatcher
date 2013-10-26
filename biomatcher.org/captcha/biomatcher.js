function biomatcher(){
    $('body').append('<div class="overlay"></div><div id="biomatcher_captcha" class="popup shadow" ><a title="Close" class="popup_close" onclick="popup_close()"></a></div>');
    $('#biomatcher_captcha').append('<iframe src="http://biomatcher.org/index.php/captcha/frame" height="630px" width="761px" frameborder="0" ></iframe>');
    $('.overlay').css({
        position: "fixed",
        top: "0px",
        bottom: "0px",
        background: "black",
        opacity: "0.7",
        width: "100%"
    });
    $('.overlay').css("zIndex", 27);
    $('.popup').css({
        height: "auto",
        position: "absolute",
        top: "27px",
        left: "216px",
        opacity: "1",
        overflow: "visible",
    });
    $('.popup').css("zIndex", 8030);
    $('.popup_close').css({
        position: "absolute",
        top: "-15px",
        right: "-15px",
        width: "36px",
        height: "36px",
        cursor: "pointer",
        background: "url('../../captcha/img/sprite.png')" 
    });
    }
    
function popup_close(){
    $('.overlay').remove();
    $('#biomatcher_captcha').remove();
}