function resizeCaptcha() {
    //check if needs to be resized
    if (jQuery("#recaptcha_widget_div").length > 0  && jQuery("#content").width() < 450) {
        // move stuff around
        jQuery("#recaptcha_table tbody tr").eq(0).after('<tr id="recaptcha_responsive_holder"></tr>');
        jQuery("#recaptcha_reload_btn").parent().appendTo(jQuery("#recaptcha_responsive_holder"));
        jQuery("#recaptcha_logo").appendTo(jQuery("#recaptcha_responsive_holder td"));
        jQuery("#recaptcha_tagline").appendTo(jQuery("#recaptcha_responsive_holder td"));

        // reformat
        jQuery(".recaptchatable td img").css("display","inline-block");
        
        // delete extra cells
        jQuery("#recaptcha_table tbody tr").eq(0).children().eq(1).remove();
        jQuery("#recaptcha_table tbody tr").eq(2).children().eq(1).remove();
        jQuery("#recaptcha_table tbody tr").eq(2).children().eq(1).remove();
    }
    if (jQuery("#content").width() < 330) {
        //resize
        jQuery("#recaptcha_response_field").width(200);
        jQuery("#recaptcha_image, #recaptcha_image img").width(200);
    }
    else {
        jQuery("#recaptcha_response_field").css("width","302px");
        jQuery("#recaptcha_image, #recaptcha_image img").width(302);

    }
}

jQuery(document).ready(function(){
    resizeCaptcha();
    // setup resize hook. Use a time buffer to stop a billion events from happening.
    var resizeTimer;
    jQuery(window).resize(function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(resizeCaptcha, 100);
    });

});
