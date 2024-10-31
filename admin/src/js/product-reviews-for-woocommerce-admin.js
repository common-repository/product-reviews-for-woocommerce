	jQuery(document).ready(function( $ ) {

		$(document).on('change', '#mwb_prfw_enable_seo_boost', function() {
			
			if ( $(this).prop('checked') ) {
				$(".prfw-show-hide__wrapper").show();
			} else {
				$(".prfw-show-hide__wrapper").hide();
			}
		});
		$(document).on('change', '#mwb_prfw_enable_custom_gtin', function() {
			
			if ( $(this).prop('checked') ) {
				$("#mwb_prfw_prefix_mpn").closest(".mwb-prfw-text").show();
			} else {
				$("#mwb_prfw_prefix_mpn").closest(".mwb-prfw-text ").hide();
			}
		});
		$(document).on('change', '#mwb_prfw_enable_brand', function() {
			
			if ( $(this).prop('checked') ) {
				$("#mwb_prfw_brand_name").closest(".mwb-prfw-text").show();
			} else {
				$("#mwb_prfw_brand_name").closest(".mwb-prfw-text ").hide();
			}
		});
		
		
		$(document).ready(function() {
		 
			$(".mwb-password-hidden").on( 'click', function() {
			  if ($(".mwb-form__password").attr("type") == "text") {
			    $(".mwb-form__password").attr("type", "password");
			  } else {
			    $(".mwb-form__password").attr("type", "text");
			  }
			});
		});







		function send_ajax( type, value ) {
			$.ajax({
					url: prfw_admin_param.ajaxurl,
					type: 'POST',
					data: {
						action : 'mwb_change_status_comment',
						id : value,
						type : type,
						nonce : prfw_admin_param.nonce
					},
					success: function(data) {
						window.location.reload();
					}
			});
		}


		$(".unapprove_data").on('click', function() {
			var id = jQuery(this).data('id')
			send_ajax( 'unapprove', id );
		})
		$(".mwb_approve_comment").on('click', function() {
			var id = jQuery(this).data('id')
			send_ajax( 'approve', id );
		})
		
		$(".trash_comment").on('click', function() {
			var id = jQuery(this).data('id')
			send_ajax( 'trash', id );
		})
		$(".spam_comment").on('click', function() {
			var id = jQuery(this).data('id')
			send_ajax( 'spam', id );
		})
		$(".mwb_unspam").on('click', function() {
			var id = jQuery(this).data('id')
			send_ajax( 'unspam', id );
		})
		$(".mwb_prfw_permanent_delete").on('click', function() {
			var id = jQuery(this).data('id')
			send_ajax( 'mwb_prfw_permanent_delete', id );
		})
		$(".mwb_prfw_restore_comment").on('click', function() {
			var id = jQuery(this).data('id')
			send_ajax( 'mwb_prfw_restore_comment', id );
		})
		$(".mwb_reply_comment_button").on('click', function() {
			var id = jQuery(this).data('id')
			var pid = jQuery(this).data('post-id')
			var comment_type = jQuery(this).data('comment-type')
			var html = '<div class="me-here"><textarea rows="4" cols="120" ></textarea><button class="button mwb-submit-reply" data-post-id="' + pid + '" data-comment-id="' + id + '" data-comment-type = "' + comment_type + '" class="mwb-submit-reply">submit</button></div>';
			$(html).insertAfter($(this).closest('tr'));
		})
		$(document).on('click','.mwb-submit-reply',function( e ){
			e.preventDefault();
			var c_id = $(this).data('comment-id');
			var product_id = $(this).data('post-id');
			var comment_type = jQuery(this).data('comment-type')
			var reply_value = $(this).closest('.me-here').find('textarea').val();
			$.ajax({
				url: prfw_admin_param.ajaxurl,
				type: 'POST',
				data: {
					action : 'mwb_coment_reply_custom',
					pid : product_id,
					reply : reply_value,
					c_id : c_id,
					comment_type : comment_type,
					nonce    : prfw_admin_param.nonce
				},
				success: function(data) {
					window.location.reload();
					
				}
			});
		});


		// Dynamic field setting.
		$(document).on('click','.mwb_prfw_delete_button_feature_review_field', function( e ){
			e.preventDefault();
			$(".mwb_prfw_delete_button_feature_review_field").attr( "disabled", "disabled" );
			var data_index = $(this).data('index-input');
			var self = this;
			$.ajax({
				url : prfw_admin_param.ajaxurl,
				method : 'post',
				data : {
					action : 'mwb_prfw_delete_input_box',
					nonce  : prfw_admin_param.nonce,
					input_index : data_index,
				},
				success : function(msg) {
					$(self).closest('.mwb_prfw_dynamic_label').find('label').remove();
					$(".mwb_prfw_delete_button_feature_review_field").removeAttr("disabled");
					$(self).remove();
				},
				error : function() {
					alert('error');
				}
			});
			
			
		});

		$(".mwb_prfw_add_review_feature_field").on('click', function( e ){

			$(this).attr( "disabled", "disabled" );
			var self = $(this);
			e.preventDefault();
			$.ajax({
				url : prfw_admin_param.ajaxurl,
				method : 'post',
				data : {
					action : 'mwb_prfw_add_input_box',
					nonce  : prfw_admin_param.nonce,
				},
				success : function(msg) {
					$('.mwb_prfw_dynamic_field_storage').append(msg);
					self.removeAttr("disabled");
				},
				error : function() {
					alert('error');
				}
			});
			
		});


		// on clicking call ajax for getting user's wallet details
		$(document).on('click', '#mwb_download_csv_file_dummy', function( e ){
			e.preventDefault();
			$.ajax({
				url : prfw_admin_param.ajaxurl,
				method : 'post',
				data : {
					action : 'mwb_prfw_download_dummy_csv_ajax',
					nonce  : prfw_admin_param.nonce,
				},
				datatType: 'JSON',
				success: function( response ) {
					var filename = 'mwb_reviews_dummy.csv';
					let csvContent = "data:text/csv;charset=utf-8,";
					response.forEach(function(rowArray) {
						let row = rowArray.join(",");
						csvContent += row + "\r\n";
					});
					
					var encodedUri = encodeURI(csvContent);
					download(filename, encodedUri);
				}

			})
		});

		$(document).on('click', '#mwb_export_csv_file', function( e ){
			e.preventDefault();
			$.ajax({
				url : prfw_admin_param.ajaxurl,
				method : 'post',
				data : {
					action : 'mwb_prfw_export_csv_file',
					nonce  : prfw_admin_param.nonce,
				},
				datatType: 'JSON',
				success: function( response ) {
					var filename = 'mwb_reviews_data.csv';
					let csvContent = "data:text/csv;charset=utf-8,";
					response.forEach(function(rowArray) {
						let row = rowArray.join(",");
						csvContent += row + "\r\n";
					});
					
					var encodedUri = encodeURI(csvContent);
					download(filename, encodedUri);
				}

			})
		});

		// Download the user's wallet csv file on clicking button
		function download(filename, text) {
			var element = document.createElement('a');
			element.setAttribute('href', text);
			element.setAttribute('download', filename);
			element.style.display = 'none';
			document.body.appendChild(element);
			// automatically run the click event for anchor tag
			element.click();
		
			document.body.removeChild(element);
			

		}

		// Sent custom reminder
		$(document).on('click', '.mwb_prfw_manual_reminder', function() {
			var order_id = $(this).data('id');
			$(this).html(prfw_admin_param.mwb_prfw_sending);
			var self = this;
			$.ajax({
				url : prfw_admin_param.ajaxurl,
				method : 'post',
				data : {
					action : 'mwb_prfw_send_manual_reminder',
					nonce  : prfw_admin_param.nonce,
					order_id     : order_id,
				},
				success: function( response ) {
					Swal.fire( {
						icon : 'success',
						title : prfw_admin_param.mwb_prfw_sent,
						text : prfw_admin_param.reminder_msg,
					} );
					$(self).html(prfw_admin_param.mwb_prfw_sent);
				},
				error : function( response ) {

				},

			})
			
		});


		$(window).load(function() {
			// add select2 for multiselect.
			if ($(document).find(".mwb-defaut-multiselect").length > 0) {
			  $(document)
			    .find(".mwb-defaut-multiselect")
			    .select2();
			}
		   });

	});
	