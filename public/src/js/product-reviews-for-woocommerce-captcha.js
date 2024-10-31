(function( $ ) {
	'use strict';
})( jQuery );
jQuery(document).ready(function( $ ) {

	var enable_capctha = prfw_google_captcha.captcha_enable;
	if( enable_capctha ) {
		var site_key = prfw_google_captcha.api_site_key;
		if( site_key ) {
			grecaptcha.ready(function() {
				grecaptcha.execute( site_key, {action: 'homepage'}).then(function(token) {
				   document.getElementById("token").value = token;
				   document.getElementById("qa_token").value = token;				   
				});
			 });
		}	
	}

})
