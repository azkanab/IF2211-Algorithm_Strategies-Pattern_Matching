var captionLength = 0;
var caption = '';
var textLength = 4;
var iterator = 0;

$(document).ready(function() {
    // Init title animation
    captionEl = $('#titleBox');
    setInterval ('cursorAnimation()', 800);
    setTimeout('initialize()', 1000);
    setTimeout('executeTypingEffect()', 2000);
    setInterval('changeText()', 3500);
});

function cursorAnimation() {
    $('#cursor').animate({
        opacity: 0
    }, 'fast', 'swing').delay(400).animate({
        opacity: 1
    }, 'fast', 'swing').delay(200);

}

function initialize() {
    caption_temp = 'Spam!'
    $('#spamTitle').html(caption_temp.substr(0, captionLength++));
    if(captionLength < caption_temp.length+1) {
        setTimeout('initialize()', 50);
    } else {
        captionLength = 0;
        caption = '';
    }
}

function changeText() {
    executeErasingEffect();
    setTimeout('executeTypingEffect()', 1000);
}

function executeTypingEffect() {
    if (iterator == 0) {
        caption = "by Faza";
        iterator = 1;
    }
    else if (iterator == 1) {
        caption = "by Azka";
        iterator = 2;
    }
    else {
        caption = "by Rama";
        iterator = 0;
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