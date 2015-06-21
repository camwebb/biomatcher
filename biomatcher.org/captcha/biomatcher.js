function biomatcher(yourURL,token){
    $('body').append('<div class="biomatcher_overlay"></div><div id="biomatcher_captcha" class="popup shadow"><a title="Close" class="popup_close" onclick="biomatcherClose()"></a></div>');
    $('#biomatcher_captcha').append('<iframe src="http://biomatcher.org/index.php/captcha/frame?token='+token+'&yoururl='+yourURL+'" height="630px" width="761px" frameborder="0" ></iframe>');
    $('.biomatcher_overlay').css({
        position: "fixed",
        top: "0px",
        bottom: "0px",
        background: "black",
        opacity: "0.7",
        width: "100%"
    });
    $('.biomatcher_overlay').css("zIndex", 27);
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
        background: "url('http://biomatcher.org/captcha/img/sprite.png')" 
    });
}
    
function biomatcherClose(){
    $('.biomatcher_overlay').remove();
    $('#biomatcher_captcha').remove();
}