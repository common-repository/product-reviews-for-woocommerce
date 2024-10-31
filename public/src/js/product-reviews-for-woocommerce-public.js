jQuery(document).ready(function( $ ) {

	// Question asking.
	$("#mwb_qa_form_div").dialog({
		modal : true,
		autoOpen : false,
		show : {effect: "blind", duration: 800},
		width : 700,
		draggable : false,
	});
	$("#mwb_ask_qa").on('click', function() {
		$("#mwb_qa_form_div").dialog("open")
		$(".mwb_prfw_qa_submit").css(" cursor", "not-allowed");
		$(".mwb_prfw_qa_submit").css("pointer-events", "none");
		$(".mwb_prfw_qa_submit").css("background-color", "rgb( 70, 70, 70 )");
	})
	$("#submit_form_qa").on('click', function() {
		
		var name_val = $("#mwb_qa_form_name_field").val();	
		var email_val = $("#mwb_qa_form_email_field").val();
		var qstn_val = $("#mwb_qa_form_question_field").val();
		var qstn_token = $("#qa_token").val();
		if ( '' !== qstn_val ) {
			$(this).css("border", "2px solid green");
			var product_id = $("#mwb_qa_form_comment_product_id").val();
			$.ajax({
			url: prfw_public_param.ajaxurl,
			type: 'POST',
			data: {
				action : 'mwb_create_custom_comment_qa',
				name_val : name_val,
				email_val : email_val,
				qstn_val : qstn_val,
				product_id : product_id,
				qstn_token : qstn_token,
				nonce : prfw_public_param.nonce,
			},
			success: function(data) {
				if ( 'success' == data ) {
					var q_txt = prfw_public_param.mwb_prfw_qstn_submit_text;
					$("#mwb_qa_form_div").html(q_txt);
						$(".ui-dialog-titlebar-close").on('click', function() {
							location.reload();
							$('.wc-tabs li').each(function(){
								$(this).removeClass('active');
							});
							$("#tab-title-mwb_qa_tab").addClass('active');
						});
				} else {
					$("#mwb_qa_form_div").dialog("close");
					Swal.fire( {
						icon : 'error',
						title: prfw_public_param.mwb_prfw_vaildation_captcha_text,
					} );
					
				}
				
				
			}
		});
		} else {
			$("#mwb_qa_form_question_field").nextAll('span:first').html("Required");
			$(".mwb_prfw_qa_submit").css(" cursor", "not-allowed");
			$(".mwb_prfw_qa_submit").css("pointer-events", "none");
			$(".mwb_prfw_qa_submit").css("background-color", "rgb( 70, 70, 70 )");

		}
	});
	
	// Answer reply.
	$(".mwb_reply_qa_button").on('click', function() {
		var val = $(this).data('comment-id')

		$("#mwb_answer_dialog" + val).dialog({
			modal : true,
			autoOpen : false,
			show : {effect: "blind", duration: 800},
			width : 700,
			draggable : false,
		});
		$("#mwb_answer_dialog" + val).parent().addClass('mwb_prfw_answer_dialog');
		$("#mwb_answer_dialog" + val).dialog("open")
		$(".mwb_prfw_qa_submit").css(" cursor", "not-allowed");
		$(".mwb_prfw_qa_submit").css("pointer-events", "none");
		$(".mwb_prfw_qa_submit").css("background-color", "rgb( 70, 70, 70 )");
		var enable_capctha = prfw_public_param.captcha_enable;
		if( enable_capctha ) {
			var site_key = prfw_public_param.api_site_key;
			if( site_key ) {
				grecaptcha.ready(function() {
					grecaptcha.execute( site_key, {action: 'homepage'}).then(function(token) {
						if( token ) {
							document.getElementById("answer_token" + val ).value = token;
						}
					});
				});
			}	
		}
	});

	$(".mwb_submit_reply").on('click', function() {
		var val = $(this).data('comment-id');
		var pval = $(this).data('product-id');
		var reply_name_val = $("#mwb_ans_form_name_field" + val).val();
		var reply_email_val = $("#mwb_ans_form_email_field" + val).val();
		var reply_qstn_val = $("#mwb_ans_form_answer_field" + val ).val();
		var answer_token = 	$("#answer_token" + val ).val();
			$.ajax({
			url: prfw_public_param.ajaxurl,
			type: 'POST',
			data: {
				action : 'mwb_reply_qa',
				name_val : reply_name_val,
				email_val : reply_email_val,
				reply_qstn_val : reply_qstn_val,
				product_id : pval,
				comment_id : val,
				answer_token : answer_token,
				nonce : prfw_public_param.nonce,
			},
			success: function(data) {
				console.log(data);
				if ( 'success' == data ) {
					var a_txt = prfw_public_param.mwb_prfw_ans_submit_text;

					$("#mwb_answer_dialog" + val).html(a_txt);
					$(".ui-dialog-titlebar-close").on('click', function() {
						location.reload();
						$('.wc-tabs li').each(function(){
							$(this).removeClass('active');
						});
						$("#tab-title-mwb_qa_tab").addClass('active');
					});
				} else {
					$("#mwb_answer_dialog" + val).dialog("close");
					Swal.fire( {
						icon : 'error',
						title: prfw_public_param.mwb_prfw_vaildation_captcha_text,
					} );
					
				}
			
			}
		});
	});
	var mwb_add = prfw_public_param.mwb_add_form;
	if ( mwb_add ) {
		var reply_value = $(document).find('#commentform');
		var len = reply_value.length;
		if ( len > 0 ) {
			document.getElementById('commentform').enctype = 'multipart/form-data';
		}


	}

	// Upload Imges Using Ajax
	var image_validation = prfw_public_param.mwb_prfw_image_vaildation
	$(document).on('change', '#mwb_review_image', function(e){
		var filedata = $('#mwb_review_image')[0].files;
		var form = jQuery('#commentform')[0];
		var varform = new FormData(form);
		if ( filedata.length > 5 ) {
				Swal.fire( {
					icon : 'error',
					title: image_validation,
				} );
		} else if( filedata.length < 1 ) {
			return false;
		} else {
			varform.append('file', filedata[0]);
			if (filedata.length > 0) {
			    for (let i = 0; i <= filedata.length - 1; i++) {
	   
				   const fsize = filedata.item(i).size;
				   const file = Math.round((fsize / 1024));
				   if (file >= 4096) {
					alert(prfw_public_param.mwb_prfw_max_image_size);
					return;
				   } else if (file < 50) {
					  alert(prfw_public_param.mwb_prfw_min_image_size);
					  return;
				   } else {
					varform.append('action', 'mwb_prfw_upload_images');
					varform.append('nonce', prfw_public_param.nonce );				
					$.ajax({
						url: prfw_public_param.ajaxurl,
						type: 'POST',
						data: varform,
						cache : false,
						processData: false,
						contentType: false,
						crossDomain:true,
						dataType : 'json',
						success : function(msg) {
							$('#mwb_prfw_ajax_url_uploaded_image').val(JSON.stringify(msg));
							var html_img = '';
							for (i = 0; i < msg.length; i++) {
									var mwb_prfw_file_type =  msg[i].split('.').pop();
									if( mwb_prfw_file_type == 'jpg' || mwb_prfw_file_type == 'jpeg' || mwb_prfw_file_type == 'png' || mwb_prfw_file_type == 'svg' || mwb_prfw_file_type == 'gif' || mwb_prfw_file_type == 'tiff' || mwb_prfw_file_type == 'bmp' || mwb_prfw_file_type == 'raw' || mwb_prfw_file_type == 'eps' ) {

										html_img += '<div class="mwb_prfw_image_show_wrapper"><div class="dashicons dashicons-no mwb_prfw_image_server_url" data-url=' + msg[i] + ' ></div><img height="100px" width="100px" src=' + msg[i] +'></div>';
									} else {
										html_img += '<div class="mwb_prfw_image_show_wrapper"><div class="dashicons dashicons-no mwb_prfw_image_server_url" data-url=' + msg[i] + ' ></div><video width="200" controls ><source src=' + msg[i] + '></video></div>';

									}

							}
							$("#mwb_prfw_show_upload_images").html(html_img);
						},
						error: function(msg) {
						}
					});

				}
			    }
			}
		}
	
	});

	jQuery( document ).on( 'click', '.mwb_prfw_image_server_url', function( e ) {

		let url = jQuery( this ).attr( 'data-url' );
		let input = jQuery( '#mwb_prfw_ajax_url_uploaded_image' ).val();
		input = JSON.parse( input );
		for( var i in input ) {
			if(input[i] == url ) {
				input.splice( i, 1 );
			    break;
			}
		}
		var updated_url = JSON.stringify(input);
		jQuery( '#mwb_prfw_ajax_url_uploaded_image' ).val(updated_url);
		jQuery( this ).css( 'display', 'none' );
		jQuery( this ).nextAll('img:first').css( 'display', 'none' );
		jQuery( this ).nextAll('video:first').css( 'display', 'none' );

		
	} );
	// Js using File upload.
	// Submit form through ajax.
	var allow_ajax = prfw_public_param.allow_ajax;
	if ( allow_ajax ) {
		$(" #commentform #submit").on('click', function(e){
			e.preventDefault();
			var rating_val = $("#rating").val();
			var comment_val = $("#comment").val();
			var formdata = $("#commentform").serializeArray();
			if( ( '' != rating_val ) && ( '' != comment_val ) ) {
							
				$.ajax({
					url: prfw_public_param.ajaxurl,
					type: 'POST',
					data: {
						action : 'mwb_prfw_submit_ajax_review_form',
						nonce : prfw_public_param.nonce,
						formdata : formdata,
					},
					success : function(msg) {
	
						if ( 'success' == msg ) {
							var txt = prfw_public_param.review_submit_ajax_msg;
							Swal.fire( {
								icon : 'success',
								title: txt,
							} );
							$("#respond").html('');
						} else {
							
							Swal.fire( {
								icon : 'error',
								title: prfw_public_param.mwb_prfw_vaildation_captcha_text,
							} );
							
						}
					},
					error: function(msg) {
						alert('error')
					}
				});	

			} else {
				alert(prfw_public_param.mwb_prfw_comment_text_require);
			}

			
		});
	}
	
	var show_review_from_modal = prfw_public_param.mwb_review_modal
	if( show_review_from_modal ) {

		$("#review_form").dialog({
			modal : true,
			autoOpen : false,
			show : {effect: "blind", duration: 800},
			width : 700,
			draggable : false,
			title : 'Add a review',
		});
		$("#mwb_allow_popup_form").on('click', function() {
			$("#review_form").dialog("open")
		});
		$('#review_form').parent().addClass('mwb_prfw_review_modal_form');
		
		$("#submit").on('click', function() {
			var rating_val = $("#rating").val();
			var comment_val = $("#comment").val();
			if( ( '' != rating_val ) && ( '' != comment_val ) ) {

				$("#review_form").dialog("close")
			}
		});

	}

	// function to vote review.
	function mwb_review_vote( comment_id, vote_value, self ) {
		$.ajax({
			url: prfw_public_param.ajaxurl,
			type: 'POST',
			data: {
				action : 'mwb_review_voting',
				comment_id : comment_id,
				vote_val : vote_value,
				nonce : prfw_public_param.nonce,
			},
			success: function(data) {
				if( vote_value == 'yes' ) {
					$(self).nextAll('span:first').html(data[0]);
					$(self).nextAll('span:nth-of-type(2)').html(data[1]);

				} else {
					$(self).nextAll('span:first').html(data[1]);
					$(self).prev('span').html(data[0]);
				}				
			}
		});
	}
	
	// review voting ajax
	$(".mwb_prfw_review_vote").on('click', function() {
		var comment_id = $(this).data('comment-id');
		var vote_val = $(this).data('vote-value');
		mwb_review_vote( comment_id, vote_val, this );		
	})

	

})
 		// Short code js

	// dESINGER'S WORK.
	jQuery(document).ready(function( $ ) {
		slick_slider();
		expand_review();
		like_dislike_button();
	
	function expand_review() {

		jQuery('.mwb_prfw-review_footer_more').css('opacity', '0');
		jQuery('.mwb_prfw-review_body_para').is(function() {
		var para_see = jQuery(this);
		var divHeight = para_see.height();
		var lineHeight = parseInt(para_see.css('line-height'));
		var lines = divHeight / lineHeight;
		if (lines >= 2) {
			para_see.addClass('add_extra_view');
			para_see.parent().parent().parent('ul').find('.mwb_prfw-review_footer_more').css('opacity', '1');
		}
		});
		jQuery('.mwb_prfw-review_footer_more').on('click', function() {
		$(this).parent().parent().prev().find('.mwb_prfw-review_body_para').toggleClass('expand_review');
		if ($(this).parent().parent().prev().find('.mwb_prfw-review_body_para').hasClass('expand_review')) {
			$(this).text('See less...');
		} else {
			$(this).text('See more...');
		}
		});
	
	}
 
	function slick_slider() {
		$('.mwb_prfw_slide-review_container_wrapper, .responsive, .multiple-items, .center,.autoplay').slick({
		centerMode: true,
		centerPadding: '60px',
		autoplay: true,
		autoplaySpeed: 3000,
		dots: false,
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		responsive: [{
				breakpoint: 1024,
				settings: {
					slidesToShow: 1,
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
					centerMode: false,
				}
			}
		]
		});
	}
 
	function like_dislike_button() {
		jQuery('.mwb_prfw-review_footer_like').on('click', function() {
		$('.mwb_prfw-review_footer_like').find('path').css('fill', '#c7c7c7');
		$(this).find('path').css('fill', '#11aaff');
		$('.mwb_prfw-review_footer_dislike').find('path').css('fill', '#c7c7c7');
		});
	
		jQuery('.mwb_prfw-review_footer_dislike').on('click', function() {
		$('.mwb_prfw-review_footer_dislike').find('path').css('fill', '#c7c7c7');
		$(this).find('path').css('fill', '#11aaff');
		$('.mwb_prfw-review_footer_like').find('path').css('fill', '#c7c7c7');
		});
	}


 	// Adding custom class for design.
	$(".commentlist").addClass('mwb_prfw_comment_parent_wrapper');
	$("#review_form").addClass('mwb_prfw_review_custom_wrapper');




	// Validation's data 

	var email_validation_text = prfw_public_param.mwb_prfw_email_validate;
	var name_validation_text = prfw_public_param.mwb_prfw_name_validate;
	$(".mwb_prfw_text_qa").keyup(function() {
		$(this).val($(this).val().replace(/  +/g, ' '));
	});
	$('.mwb_prfw_text_qa').on('blur',function () {
		var val = $(this).val();
		if (val == "") {
		$(this).focus();
		$(this).css("border", "2px solid red");
		
		}
		if (val) {
			
			var pat = /^[a-zA-Z ]+$/i.test(val);
		if (!pat) {
				$(this).nextAll('span:first').html(name_validation_text);
			$(this).focus();
			$(this).css("border", "2px solid red");
			$(".mwb_prfw_qa_submit").css(" cursor", "not-allowed");
			$(".mwb_prfw_qa_submit").css("pointer-events", "none");
			$(".mwb_prfw_qa_submit").css("background-color", "rgb( 70, 70, 70 )");

		}
		else {
			$(this).css("border", "2px solid green");
			$(this).nextAll('span:first').html('');
		}
		}
	});
	$('.mwb_prfw_email_qa').on('blur',function () {
		var val = $(this).val();

		if (val == "") {
		$(this).focus();
		$(this).css("border", "2px solid red");	   
		}
		if (val) {
			var pat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/i.test(val);
			if (!pat) {
					$(this).focus();
					$(this).nextAll('span:first').html(email_validation_text);

					$(this).css("border", "2px solid red");
					$(".mwb_prfw_qa_submit").css(" cursor", "not-allowed");
					$(".mwb_prfw_qa_submit").css("pointer-events", "none");
					$(".mwb_prfw_qa_submit").css("background-color", "rgb( 70, 70, 70 )");
			}
			else {		   
				$(this).css("border", "2px solid green"); 
					$(".mwb_prfw_qa_submit").css(" cursor", "");
					$(".mwb_prfw_qa_submit").css("pointer-events", "");
					$(".mwb_prfw_qa_submit").css("background-color", "");
					$(this).nextAll('span:first').html('');				
			}
		}
	});
	$('.mwb_prfw_qa_field_text_area').on('blur',function () {
		var val = $(this).val();

		if (val == "") {
		$(this).focus();
		$(this).css("border", "2px solid red");
		$(this).css("border", "2px solid red");
				$(".mwb_prfw_qa_submit").css(" cursor", "not-allowed");
				$(".mwb_prfw_qa_submit").css("pointer-events", "none");
				$(".mwb_prfw_qa_submit").css("background-color", "rgb( 70, 70, 70 )");	   
		} else {		   
			$(this).css("border", "2px solid green"); 
				$(".mwb_prfw_qa_submit").css(" cursor", "");
				$(".mwb_prfw_qa_submit").css("pointer-events", "");
				$(".mwb_prfw_qa_submit").css("background-color", "");
		}
	});
});
