function biomatcher(){
    $('body').append('<div class="overlay"></div><div id="biomatcher_captcha" class="popup shadow" ><a title="Close" class="popup_close" onclick="popup_close()"></a></div>');
    $('#biomatcher_captcha').append('<iframe src="http://biomatcher.org/index.php/captcha/frame" height="630px" width="761px" frameborder="0" ></iframe>');
    }
    
function popup_close(){
    $('.overlay').remove();
    $('#biomatcher_captcha').remove();
}