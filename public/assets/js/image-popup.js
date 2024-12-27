var imgPopup = $('.global-img-popup');
var popupImage = $('.global-img-popup img');
var closeBtn = $('.img-popup-close-btn');

// handle events
$(document).on('click', '.container-img-holder', function() {
    var img_src = $(this).children('img').attr('src');
    imgPopup.children('.img-container').children('img').attr('src', img_src);
    imgPopup.addClass('opened');

    $('.download-btn').attr('href', img_src);
});

$(imgPopup, closeBtn).on('click', function() {
    imgPopup.removeClass('opened');
    imgPopup.children('.img-container').children('img').attr('src', '');
});

popupImage.on('click', function(e) {
    e.stopPropagation();
});