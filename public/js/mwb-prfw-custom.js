jQuery(document).ready(function() {
    anwer_expand();
    star_click();
    hide_title();
});

function anwer_expand() {
    jQuery('.mwb_prfw-review_see_more_button').css('opacity','0');
    jQuery('.mwb_asnwerdqstn_main').is(function() {
        var para_see = jQuery(this);
        var divHeight = para_see.height();
        var lineHeight = parseInt(para_see.css('line-height'));
        var lines = divHeight / lineHeight;
        if (lines >= 2) {
            para_see.addClass('max-height_add');
            para_see.parent().find('.mwb_prfw-review_see_more_button').css('opacity','1');
        }
    });
    jQuery('.mwb_prfw-review_see_more_button').on('click', function() {
        jQuery(this).parent().parent().find('.mwb_asnwerdqstn_main').toggleClass('expand_answer_tab');
        if (jQuery(this).parent().parent().find('.mwb_asnwerdqstn_main').hasClass('expand_answer_tab')) {
            jQuery(this).text('See less...');
        } else {
            jQuery(this).text('See more...');
        }
    });
}

function star_click() {
    jQuery('.mwb_prfw-star_before_input').on('click', function() {
        jQuery(this).next().trigger('click');
        jQuery(this).prevAll().children('path').css('fill', '#ff7a00');
        jQuery(this).children('path').css('fill', '#ff7a00');
        jQuery(this).nextAll().children('path').css('fill', '');
    });
}

function hide_title() {
    jQuery('#submit_form_qa').on('click',function() {
        jQuery('div[aria-describedby=mwb_qa_form_div] .ui-dialog-title').css('display','none');
    });
}