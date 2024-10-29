jQuery(document).ready(function($) {



	jQuery("span.question-mark").on('click', function () {
		var title = jQuery(this).attr('data-title');
		var content = jQuery(this).attr('data-content');

		swal({
			title: title,
			text: content,
			icon: "info",
			button: "Close"
		});
	});


	// if(jQuery(".adfoxlydatepicker").length) {
	jQuery('.adfoxlydatepicker-campaign-start').daterangepicker({
		autoUpdateInput: false,
		singleDatePicker: true,
		locale: {
			format: 'YYYY-MM-DD'
		}
	}, function(chosen_date) {
		jQuery('.adfoxlydatepicker-campaign-start').val(chosen_date.format('YYYY-MM-DD'));
	});

	jQuery('.adfoxlydatepicker-campaign-end').daterangepicker({
		autoUpdateInput: false,
		singleDatePicker: true,
		locale: {
			format: 'YYYY-MM-DD'
		}
	}, function(chosen_date) {
		jQuery('.adfoxlydatepicker-campaign-end').val(chosen_date.format('YYYY-MM-DD'));
	});

	// }


	function customPlacesShowHide() {
		if ( jQuery('#adfoxly-adzone-place_custom').prop('checked') === true ) {
			jQuery(".adfoxly-groups-custom-choose").css('display', 'flex');
			customNewPlacesShowHide();
		} else {
			jQuery(".adfoxly-groups-custom-choose").hide();
			jQuery(".adfoxly-groups-custom-new").hide();
		}
	}

	function customNewPlacesShowHide() {
		if ( jQuery('#new_group').prop('checked') === true ) {
			jQuery(".adfoxly-groups-custom-new").css('display', 'flex');
		} else {
			jQuery(".adfoxly-groups-custom-new").hide();
		}
	}

	customPlacesShowHide();
	customNewPlacesShowHide();

	jQuery('label[for="adfoxly-adzone-place_custom"]').on('click', function (e) {
		customPlacesShowHide();
	});

	jQuery('label[for="new_group"]').on('click', function (e) {
		setTimeout(function(){
			customNewPlacesShowHide();
		}, 50);
	});

	jQuery('label.file-item[for="adfoxly-format_image"]').on('click', function (e) {
		jQuery("#adfoxly-format_image").attr('checked', true);
		setTimeout(function() {
			if (jQuery('#wizard').length > 0) {
				jQuery("#next-btn").click();
			}
		}, 50);
		return false;
	});

	jQuery('label.file-item[for="adfoxly-format_google_adsense"]').on('click', function (e) {
		jQuery("#adfoxly-format_google_adsense").attr('checked', true);
		setTimeout(function() {
			if (jQuery('#wizard').length > 0) {
				jQuery("#next-btn").click();
			}
		}, 50);
		return false;
	});

	jQuery('label.file-item[for="adfoxly-format_custom_code"]').on('click', function (e) {
		jQuery("#adfoxly-format_custom_code").attr('checked', true);
		setTimeout(function() {
			if (jQuery('#wizard').length > 0) {
				jQuery("#next-btn").click();
			}
		}, 50);
		return false;
	});

	jQuery('label.file-item[for="adfoxly-format_video"]').on('click', function (e) {
		jQuery("#adfoxly-format_video").attr('checked', true);
		setTimeout(function() {
			if (jQuery('#wizard').length > 0) {
				jQuery("#next-btn").click();
			}
		}, 50);
		return false;
	});

	if (jQuery('#wizard').length > 0) {
		jQuery("#wizard").steps({
			headerTag: ".step-header",
			bodyTag: "section",
			titleTemplate: '#title#',
			transitionEffect: "fade",
			autoFocus: true
		});
	};

	if (jQuery("input[name='adfoxly-format']")) {
		var $bannerAdFormat = jQuery("input[name='adfoxly-format']:checked").val();
		if ($bannerAdFormat === 'image') {
			jQuery('.ad-format-group-image').css('display', 'flex');
			jQuery('.ad-format-group-google-adsense').hide();
			jQuery('.ad-format-group-video').hide();
			jQuery('.ad-format-group-custom-code').hide();
		} else if ($bannerAdFormat === 'google_adsense') {
			jQuery('.ad-format-group-google-adsense').css('display', 'flex');
			jQuery('.ad-format-group-image').hide();
			jQuery('.ad-format-group-video').hide();
			jQuery('.ad-format-group-custom-code').hide();
		} else if ($bannerAdFormat === 'custom_code') {
			jQuery('.ad-format-group-image').hide();
			jQuery('.ad-format-group-google-adsense').hide();
			jQuery('.ad-format-group-video').hide();
			jQuery('.ad-format-group-custom-code').css('display', 'flex');
		} else if ($bannerAdFormat === 'video') {
			jQuery('.ad-format-group-video').css('display', 'flex');
			jQuery('.ad-format-group-image').hide();
			jQuery('.ad-format-group-google-adsense').hide();
			jQuery('.ad-format-group-custom-code').hide();
		}

	}

	// adCampaign
	// admin.php?page=adfoxly-new#step-6
	if (jQuery("input[name='adfoxly-campaign-exists']")) {
		var $bannerAdCampaign = jQuery("input[name='adfoxly-campaign-exists']:checked").val();

		if ($bannerAdCampaign === 'no-campaign') {
			jQuery('.ad-format-group-adfoxly-campaign-new-campaign-wrapper').hide();
			jQuery('.ad-format-group-adfoxly-campaign-choose-campaign-wrapper').hide();
		} else if ($bannerAdCampaign === 'exists') {
			jQuery('.ad-format-group-adfoxly-campaign-new-campaign-wrapper').hide();
			jQuery('.ad-format-group-adfoxly-campaign-choose-campaign-wrapper').css('display', 'flex');
		} else if ($bannerAdCampaign === 'no-exists') {
			jQuery('.ad-format-group-adfoxly-campaign-new-campaign-wrapper').css('display', 'flex');
			jQuery('.ad-format-group-adfoxly-campaign-choose-campaign-wrapper').hide();
			if (jQuery('#home2').length) {
				var $adFoxlyTabInnerWidth = jQuery("#home2").innerWidth() - 30;
				jQuery('.select2').css('width', $adFoxlyTabInnerWidth);
			}
		}
	}

	jQuery(".custom-control").bind("click", function () {
		var $bannerAdCampaign = jQuery("input[name='adfoxly-campaign-exists']:checked").val();

		if ($bannerAdCampaign === 'no-campaign') {
			jQuery('.ad-format-group-adfoxly-campaign-new-campaign-wrapper').hide();
			jQuery('.ad-format-group-adfoxly-campaign-choose-campaign-wrapper').hide();
		} else if ($bannerAdCampaign === 'exists') {
			jQuery('.ad-format-group-adfoxly-campaign-new-campaign-wrapper').hide();
			jQuery('.ad-format-group-adfoxly-campaign-choose-campaign-wrapper').css('display', 'flex');
		} else if ($bannerAdCampaign === 'no-exists') {
			jQuery('.ad-format-group-adfoxly-campaign-new-campaign-wrapper').css('display', 'flex');
			jQuery('.ad-format-group-adfoxly-campaign-choose-campaign-wrapper').hide();
			if (jQuery('#home2').length) {
				var $adFoxlyTabInnerWidth = jQuery("#home2").innerWidth() - 30;
				jQuery('.select2').css('width', $adFoxlyTabInnerWidth);
			}
		}
	});

	// if ($("input[name='adfoxly-adzone-is-rotate']") && $("input[name='adfoxly-adzone-how-rotate']") && $("input[name='adfoxly-adzone-rotate-time']")) {
	if (jQuery("input[name='adfoxly-adzone-how-rotate']") && jQuery("input[name='adfoxly-adzone-rotate-time']")) {

		// var $isRotate  = $("input[name='adfoxly-adzone-is-rotate']:checked").val();
		var $howRotate = jQuery("input[name='adfoxly-adzone-how-rotate']:checked").val();

		// if ($isRotate === 'yes') {
		// 	$("#adfoxly-adzone-how-rotate-wrapper").css('display', "flex");

		if ($howRotate === 'time') {
			jQuery(".adfoxly-adzone-rotate-time-wrapper").css('display', "flex");
		} else if ($howRotate === 'slider') {
			jQuery(".adfoxly-adzone-rotate-slider-wrapper").css('display', "flex");
		} else if ($howRotate === 'grid') {
			jQuery(".adfoxly-adzone-rotate-grid-wrapper").css('display', "flex");
		} else {
			jQuery(".adfoxly-adzone-rotate-time-wrapper").hide();
		}
		// } else {
		// 	$("#adfoxly-adzone-how-rotate-wrapper").hide();
		// 	$("#adfoxly-adzone-rotate-time-wrapper").hide();
		// }

		jQuery(".custom-control").bind("click", function () {

			// var $isRotate  = $("input[name='adfoxly-adzone-is-rotate']:checked").val();
			var $howRotate = jQuery("input[name='adfoxly-adzone-how-rotate']:checked").val();

			// if ($isRotate === 'yes') {
			// 	$("#adfoxly-adzone-how-rotate-wrapper").css('display', "flex");

			if ($howRotate === 'time') {
				jQuery(".adfoxly-adzone-rotate-time-wrapper").css('display', "flex");
				jQuery(".adfoxly-adzone-rotate-grid-wrapper").hide();
				jQuery(".adfoxly-adzone-rotate-slider-wrapper").hide();
			} else if ($howRotate === 'slider') {
				jQuery(".adfoxly-adzone-rotate-slider-wrapper").css('display', "flex");
				jQuery(".adfoxly-adzone-rotate-time-wrapper").hide();
				jQuery(".adfoxly-adzone-rotate-grid-wrapper").hide();
			} else if ($howRotate === 'grid') {
				jQuery(".adfoxly-adzone-rotate-grid-wrapper").css('display', "flex");
				jQuery(".adfoxly-adzone-rotate-slider-wrapper").hide();
				jQuery(".adfoxly-adzone-rotate-time-wrapper").hide();
			} else {
				jQuery(".adfoxly-adzone-rotate-time-wrapper").hide();
				jQuery(".adfoxly-adzone-rotate-slider-wrapper").hide();
				jQuery(".adfoxly-adzone-rotate-grid-wrapper").hide();
			}


			var $isPopup = jQuery("input[name='adfoxly-adzone-place']:checked").val();
			if ($isPopup === 'popup') {
				jQuery(".adfoxly_page_adfoxly-new .adfoxly-adzone-popup-delay-wrapper").css('display', 'flex');
				jQuery(".adfoxly_page_adfoxly-new .adfoxly-adzone-popup-repeat-wrapper").css('display', 'flex');
			} else {
				jQuery(".adfoxly_page_adfoxly-new .adfoxly-adzone-popup-delay-wrapper").hide();
				jQuery(".adfoxly_page_adfoxly-new .adfoxly-adzone-popup-repeat-wrapper").hide();
			}
			// adfoxly-adzone-place_popup
			// } else {
			// 	$("#adfoxly-adzone-how-rotate-wrapper").hide();
			// 	$("#adfoxly-adzone-rotate-time-wrapper").hide();
			// }
		});
	}

	function validateAllInputs() {
		var allValid = !$(".invalid-feedback").is(":visible");
		if (allValid) {
			jQuery('#form-invalid-feedback').hide();
			jQuery('[name="adfoxly-form-action"]').prop('disabled', false);
			jQuery('#next-btn').prop('disabled', false);
		}
	}

	jQuery('.adfoxly-adzone-place_custom').bind('click', function () {
		validateAllInputs();
		var $selectedPlace = jQuery(this).find('input').val();
		if ($selectedPlace === 'new') {
			jQuery('.new-place-wrapper').css('display', 'flex');
			jQuery(".adfoxly-adzone-how-rotate-wrapper").hide();
			jQuery(".adfoxly-adzone-rotate-slider-wrapper").hide();
			jQuery(".adfoxly-adzone-rotate-grid-wrapper").hide();
			jQuery(".adfoxly-adzone-rotate-time-wrapper").hide();

			jQuery( '[name="predefined_adfoxly-adzone-place"]' ).each(function( index ) {
				if (jQuery(this).is(':checked')) {
					jQuery(".adfoxly-places-settings").css('display', "flex");
					jQuery(".adfoxly-place-name").css('display', "flex");
					return false;
				} else {
					// $('#adfoxly-place-sticky-position-wrapper').hide();
					jQuery(".adfoxly-places-settings").hide();
					jQuery(".adfoxly-place-name").hide();
				}
			});

			if ( jQuery('.adfoxly-adzone-place_predefined .adfoxly-input-slug-popup[name="predefined_adfoxly-adzone-place"]').is(':checked') ) {
				jQuery(".adfoxly-adzone-popup-delay-wrapper").css('display', 'flex');
				jQuery(".adfoxly-adzone-popup-repeat-wrapper").css('display', 'flex');
			} else {
				jQuery(".adfoxly-adzone-popup-delay-wrapper").hide();
				jQuery(".adfoxly-adzone-popup-repeat-wrapper").hide();
			}

			if ( jQuery('.adfoxly-adzone-place_predefined .adfoxly-input-slug-sticky[name="predefined_adfoxly-adzone-place"]').is(':checked') ) {
				jQuery('#adfoxly-place-sticky-position-wrapper').css('display', 'flex');
				jQuery('#adfoxly-place-sticky-close-wrapper').css('display', 'flex');
			} else {
				jQuery('#adfoxly-place-sticky-position-wrapper').hide();
				jQuery('#adfoxly-place-sticky-close-wrapper').hide();
			}

			if ( jQuery('.adfoxly-adzone-place_predefined .adfoxly-input-slug-inside-the-post[name="predefined_adfoxly-adzone-place"]').is(':checked') ) {
				jQuery('#adfoxly-place-insidepost-position-wrapper').css('display', 'flex');
			} else {
				jQuery('#adfoxly-place-insidepost-position-wrapper').hide();
			}

		} else {
			jQuery('.new-place-wrapper').hide();
			jQuery(".adfoxly-place-name").hide();
			jQuery("#adfoxly-place-sticky-position-wrapper").hide();
			jQuery('#adfoxly-place-sticky-close-wrapper').hide();
			jQuery('#adfoxly-place-insidepost-position-wrapper').hide();
			jQuery('#adfoxly-place-insidepost-position-paragraph-wrapper').hide();
			jQuery(".adfoxly-places-settings").css('display', "flex");
			jQuery(".adfoxly-adzone-how-rotate-wrapper").css('display', 'flex');
		}
	});

	jQuery('.adfoxly-adzone-place_predefined').bind('click', function () {
		jQuery('.adfoxly-place-name .invalid-feedback').hide();
		validateAllInputs();

		// valudatePlaceName('[name="adfoxly-place-name"]');

		var $that = this;
		var $nameValue = jQuery("[name='adfoxly-place-name']").val();
		if ( $nameValue === "" ) {
			jQuery("[name='adfoxly-place-name']").val( jQuery($that).find('.custom-control-label').html() );
		} else {
			jQuery("[name='adfoxly-place-name']").val( jQuery($that).find('.custom-control-label').html() );
		}

		jQuery(".adfoxly-adzone-how-rotate-wrapper").hide();
		jQuery(".adfoxly-adzone-rotate-slider-wrapper").hide();
		jQuery(".adfoxly-adzone-rotate-grid-wrapper").hide();
		jQuery(".adfoxly-adzone-rotate-time-wrapper").hide();

		jQuery('[name="predefined_adfoxly-adzone-place"]').each(function( index ) {
			if (jQuery(this).is(':checked')) {
				jQuery(".adfoxly-places-settings").css('display', "flex");
				jQuery(".adfoxly-place-name").css('display', "flex");

				if ( jQuery('.adfoxly-adzone-place_predefined .adfoxly-input-slug-popup[name="predefined_adfoxly-adzone-place"]').is(':checked') ) {
					jQuery(".adfoxly-adzone-popup-delay-wrapper").css('display', 'flex');
					jQuery(".adfoxly-adzone-popup-repeat-wrapper").css('display', 'flex');
				} else {
					jQuery(".adfoxly-adzone-popup-delay-wrapper").hide();
					jQuery(".adfoxly-adzone-popup-repeat-wrapper").hide();
				}

				if ( jQuery('.adfoxly-adzone-place_predefined .adfoxly-input-slug-sticky[name="predefined_adfoxly-adzone-place"]').is(':checked') ) {
					jQuery('#adfoxly-place-sticky-position-wrapper').css('display', 'flex');
					jQuery('#adfoxly-place-sticky-close-wrapper').css('display', 'flex');
				} else {
					jQuery('#adfoxly-place-sticky-position-wrapper').hide();
					jQuery('#adfoxly-place-sticky-close-wrapper').hide();
				}

				if ( jQuery('.adfoxly-adzone-place_predefined .adfoxly-input-slug-inside-the-post[name="predefined_adfoxly-adzone-place"]').is(':checked') ) {
					jQuery('#adfoxly-place-insidepost-position-wrapper').css('display', 'flex');
				} else {
					jQuery('#adfoxly-place-insidepost-position-wrapper').hide();
				}

				return false;
			} else {
				jQuery(".adfoxly-places-settings").hide();
				jQuery(".adfoxly-place-name").hide();
			}

			if ( jQuery('.adfoxly-adzone-place_predefined .adfoxly-input-slug-sticky[name="predefined_adfoxly-adzone-place"]').is(':checked') ) {
				jQuery('#adfoxly-place-sticky-position-wrapper').css('display', 'flex');
				jQuery('#adfoxly-place-sticky-close-wrapper').css('display', 'flex');
			} else {
				jQuery('#adfoxly-place-sticky-position-wrapper').hide();
				jQuery('#adfoxly-place-sticky-close-wrapper').hide();
			}

			if ( jQuery('.adfoxly-adzone-place_predefined .adfoxly-input-slug-inside-the-post[name="predefined_adfoxly-adzone-place"]').is(':checked') ) {
				jQuery('#adfoxly-place-insidepost-position-wrapper').css('display', 'flex');
				if (jQuery('#adfoxly-place-insidepost-position_x').is(':checked')) {
					jQuery('#adfoxly-place-insidepost-position-paragraph-wrapper').css('display', 'flex');
				} else {
					jQuery('#adfoxly-place-insidepost-position-paragraph-wrapper').hide();
				}
			} else {
				jQuery('#adfoxly-place-insidepost-position-wrapper').hide();
				jQuery('#adfoxly-place-insidepost-position-paragraph-wrapper').hide();
			}
		});
		// $('.adfoxly-places-settings').css('display', 'flex');

		// var $selectedPlace = $(this).find('input').val();
	});


	jQuery('.adfoxly-adzone-place_custom').bind('click', function () {
		var $that = this;
		var $nameValue = jQuery("[name='adfoxly-place-name']").val();
		if ( $nameValue === "" ) {
			jQuery("[name='adfoxly-place-name']").val( jQuery($that).find('.custom-control-label').html() );
		} else {
			jQuery("[name='adfoxly-place-name']").val( jQuery($that).find('.custom-control-label').html() );
		}

	});

	function validateAdName( that ) {
		var $adName = jQuery(that).val();
		var $current_ad_id = jQuery("input[name='adfoxly-banner-id']").val();

		if ( ! $current_ad_id ) {
			$current_ad_id = 'new';
		}

		jQuery.ajax({
			// todo: url as variable
			url: '/wp-admin/admin-ajax.php',
			type: 'post',
			data: {
				action: 'adfoxly_ad_name_availability',
				ad_name: $adName,
				current_ad_id: $current_ad_id
			},
			success: function (response) {
				if (response === 'true') {
					jQuery('.adfoxly-ad-name .invalid-feedback').show();
					jQuery('#next-btn').prop('disabled', true);
					jQuery('#form-invalid-feedback').show();
				} else {
					jQuery('.adfoxly-ad-name .invalid-feedback').hide();
					validateAllInputs();
				}
			},
			error: function (response) {
				console.log('error');
				jQuery('#next-btn').prop('disabled', true);
				jQuery('.adfoxly-ad-name #form-invalid-feedback').show();
				console.log(response);
			}
		});
	}

	function validateCampaignName( that ) {
		var $campaignName = jQuery(that).val();
		var $current_campaign_id = jQuery("input[name='adfoxly-campaign-id']").val();
		//
		if ( ! $current_campaign_id ) {
			$current_campaign_id = 'new';
		}

		if ( $campaignName.length > 0 ) {
			jQuery.ajax({
				// todo: url as variable
				url: '/wp-admin/admin-ajax.php',
				type: 'post',
				data: {
					action: 'adfoxly_campaign_name_availability',
					campaign_name: $campaignName,
					current_campaign_id: $current_campaign_id
				},
				success: function (response) {
					if (response === 'true') {
						jQuery('.adfoxly-campaign-name .invalid-feedback').show();
						jQuery('#next-btn').prop('disabled', true);
						jQuery('[name="adfoxly-form-action"]').prop('disabled', true);
						jQuery('#form-invalid-feedback').show();
					} else {
						jQuery('.adfoxly-campaign-name .invalid-feedback').hide();
						validateAllInputs();
					}
				},
				error: function (response) {
					console.log('error');
					jQuery('#next-btn').prop('disabled', true);
					jQuery('[name="adfoxly-form-action"]').prop('disabled', true);
					jQuery('.adfoxly-campaign-name #form-invalid-feedback').show();
					console.log(response);
				}
			});
		}
	}

	function validatePlaceName( that ) {
		var $placeName = jQuery(that).val();
		var $current_place_id = jQuery("input[name='adfoxly-place-id']").val();
		//
		if ( ! $current_place_id ) {
			$current_place_id = 'new';
		}

		if ( $placeName.length > 0 ) {
			jQuery.ajax({
				// todo: url as variable
				url: '/wp-admin/admin-ajax.php',
				type: 'post',
				data: {
					action: 'adfoxly_place_name_availability',
					place_name: $placeName,
					current_place_id: $current_place_id
				},
				success: function (response) {
					if (response === 'true') {
						jQuery('.adfoxly-place-name .invalid-feedback').show();
						jQuery('#next-btn').prop('disabled', true);
						jQuery('[name="adfoxly-form-action"]').prop('disabled', true);
						jQuery('#form-invalid-feedback').show();
					} else {
						jQuery('.adfoxly-place-name .invalid-feedback').hide();
						validateAllInputs();
					}
				},
				error: function (response) {
					console.log('error');
					jQuery('#next-btn').prop('disabled', true);
					jQuery('.adfoxly-place-name #form-invalid-feedback').show();
					console.log(response);
				}
			});
		}
	}

	function validateTargetUrl( that ) {
		var $targetURL = jQuery(that).val();

		if ( $targetURL.length > 0 ) {

			var regexp = new RegExp("^(http|https)://", "i");

			if ( regexp.test($targetURL) ) {
				jQuery('.adfoxly-target-url .invalid-feedback').hide();
				validateAllInputs();
			} else {
				jQuery('.adfoxly-target-url .invalid-feedback').show();
				jQuery('#next-btn').prop('disabled', true);
				jQuery('#form-invalid-feedback').show();
			}

		}
	}

	function valudatePlaceName(that) {
		// console.log(jQuery(that).val());

		var $place_name = jQuery(that).val();
		jQuery.ajax({
			// todo: url as variable
			url: '/wp-admin/admin-ajax.php',
			type: 'post',
			data: {
				action: 'adfoxly_place_name_availability',
				place_name: $place_name,
				status: 'active'
			},
			success: function (response) {
				// iziToast.success({
				// 	title: 'Success!',
				// 	message: 'Ad ' + $name + ' has been enabled',
				// 	position: 'topRight'
				// });


				if (response === 'true') {
					jQuery('.adfoxly-place-name .invalid-feedback').show();
					jQuery('#next-btn').prop('disabled', true);
					jQuery('#form-invalid-feedback').show();
					// console.log('zajęte');
					// console.log(response);
				} else {
					jQuery('.adfoxly-place-name .invalid-feedback').hide();
					validateAllInputs();
				}
			},
			error: function (response) {
				// iziToast.error({
				// 	title: 'Oops.',
				// 	message: 'There is some problem in saving ad ' + $name,
				// 	position: 'topRight'
				// });
				console.log('error');
				jQuery('#next-btn').prop('disabled', true);
				jQuery('#form-invalid-feedback').show();
				console.log(response);
			}
		});


	}

	// jQuery('[name="adfoxly-place-name"]').keyup(function () {
	// 	var that = this;
	// 	valudatePlaceName(that);
	// });
	//
	// jQuery('[name="adfoxly-place-name"]').focusout(function () {
	// 	var that = this;
	// 	valudatePlaceName(that);
	// });
	//
	// jQuery('[name="adfoxly-place-name"]').focusin(function () {
	// 	var that = this;
	// 	valudatePlaceName(that);
	// });



	jQuery('[name="adfoxly-ad-name"]').keyup(function () {
		var that = this;
		validateAdName(that);
	});

	jQuery('[name="adfoxly-ad-name"]').focusout(function () {
		var that = this;
		validateAdName(that);
	});

	jQuery('[name="adfoxly-ad-name"]').focusin(function () {
		var that = this;
		validateAdName(that);
	});


	jQuery('[name="adfoxly-campaign-name"]').keyup(function () {
		var that = this;
		validateCampaignName(that);
	});

	jQuery('[name="adfoxly-campaign-name"]').focusout(function () {
		var that = this;
		validateCampaignName(that);
	});

	jQuery('[name="adfoxly-campaign-name"]').focusin(function () {
		var that = this;
		validateCampaignName(that);
	});

	jQuery('[name="adfoxly-place-name"]').keyup(function () {
		var that = this;
		validatePlaceName(that);
	});

	jQuery('[name="adfoxly-place-name"]').focusout(function () {
		var that = this;
		validatePlaceName(that);
	});

	jQuery('[name="adfoxly-place-name"]').focusin(function () {
		var that = this;
		validatePlaceName(that);
	});

	jQuery('[name="adfoxly-target-url"]').keyup(function () {
		var that = this;
		validateTargetUrl(that);
	});

	jQuery('[name="adfoxly-target-url"]').focusout(function () {
		var that = this;
		validateTargetUrl(that);
	});

	jQuery('[name="adfoxly-target-url"]').focusin(function () {
		var that = this;
		validateTargetUrl(that);
	});



	//

	jQuery('[name="adfoxly-place-insidepost-position"]').bind('click', function () {
		if (jQuery(this).val() === 'x') {
			jQuery('#adfoxly-place-insidepost-position-paragraph-wrapper').css('display', 'flex');
		} else {
			jQuery('#adfoxly-place-insidepost-position-paragraph-wrapper').hide();
		}
	});

	if (jQuery("input[name='adfoxly-statistics-status']") && jQuery("input[name='adfoxly-statistics-type[]']") && jQuery("input[name='adfoxly-statistics-gaid']")) {
		var $statisticsTypeArr = [];
		var $statisticsStatus = jQuery("input[name='adfoxly-statistics-status']:checked").val();
		var $statisticsType   = jQuery("input[name='adfoxly-statistics-type[]']:checked").each(function() {
			$statisticsTypeArr.push(this.value);
		});

		var $statisticsGaID   = jQuery("input[name='adfoxly-statistics-gaid-select']:checked").val();

		if ($statisticsStatus === 'enabled') {
			jQuery("#adfoxly-statistics-type-wrapper").css('display', "flex");
			jQuery("#adfoxly-statistics-saving-view-interval-wrapper").css('display', "flex");
			if ($statisticsTypeArr.includes('google-analytics')) {
				jQuery("#adfoxly-statistics-gaid-wrapper").css('display', "flex");

				if ($statisticsGaID === 'other') {
					jQuery("#adfoxly-statistics-custom-gaid-wrapper").css('display', "flex");
				} else {
					jQuery("#adfoxly-statistics-custom-gaid-wrapper").hide();
				}
			} else {
				jQuery("#adfoxly-statistics-gaid-wrapper").hide();
				jQuery("#adfoxly-statistics-custom-gaid-wrapper").hide();
			}
		} else {
			jQuery("#adfoxly-statistics-type-wrapper").hide();
			jQuery("#adfoxly-statistics-gaid-wrapper").hide();
			jQuery("#adfoxly-statistics-custom-gaid-wrapper").hide();
			jQuery("#adfoxly-statistics-saving-view-interval-wrapper").hide();
		}


		jQuery(".custom-control").bind("click", function () {
			var $statisticsTypeArr = [];
			var $statisticsStatus = jQuery("input[name='adfoxly-statistics-status']:checked").val();
			var $statisticsType   = jQuery("input[name='adfoxly-statistics-type[]']:checked").each(function() {
				$statisticsTypeArr.push(this.value);
			});
			var $statisticsGaID   = jQuery("input[name='adfoxly-statistics-gaid-select']:checked").val();
			var $bannerAdFormat   = jQuery("input[name='adfoxly-format']:checked").val();

			if ($statisticsStatus === 'enabled') {
				jQuery("#adfoxly-statistics-type-wrapper").css('display', "flex");
				jQuery("#adfoxly-statistics-saving-view-interval-wrapper").css('display', "flex");
				if ($statisticsTypeArr.includes('google-analytics')) {
					jQuery("#adfoxly-statistics-gaid-wrapper").css('display', "flex");

					if ($statisticsGaID === 'other') {
						jQuery("#adfoxly-statistics-custom-gaid-wrapper").css('display', "flex");
					} else {
						jQuery("#adfoxly-statistics-custom-gaid-wrapper").hide();
					}
				} else {
					jQuery("#adfoxly-statistics-gaid-wrapper").hide();
					jQuery("#adfoxly-statistics-custom-gaid-wrapper").hide();
				}
			} else {
				jQuery("#adfoxly-statistics-type-wrapper").hide();
				jQuery("#adfoxly-statistics-gaid-wrapper").hide();
				jQuery("#adfoxly-statistics-custom-gaid-wrapper").hide();
				jQuery("#adfoxly-statistics-saving-view-interval-wrapper").hide();
			}
		});

		if (jQuery("input[name='adfoxly-format']")) {
			jQuery('#step-1-form .file-item').bind("click", function () {
				var $bannerAdFormat = jQuery("input[name='adfoxly-format']:checked").val();
				if ($bannerAdFormat === 'image') {
					jQuery('.ad-format-group-image').css('display', 'flex');
					jQuery('.ad-format-group-google-adsense').hide();
					jQuery('.ad-format-group-video').hide();
					jQuery('.ad-format-group-custom-code').hide();
					validateTargetUrl('[name="adfoxly-target-url"]');
					validateAllInputs();
				} else if ($bannerAdFormat === 'google_adsense') {
					jQuery('.ad-format-group-google-adsense').css('display', 'flex');
					jQuery('.ad-format-group-image .invalid-feedback').hide();
					jQuery('.ad-format-group-image').hide();
					jQuery('.ad-format-group-video').hide();
					jQuery('.ad-format-group-custom-code').hide();
					validateAllInputs();

				} else if ($bannerAdFormat === 'custom_code') {
					jQuery('.ad-format-group-image').hide();
					jQuery('.ad-format-group-image .invalid-feedback').hide();
					jQuery('.ad-format-group-google-adsense').hide();
					jQuery('.ad-format-group-video').hide();
					jQuery('.ad-format-group-custom-code').css('display', 'flex');
					validateAllInputs();
				} else if ($bannerAdFormat === 'video') {
					jQuery('.ad-format-group-video').css('display', 'flex');
					jQuery('.ad-format-group-image').hide();
					jQuery('.ad-format-group-image .invalid-feedback').hide();
					jQuery('.ad-format-group-google-adsense').hide();
					jQuery('.ad-format-group-custom-code').hide();
					validateAllInputs();
				}
			});
		}

		// $('label.file-item[for="adfoxly-adzone-place_12"]').bind('click', function () {
		// 	var $bannerCustomPlace = $("input#adfoxly-adzone-place_12:checked").val();
		// 	if ( $bannerCustomPlace === '12' ) {
		// 		$(".nav-item-step-4.nav-item").show();
		// 	} else {
		// 		$(".nav-item-step-4.nav-item").hide();
		// 	}
		// });
	}

	jQuery('#adfoxly-ad-preview-summary').attr('src', jQuery('#adfoxly-ad-preview').attr('src'));
});


window.onload = function () {

	jQuery('#smartwizard').smartWizard({
		selected: 0,  // Initial selected step, 0 = first step
		keyNavigation: false, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
		autoAdjustHeight: true, // Automatically adjust content height
		cycleSteps: false, // Allows to cycle the navigation of steps
		backButtonSupport: true, // Enable the back button support
		useURLhash: true, // Enable selection of the step based on url hash
		toolbarSettings: {
			toolbarPosition: 'bottom', // none, top, bottom, both
			toolbarButtonPosition: 'left', // left, right
			showNextButton: false, // show/hide a Next button
			showPreviousButton: false, // show/hide a Previous button
			// toolbarExtraButtons: [
			// 	$('<button></button>').text('Finish')
			// 		.addClass('btn btn-info')
			// 		.on('click', function(){
			// 			alert('Finsih button click');
			// 		}),
			// 	$('<button></button>').text('Cancel')
			// 		.addClass('btn btn-danger')
			// 		.on('click', function(){
			// 			alert('Cancel button click');
			// 		})
			// ]
		},
		anchorSettings: {
			anchorClickable: true, // Enable/Disable anchor navigation
			enableAllAnchors: false // Activates all anchors clickable all times
			// markDoneStep: true, // add done css
			// enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
		}
	});

	jQuery("#prev-btn").on("click", function () {
		var $activeTab = jQuery(".step-anchor").find('.active').find('a').attr('href');
		if ($activeTab === '#step-5' && $bannerCustomPlace !== '12' ) {
			jQuery('#smartwizard').smartWizard("prev");
		}
		jQuery('#smartwizard').smartWizard("prev");
		jQuery("html, body").animate({ scrollTop: 0 }, "slow");
		return true;
	});

	jQuery("#next-btn").on("click", function ($) {

		var $activeTab = jQuery(".step-anchor").find('.active').find('a').attr('href');

		console.log($activeTab);
		console.log(jQuery('#smartwizard').length);
		if ($activeTab === '#step-6' || jQuery('#smartwizard').length < 1 ) {

			jQuery('#next-btn').prop('disabled', false);
			jQuery("#new-ad-wizard-form").submit();

			// jQuery('#next-btn').on('click', function(event) {
			// 	jQuery('#next-btn').prop('disabled', false);
			// 	jQuery("#new-ad-wizard-form").submit();

				// var $place_name = jQuery('[name="adfoxly-place-name"]').val();
				// jQuery.ajax({
				// 	// todo: url as variable
				// 	url: '/wp-admin/admin-ajax.php',
				// 	type: 'post',
				// 	data: {
				// 		action: 'adfoxly_place_name_availability',
				// 		place_name: $place_name,
				// 		status: 'active'
				// 	},
				// 	success: function (response) {
				// 		if (response === 'true') {
				// 			jQuery('.adfoxly-place-name .invalid-feedback').show();
				// 			jQuery('#form-invalid-feedback').show();
				// 			jQuery('#next-btn').prop('disabled', true);
				// 			event.preventDefault();
				// 		} else {
				// 			jQuery('.adfoxly-place-name .invalid-feedback').hide();
				// 			jQuery('#form-invalid-feedback').hide();
				// 			jQuery('#next-btn').prop('disabled', false);
				// 			jQuery("#new-ad-wizard-form").submit();
				// 		}
				// 	},
				// 	error: function (response) {
				// 		event.preventDefault();
				// 		alert("Form submission stopped. Error found.");
				// 		// console.log('error');
				// 		jQuery('#form-invalid-feedback').show();
				// 		console.log(response);
				// 	}
				// });
			// });

		} else {
			// $($activeTab + '-form').parsley().whenValidate().done(function () {
			if ( jQuery('#smartwizard').length > 0 ) {
				jQuery('#smartwizard').smartWizard("next");
			}
			jQuery("html, body").animate({ scrollTop: 0 }, "fast");
			return true;
			// });
		}

	});

	jQuery("#save-btn").on("click", function () {
		jQuery("#new-ad-wizard-form").submit();
	});

	function wizard_summary() {
		jQuery("#adfoxly-campaigns-start-date-summary-wrapper").hide();
		jQuery("#adfoxly-campaigns-end-date-summary-wrapper").hide();

		jQuery("#adfoxly-ad-name-summary").html(jQuery("#adfoxly-ad-name").val());
		jQuery("#adfoxly-target-url-summary").html(jQuery("#adfoxly-target-url").val());

		var $listOfPlaces = jQuery('.form-check-flat .custom-control-input:checkbox:checked');
		var placesNames = '';
		$listOfPlaces.each(function( index ) {
			if (placesNames === '') {
				placesNames = jQuery($listOfPlaces[index]).parent().find('label').html();
			} else {
				placesNames = placesNames + ", " + jQuery( $listOfPlaces[index]).parent().find('label').html();
			}
		});
		jQuery("#adfoxly-places-summary").html(placesNames);

		var $listOfCampaigns = jQuery('.ad-format-group-adfoxly-campaign-choose-campaign-wrapper .custom-control-input:checkbox:checked');

		if (jQuery('#adfoxly-campaign-exists_no-exists').is(":checked")) {
			jQuery("#adfoxly-campaigns-summary").html(jQuery("#adfoxly-campaign-name").val());
		} else {
			var campaignsNames = '';
			$listOfCampaigns.each(function( index ) {
				if (campaignsNames === '') {
					campaignsNames = jQuery($listOfCampaigns[index]).parent().parent().find('label').html()
				} else {
					campaignsNames = campaignsNames + ", " + jQuery($listOfCampaigns[index]).parent().parent().find('label').html()
				}
			});
			jQuery("#adfoxly-campaigns-summary").html(campaignsNames);
		}


		if ( jQuery("#adfoxly-ad-campaign-start").val() !== '' && jQuery('#adfoxly-campaign-exists_no-exists').is(":checked")) {
			jQuery("#adfoxly-campaigns-start-date-summary").html( jQuery("#adfoxly-ad-campaign-start").val() );
			jQuery("#adfoxly-campaigns-start-date-summary-wrapper").show();
		}

		if ( jQuery("#adfoxly-ad-campaign-end").val() !== '' && jQuery('#adfoxly-campaign-exists_no-exists').is(":checked")) {
			jQuery("#adfoxly-campaigns-end-date-summary").html( jQuery("#adfoxly-ad-campaign-end").val() );
			jQuery("#adfoxly-campaigns-end-date-summary-wrapper").show();
		}
	}

	jQuery("#next-btn").on("click", function () {

		var $activeTab = jQuery(".step-anchor").find('.active').find('a').attr('href');

		if ($activeTab == '#step-6') {
			wizard_summary();
		}
	});

	jQuery(".nav-link").on("click", function () {
		var $activeTab = jQuery(".step-anchor").find('.active').find('a').attr('href');

		if ($activeTab == '#step-6') {
			wizard_summary();
		}
	});

	jQuery("#smartwizard").show();
	jQuery(".loaded-content").show();
	jQuery(".loader").hide();
	jQuery(".loading-content").hide();

};
