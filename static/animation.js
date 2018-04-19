var captionLength = 0;
var caption = '';
var textLength = 4;
var iterator = 0;

$(document).ready(function() {
	captionEl = $('#titleBox');
    setTimeout('executeTypingEffect()', 1000);
    setInterval('changeText()', 3000);
    setInterval ('cursorAnimation()', 800);
});

function cursorAnimation() {
    $('#cursor').animate({
        opacity: 0
    }, 'fast', 'swing').delay(400).animate({
        opacity: 1
    }, 'fast', 'swing').delay(200);

}

function changeText() {
    executeErasingEffect();
    setTimeout('executeTypingEffect()', 800);
}

function executeTypingEffect() {
    if (iterator == 1) {
        caption = "F*ck You";
        textLength = 3;
        iterator = 2;
    }
    else {
        caption = "F*ck Spam";
        textLength = 4;
        iterator = 1;
    }
    type();
}

function type() {
    captionEl.html(caption.substr(0, captionLength++));
    if(captionLength < caption.length+1) {
        setTimeout('type()', 50);
    } else {
        captionLength = 0;
        caption = '';
    }
}

function executeErasingEffect() {
    caption = captionEl.html();
    captionLength = caption.length;
    erase();
}

function erase() {
    captionEl.html(caption.substr(0, --captionLength));
    if(captionLength > (caption.length - textLength)) {
        setTimeout('erase()', 50);
    } else {
        caption = '';
    }   
}