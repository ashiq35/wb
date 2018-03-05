// This function will be executed when the user scrolls the page.
jQuery(window).scroll(function (e) {
    // Get the position of the location where the scroller starts.
    var scroller_anchor = jQuery(".scroller_anchor").offset().top;
    var divWidth = jQuery(".widget").innerWidth();

    // Check if the user has scrolled and the current position is after the scroller start location and if its not already fixed at the top 
    if (jQuery(this).scrollTop() >= scroller_anchor && jQuery('.scroller').css('position') !== 'fixed') {    // Change the CSS of the scroller to hilight it and fix it at the top of the screen.
        jQuery('.scroller').css({
            'position': 'fixed',
            'top': '110px',
            'width': divWidth

        });

        // Changing the height of the scroller anchor to that of scroller so that there is no change in the overall height of the page.
        jQuery('.scroller_anchor').css('height', '50px');
    }
    else if (jQuery(this).scrollTop() < scroller_anchor && jQuery('.scroller').css('position') !== 'relative') {    // If the user has scrolled back to the location above the scroller anchor place it back into the content.

        // Change the height of the scroller anchor to 0 and now we will be adding the scroller back to the content.
        jQuery('.scroller_anchor').css('height', '0px');

        // Change the CSS and put it back to its original position.
        jQuery('.scroller').css({
            'position': 'relative',
            'bottom': '0px',
            'top': '0px'
        });
    }
});

/*Hide the div*/

jQuery.fn.isVisible = function () {
    var rect = this[0].getBoundingClientRect();
    return (
        (rect.height > 0 || rect.width > 0) &&
        rect.bottom >= 0 &&
        rect.right >= 0 &&
        rect.top <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.left <= (window.innerWidth || document.documentElement.clientWidth)
    );
};

function doCheck() {
    var elementToDetect = jQuery('.tab-content.review-tabs');

    if (elementToDetect.isVisible()) {
        jQuery('.scroller').css({
            'display': 'block'
        });
    } else {
        jQuery('.scroller').css({
            'display': 'none'
        });
    }

}

jQuery(document)
    .ready(function (e) {
        doCheck();
    });

jQuery(window)
    .scroll(function (e) {
        doCheck();
    });


/*Author reviews */
jQuery(function () {
    jQuery("#ddlPassport").change(function () {
        if (jQuery(this).val() == "Y") {
            jQuery("#dvPassport").show();
            console.log('YES');
        } else {
            jQuery("#dvPassport").hide();
            console.log('No');
        }
    });
});