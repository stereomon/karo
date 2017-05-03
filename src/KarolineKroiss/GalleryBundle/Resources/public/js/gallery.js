$(document).ready(function(){
    var currentImageId = $('#active-image').data('id');
    $('div').find("[data-id='" + currentImageId + "']").show();

    $('.thumb').click(function(){
        var clickedId = $(this).data('id');
        if (currentImageId !== clickedId) {
            var currentImage = $('#slideshow').find("[data-id='" + currentImageId + "']");
            var selectedImage = $('#slideshow').find("[data-id='" + clickedId + "']");

            currentImage.fadeOut();
            currentImage.removeAttr('class');
            currentImage.attr('style', 'display:none');

            selectedImage.fadeIn();
            selectedImage.attr('class', 'active-image');
            selectedImage.removeAttr('height');
            selectedImage.removeAttr('width');

            currentImageId = clickedId;
        }
    });
});
