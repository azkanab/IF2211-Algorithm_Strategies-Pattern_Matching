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

    // Regex vs etc algo switching
    $('#algorithmSelect').change(function() {
        if ($(this).val() == 2) {
            $('#caseSensitiveCheck').attr("disabled", true);
            $('#wholeWordCheck').attr("disabled", true);
            $('#keywordsTextArea').attr("placeholder", "example: \\w\\w\\w");
            $('#keywordsLabel').html("Regular Expression:");
            changeText($(this).val());
        }
        else {
            $('#caseSensitiveCheck').removeAttr("disabled");
            $('#wholeWordCheck').removeAttr("disabled");
            $('#keywordsTextArea').attr("placeholder", "example: fake, news, trump");
            $('#keywordsLabel').html("Spam Keywords");
            changeText($(this).val());
        }
    })
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

function changeText(algorithm) {
    iterator = algorithm;
    executeErasingEffect();
    setTimeout('executeTypingEffect()', 1000);
}

function executeTypingEffect() {
    if (iterator == 0) {
        caption = "Using Boyer-Moore";
        textLength = 11;
    }
    else if (iterator == 1) {
        caption = "Using KMP";
        textLength = 3;
    }
    else {
        caption = "Using Regex";
        textLength = 5;
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