(function ($) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

		// Instantiates the variable that holds the media library frame.
	var metaImageFrame;

	// Runs when the media button is clicked.
	$('#adfoxly-image_button').click(function (e) {

		// Get the btn
		var btn = e.target;

		// Check if it's the upload button
		if (!btn || !$(btn).attr('data-media-uploader-target')) return;

		// Get the field target
		var field = $(btn).data('media-uploader-target');

		// Prevents the default action from occuring.
		e.preventDefault();

		// Sets up the media library frame
		metaImageFrame = wp.media.frames.metaImageFrame = wp.media({
			title: "Choose or Upload Media",
			button: {text: 'Use this file'},
		});

		// Runs when an image is selected.
		metaImageFrame.on('select', function () {

			// Grabs the attachment selection and creates a JSON representation of the model.
			var media_attachment = metaImageFrame.state().get('selection').first().toJSON();

			// Sends the attachment URL to our custom image input field.
			jQuery(field).val(media_attachment.url);

			jQuery('#adfoxly-ad-preview').attr('src', media_attachment.url);
			jQuery('#adfoxly-ad-preview-summary').attr('src', media_attachment.url);
			jQuery('#adfoxly-ad-name').attr('value', media_attachment.title);
			jQuery('#adfoxly-ad-name-summary').attr('value', media_attachment.title);

		});

		// Opens the media library frame.
		metaImageFrame.open();

	});


})(jQuery);
jQuery(document).ready(function($) {

	var primaryColor = getComputedStyle(document.body).getPropertyValue('--primary');
	var secondaryColor = getComputedStyle(document.body).getPropertyValue('--secondary');
	var successColor = getComputedStyle(document.body).getPropertyValue('--success');
	var warningColor = getComputedStyle(document.body).getPropertyValue('--warning');
	var dangerColor = getComputedStyle(document.body).getPropertyValue('--danger');
	var infoColor = getComputedStyle(document.body).getPropertyValue('--info');
	var darkColor = getComputedStyle(document.body).getPropertyValue('--dark');
	var lightColor = getComputedStyle(document.body).getPropertyValue('--light');
	var lineChartStyleOption_2 = {
		scales: {
			yAxes: [{
				display: false
			}],
			xAxes: [{
				display: false
			}]
		},
		legend: {
			display: false
		},
		elements: {
			point: {
				radius: 0
			},
			line: {
				tension: 0
			}
		},
		stepsize: 100
	};

	if (jQuery('#statistics-graph-1').length) {
		var lineChartCanvas = jQuery("#statistics-graph-1").get(0).getContext("2d");
		var gradientStrokeFill_1 = lineChartCanvas.createLinearGradient(1, 2, 1, 400);
		gradientStrokeFill_1.addColorStop(0, '#fff');
		gradientStrokeFill_1.addColorStop(1, infoColor);

		var lineChart = new Chart(lineChartCanvas, {
			type: 'line',
			data: {
				labels: ["Day 1", "Day 2", "Day 3", "Day 4", "Day 5", "Day 6", "Day 7"],
				datasets: [{
					label: 'Profit',
					data: [3, 9, 7, 5, 7, 2, 8],
					borderColor: infoColor,
					backgroundColor: gradientStrokeFill_1,
					borderWidth: 2,
					fill: true
				}]
			},
			options: lineChartStyleOption_2
		});
	}
	if (jQuery('#statistics-graph-2').length) {
		var lineChartCanvas = jQuery("#statistics-graph-2").get(0).getContext("2d");
		var gradientStrokeFill_1 = lineChartCanvas.createLinearGradient(1, 2, 1, 400);
		gradientStrokeFill_1.addColorStop(0, '#fff');
		gradientStrokeFill_1.addColorStop(1, primaryColor);

		var lineChart = new Chart(lineChartCanvas, {
			type: 'line',
			data: {
				labels: ["Day 1", "Day 2", "Day 3", "Day 4", "Day 5", "Day 6", "Day 7"],
				datasets: [{
					label: 'Profit',
					data: [7, 9, 2, 2, 8, 7, 9],
					borderColor: primaryColor,
					backgroundColor: gradientStrokeFill_1,
					borderWidth: 2,
					fill: true
				}]
			},
			options: lineChartStyleOption_2
		});
	}
	if (jQuery('#statistics-graph-3').length) {
		var lineChartCanvas = jQuery("#statistics-graph-3").get(0).getContext("2d");
		var gradientStrokeFill_1 = lineChartCanvas.createLinearGradient(1, 2, 1, 400);
		gradientStrokeFill_1.addColorStop(0, '#fff');
		gradientStrokeFill_1.addColorStop(1, warningColor);

		var lineChart = new Chart(lineChartCanvas, {
			type: 'line',
			data: {
				labels: ["Day 1", "Day 2", "Day 3", "Day 4", "Day 5", "Day 6", "Day 7"],
				datasets: [{
					label: 'Profit',
					data: [5, 4, 7, 2, 9, 2, 8],
					borderColor: warningColor,
					backgroundColor: gradientStrokeFill_1,
					borderWidth: 2,
					fill: true
				}]
			},
			options: lineChartStyleOption_2
		});
	}
	if (jQuery('#statistics-graph-4').length) {
		var lineChartCanvas = jQuery("#statistics-graph-4").get(0).getContext("2d");
		var gradientStrokeFill_1 = lineChartCanvas.createLinearGradient(1, 2, 1, 400);
		gradientStrokeFill_1.addColorStop(0, '#fff');
		gradientStrokeFill_1.addColorStop(1, dangerColor);

		var lineChart = new Chart(lineChartCanvas, {
			type: 'line',
			data: {
				labels: ["Day 1", "Day 2", "Day 3", "Day 4", "Day 5", "Day 6", "Day 7"],
				datasets: [{
					label: 'Profit',
					data: [5, 2, 5, 2, 4, 4, 1],
					borderColor: dangerColor,
					backgroundColor: gradientStrokeFill_1,
					borderWidth: 2,
					fill: true
				}]
			},
			options: lineChartStyleOption_2
		});
	}


	// adfoxly-ad-status-checkbox

	// function adsStatusCheckboxLabel() {

	jQuery('.adfoxly-ad-status-checkbox').bind('click', function () {
		var $id = jQuery(this).attr('data-adfoxly-ad-status-id');
		var $name = jQuery(this).attr('data-adfoxly-ad-status-name');
		jQuery('.adfoxly-ad-status-description-' + $id).removeClass('adfoxly-ad-status-description-selected');
		if (jQuery(this).prop('checked') === true) {

			jQuery.ajax({
				// todo: url as variable
				url: '/wp-admin/admin-ajax.php',
				type: 'post',
				data: {
					action: 'adfoxly_ad_status',
					post_id: $id,
					status: 'active'
				},
				success: function (response) {
					iziToast.success({
						title: 'Success!',
						message: 'Ad ' + $name + ' has been enabled',
						position: 'topRight'
					});
				},
				error: function (response) {
					iziToast.error({
						title: 'Oops.',
						message: 'There is some problem in saving ad ' + $name,
						position: 'topRight'
					});
					console.log(response);
				}
			});

			jQuery('.adfoxly-ad-status-description-' + $id + '.adfoxly-ad-status-description-disabled').hide();
			jQuery('.adfoxly-ad-status-description-' + $id + '.adfoxly-ad-status-description-enabled').show();
		} else {

			jQuery.ajax({
				// todo: url as variable
				url: '/wp-admin/admin-ajax.php',
				type: 'post',
				data: {
					action: 'adfoxly_ad_status',
					post_id: $id,
					status: 'inactive'
				},
				success: function (response) {
					iziToast.success({
						title: 'Success!',
						message: 'Ad ' + $name + ' has been disabled',
						position: 'topRight'
					});
				},
				error: function (response) {
					iziToast.error({
						title: 'Oops.',
						message: 'There is some problem in saving ad ' + $name,
						position: 'topRight'
					});
					console.log(response);
				}
			});

			jQuery('.adfoxly-ad-status-description-' + $id + '.adfoxly-ad-status-description-enabled').hide();
			jQuery('.adfoxly-ad-status-description-' + $id + '.adfoxly-ad-status-description-disabled').show();
		}
	});

	// if ( $('.adfoxly-ad-status-checkbox').prop('checked') === true ) {
	// 	$(".adfoxly-groups-custom-choose").css('display', 'flex');
	// 	customNewPlacesShowHide();
	// } else {
	// 	$(".adfoxly-groups-custom-choose").hide();
	// 	$(".adfoxly-groups-custom-new").hide();
	// }
	// }



	jQuery(".ad-format-group-google-adsense small").click(function() {
		var $imgSrc = jQuery(this).attr('data-url');
		swal({
			content: {
				element: "img",
				attributes: {
					src: $imgSrc,
					alt: "Google AdSense Configuration"
				}
			}
		});
	});

	jQuery("#panel-body-11 img").click(function() {
		var $imgSrc = jQuery(this).attr('src');
		swal({
			content: {
				element: "img",
				attributes: {
					src: $imgSrc,
					alt: "Google AdSense Configuration"
				}
			}
		});
	});

	jQuery('.open-popover').popover({
		html: true,
		trigger: 'hover',
		content: function () {
			return '<img src="'+jQuery(this).data('img') + '" style="max-height: 150px; max-width: 200px; padding: 0"/>';
		}
	});

	var $notice = jQuery("html").find(".notice");
	var $upgradeNotice = jQuery("html").find(".update-nag");


	function createEditor(name) {
		// find the textarea
		var textarea = document.querySelector("form textarea[name=" + name + "]");
		var editor1 = document.querySelector("textarea[name=" + name + "]");

		// create ace editor
		var editor = ace.edit();
		// editor.container.style.height = "100px"
		editor.setTheme("ace/theme/monokai");
		editor.getSession().setMode("ace/mode/html");

		editor.session.setValue(textarea.value);

		// replace textarea with ace
		textarea.parentNode.insertBefore(editor.container, textarea);
		textarea.style.display = "none";
		// find the parent form and add submit event listener
		var form               = textarea;
		while (form && form.localName != "form") form = form.parentNode;
		editor.getSession().on('change', function() {
			// alert('ha!');
			textarea.value = editor.getValue();
			// update()
		});
		form.addEventListener("submit", function () {
			// update value of textarea to match value in ace
			textarea.value = editor.getValue();
		}, true)
	}

	if (jQuery("#adfoxly-facebook-pixel-code").length) {
		// createEditor("adfoxly-facebook-pixel-code");
	}

	// if(window.CodeMirror) {

	//CoreMirror disabled
	// $("#adfoxly-facebook-pixel-code").each(function() {
	// 	var editor = CodeMirror.fromTextArea(this, {
	// 		lineNumbers: true,
	// 		theme: "duotone-dark",
	// 		mode: 'javascript',
	// 		height: 200
	// 	});
	// 	editor.setSize("100%", 200);
	// });
	// }

	// admin.php?page=adfoxly-campaigns


	if(jQuery(".adfoxly-timepicker").length) {
		jQuery('.adfoxly-timepicker').timepicki();
	}

	// admin.php?page=adfoxly-campaigns
	function adfoxlyCheckSpecificHours(that) {
		var $adfoxlyClickedDayName = jQuery(that).attr('data-adfoxly-day');

		if (jQuery(".adfoxly-campaign-specific-hours-" + $adfoxlyClickedDayName).is(':checked')) {
			jQuery(".adfoxly-campaign-specific-hour-start-" + $adfoxlyClickedDayName).removeAttr('disabled');
			jQuery(".adfoxly-campaign-specific-hour-end-" + $adfoxlyClickedDayName).removeAttr('disabled');
		} else {
			jQuery(".adfoxly-campaign-specific-hour-start-" + $adfoxlyClickedDayName).prop("disabled", true);
			jQuery(".adfoxly-campaign-specific-hour-end-" + $adfoxlyClickedDayName).prop("disabled", true);
		}
	}

	jQuery('.adfoxly-campaign-days').click(function() {
		adfoxlyCheckSpecificHours(this);
	});

	if (jQuery('#dashboard-area-chart').length) {


		function roundNearest(num, acc) {
			if (acc < 0) {
				num *= acc;
				num = Math.round(num);
				num /= acc;
				return num;
			} else {
				num /= acc;
				num = Math.round(num);
				num *= acc;
				return num;
			}
		}


		var $data   = jQuery('#dashboard-area-chart').attr('data-views');
		var $labels = jQuery('#dashboard-area-chart').attr('data-labels');


		var $dataClicks = jQuery('#dashboard-area-chart').attr('data-clicks');
		// var $labels = jQuery('#dashboard-area-chart').attr('data-labels');
		var $max = jQuery('#dashboard-area-chart').attr('data-max');
		// var $data = '1,30,7';

		// var $array = $data.substring(0, str.length - 1);
		var $array       = JSON.parse("[" + $data + "]");
		var $arrayClicks = JSON.parse("[" + $dataClicks + "]");

		var $labelsArray = $labels.split(",");


		if ($max < 10) {
			var newmax = roundNearest(JSON.parse($max), 1);
			newmax     = newmax;
		} else if ($max < 100) {
			var newmax = roundNearest(JSON.parse($max), 10);
			newmax     = newmax + 10;
		} else if ($max < 1000) {
			var newmax = roundNearest(JSON.parse($max), 10);
			newmax     = newmax + 10;
		} else if ($max < 10000) {
			var newmax = roundNearest(JSON.parse($max), 100);
			newmax     = newmax + 100;
		} else {
			var newmax = roundNearest(JSON.parse($max), 1000);
			newmax     = newmax + 1000;
		}


		// var newmax = roundNearest(newmax, 200);
		var steps = newmax / 10;
		steps     = roundNearest(steps, 100);

		var lineChartCanvas = jQuery("#dashboard-area-chart").get(0).getContext("2d");
		var data            = {
			labels: $labelsArray,
			datasets: [{
				label: 'Clicks',
				data: $arrayClicks,
				backgroundColor: 'rgba(63,82,227,.8)',
				borderWidth: 0,
				borderColor: 'transparent',
				pointBorderWidth: 0,
				pointRadius: 3.5,
				pointBackgroundColor: 'transparent',
				pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
			},
				{
					label: 'Views',
					data: $array,
					backgroundColor: 'rgba(254,86,83,.7)',
					borderWidth: 0,
					borderColor: 'transparent',
					pointBorderWidth: 0 ,
					pointRadius: 3.5,
					pointBackgroundColor: 'transparent',
					pointHoverBackgroundColor: 'rgba(254,86,83,.8)',
				}
			]
		};
		var options         = {
			responsive: true,
			maintainAspectRatio: true,
			scales: {
				yAxes: [{
					gridLines: {
						color: '#f2f2f2'
					},
					ticks: {
						beginAtZero: true,
						min: 0,
						max: newmax,
						stepSize: steps,
					}
				}],
				xAxes: [{
					gridLines: {
						color: '#f2f2f2'
					},
					ticks: {
						beginAtZero: true
					}
				}]
			},
			legend: {
				display: true
			},
			elements: {
				point: {
					radius: 2
				}
			},
			layout: {
				padding: {
					left: 0,
					right: 0,
					top: 0,
					bottom: 0
				}
			},
			stepsize: 1
		};
		var lineChart       = new Chart(lineChartCanvas, {
			type: 'line',
			data: data,
			options: options
		});
	}

	if (jQuery('#trafficSourceDoughnutChart').length) {
		var $dataClicks  = jQuery('#trafficSourceDoughnutChart').attr('data-clicks');
		var $arrayClicks = JSON.parse("[" + $dataClicks + "]");

		var $dataBannerID  = jQuery('#trafficSourceDoughnutChart').attr('data-banners');
		var $arrayBannerID = JSON.parse("[" + $dataBannerID + "]");

		var $dataBannerNames  = jQuery('#trafficSourceDoughnutChart').attr('data-banners-names');
		var $dataBannerNames = $dataBannerNames.replace(/'/g, '"');
		var $arrayBannerNames = JSON.parse("[" + $dataBannerNames + "]");

		var ctx     = document.getElementById("trafficSourceDoughnutChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'pie',
			data: {
				datasets: [{
					data: $arrayClicks,
					backgroundColor: [
						'#191d21',
						'#63ed7a',
						'#ffa426',
						'#fc544b',
						'#6777ef',
					],
					label: 'Dataset 1'
				}],
				labels: $arrayBannerNames
			},
			options: {
				responsive: true,
				legend: {
					position: 'bottom'
				}
			}
		});
	}

	if (jQuery('#trafficSourceDoughnutChart2').length) {
		var $dataClicks  = jQuery('#trafficSourceDoughnutChart2').attr('data-clicks');
		var $arrayClicks = JSON.parse("[" + $dataClicks + "]");

		var $dataBannerID  = jQuery('#trafficSourceDoughnutChart2').attr('data-banners');
		var $arrayBannerID = JSON.parse("[" + $dataBannerID + "]");

		var $dataBannerNames  = jQuery('#trafficSourceDoughnutChart2').attr('data-banners-names');
		var $dataBannerNames = $dataBannerNames.replace(/'/g, '"');
		var $arrayBannerNames = JSON.parse("[" + $dataBannerNames + "]");

		var ctx     = document.getElementById("trafficSourceDoughnutChart2").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'pie',
			data: {
				datasets: [{
					data: $arrayClicks,
					backgroundColor: [
						'#191d21',
						'#63ed7a',
						'#ffa426',
						'#fc544b',
						'#6777ef',
					],
					label: 'Dataset 1'
				}],
				labels: $arrayBannerNames
			},
			options: {
				responsive: true,
				legend: {
					position: 'bottom'
				}
			}
		});
	}

});


jQuery(window).load(function() {

	if (typeof window.adblockDetector === 'undefined') {
		showAdblockWarning();
		jQuery('#blockerInfo').modal({
			backdrop: "static"
		})
	} else {
		window.adblockDetector.init(
			{
				debug: false,
				found: function(){
					showAdblockWarning();
					jQuery('#blockerInfo').modal({
						backdrop: "static"
					})
				}
			}
		);
	}

	if (jQuery('#home2').length) {

		// setTimeout(function() {
		// 	var adFoxlyTabInnerWidth = jQuery("#home2").innerWidth() - 30;
		// 	console.log(adFoxlyTabInnerWidth);
		// 	if ( adFoxlyTabInnerWidth > 5 ) {
		// 		jQuery('.select2').css('width', adFoxlyTabInnerWidth);
		//
		// 	}
		// }, 10);

	}

	if (jQuery(".inputtags").length ) {
		jQuery(".inputtags").tagsinput('items');
	}


	jQuery('form input').keydown(function (e) {
		if (e.keyCode == 13) {
			var inputs = jQuery(this).parents("form").eq(0).find(":input");
			if (inputs[inputs.index(this) + 1] != null) {
				inputs[inputs.index(this) + 1].focus();
			}
			e.preventDefault();
			return false;
		}
	});

});

function setCookie(name,value,days) {
	var expires = "";
	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days*24*60*60*1000));
		expires = "; expires=" + date.toUTCString();
	}
	document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

jQuery("[data-set-cookie]").click(function (e) {
	var $cookieValue = jQuery(this).attr('data-set-cookie');
	setCookie('adfoxly_' + $cookieValue, 'true', 1095);
});

jQuery("[data-set-cookie]").click(function (e) {
	var $cookieValue = jQuery(this).attr('data-set-cookie');
	setCookie('adfoxly_number_' + $cookieValue, '1', 1095);
});

jQuery(".data-selection").mouseenter(function (e) {
	jQuery(this).find('.adfoxly-number-on-listing').hide();
	jQuery(this).find('.adfoxly-banner-select').show();
});

jQuery(".data-selection").mouseleave(function (e) {
	if (jQuery(this).find("[name='adfoxly-banner-select-checkbox[]']").prop('checked') === false) {
		jQuery(this).find('.adfoxly-number-on-listing').show();
		jQuery(this).find('.adfoxly-banner-select').hide();
	}
});

jQuery(".custom-control-label-select-all").click(function (e) {
	if (jQuery("[name='adfoxly-banner-select-checkbox-all']").prop('checked') === false) {
		jQuery('.adfoxly-number-on-listing').hide();
		jQuery('.adfoxly-banner-select').show();
		jQuery('.adfoxly-add-new-add-btn').hide();
		jQuery('.adfoxly-add-new-remove-selected-btn').css('display', 'inline-block');
		jQuery('.adfoxly-add-new-enable-selected-btn').css('display', 'inline-block');
		jQuery('.adfoxly-add-new-disable-selected-btn').css('display', 'inline-block');

		jQuery("[name='adfoxly-banner-select-checkbox[]']").each(function() {
			this.checked = true;
			var bannerID = jQuery(this).val();
			var dataHref = jQuery(".adfoxly-add-new-remove-selected-btn").prop('href');
			jQuery(".adfoxly-add-new-remove-selected-btn").prop("href", dataHref + "&remove[]=" + bannerID);
		});
	} else {
		jQuery("[name='adfoxly-banner-select-checkbox[]']").each(function() {
			this.checked = false;
		});
		var originalDataHref = jQuery(".adfoxly-add-new-remove-selected-btn").attr('data-original-href');
		jQuery('.adfoxly-number-on-listing').show();
		jQuery('.adfoxly-banner-select').hide();
		jQuery('.adfoxly-add-new-add-btn').show();
		jQuery(".adfoxly-add-new-remove-selected-btn").prop("href", originalDataHref);
		jQuery('.adfoxly-add-new-remove-selected-btn').hide();
		jQuery('.adfoxly-add-new-enable-selected-btn').hide();
		jQuery('.adfoxly-add-new-disable-selected-btn').hide();
	}
});

jQuery("[name='adfoxly-banner-select-checkbox[]']").change(function (e) {
	atLeastOneIsChecked = null;

	if (this.checked === true) {
		var bannerID = jQuery(this).val();
		var dataHref = jQuery(".adfoxly-add-new-remove-selected-btn").prop('href');
		jQuery(".adfoxly-add-new-remove-selected-btn").prop("href", dataHref + "&remove[]=" + bannerID);
	} else {
		var bannerID = jQuery(this).val();
		var dataHref = jQuery(".adfoxly-add-new-remove-selected-btn").prop('href');
		var dataHref = dataHref.replace("&remove[]=" + bannerID,'');
		jQuery(".adfoxly-add-new-remove-selected-btn").prop("href", dataHref);
	}
	jQuery("[name='adfoxly-banner-select-checkbox[]']").each(function() {
		if (jQuery(this).is(':checked')) {
			atLeastOneIsChecked = true;
			return false;
		}
	});

	if ( atLeastOneIsChecked !== null ) {
		jQuery('.adfoxly-add-new-add-btn').hide();
		jQuery('.adfoxly-add-new-remove-selected-btn').css('display', 'inline-block');
		jQuery('.adfoxly-add-new-enable-selected-btn').css('display', 'inline-block');
		jQuery('.adfoxly-add-new-disable-selected-btn').css('display', 'inline-block');
	} else {
		jQuery('.adfoxly-add-new-add-btn').show();
		jQuery('.adfoxly-add-new-remove-selected-btn').hide();
		jQuery('.adfoxly-add-new-enable-selected-btn').hide();
		jQuery('.adfoxly-add-new-disable-selected-btn').hide();
	}
});

jQuery('.adfoxly-add-new-enable-selected-btn').click(function () {
	jQuery(".adfoxly-ad-status-checkbox").each(function() {
		if (jQuery(this).prop('checked') === false) {
			let bannerID = jQuery(this).attr('data-adfoxly-ad-status-id');
			jQuery('[data-adfoxly-ad-status-id="' + bannerID + '"]').click();
		}
	});
});

jQuery('.adfoxly-add-new-disable-selected-btn').click(function () {
	jQuery(".adfoxly-ad-status-checkbox").each(function() {
		if (jQuery(this).prop('checked') === true) {
			let bannerID = jQuery(this).attr('data-adfoxly-ad-status-id');
			jQuery('[data-adfoxly-ad-status-id="' + bannerID + '"]').click();
		}
	});
});


function showAdblockWarning() {
	jQuery('.adfoxly-notices-wrapper').html('<div class="alert alert-danger alert-has-icon">\n' +
		'                      <div class="alert-icon"><i class="far fa-lightbulb"></i></div>\n' +
		'                      <div class="alert-body">\n' +
		'                        <div class="alert-title">Oh snap! Ad blocking software detected.</div>\n' +
		'                        AdFoxly is that kind of software, which don\'t like with ad blockers. Please disable all ad blockers, because your user experience may be degraded, which may affect the performance of the plugin. Thanks!' +
		'                      </div>\n' +
		'                    </div>');
}


window.onload = function () {

	var notices = document.querySelectorAll(".notice");
	var upgradeNotices = document.querySelectorAll(".update-nag");
	var freemiusNotices = document.querySelectorAll(".fs-notice");

	[].forEach.call(notices, function (notice) {
		notice.setAttribute("style", 'display: block');
		// Get a reference to the element, before we want to insert the element
		var sp2       = document.querySelector(".adfoxly-notices-wrapper");
		// Get a reference to the parent element
		var parentDiv = sp2.parentNode;

		// Insert the new element into the DOM before sp2
		sp2.appendChild(notice);
	});

	[].forEach.call(upgradeNotices, function (notice) {
		// notice.setAttribute("style", 'display: none');
		// Get a reference to the element, before we want to insert the element
		var sp2       = document.querySelector(".adfoxly-notices-wrapper");
		// Get a reference to the parent element
		var parentDiv = sp2.parentNode;

		// Insert the new element into the DOM before sp2
		sp2.appendChild(notice);
	});

	[].forEach.call(freemiusNotices, function (notice) {
		// notice.setAttribute("style", 'display: none');
		// Get a reference to the element, before we want to insert the element
		var sp2       = document.querySelector(".adfoxly-notices-wrapper");
		// Get a reference to the parent element
		var parentDiv = sp2.parentNode;

		// Insert the new element into the DOM before sp2
		sp2.appendChild(notice);
	});

};

jQuery(window).resize(function($) {
	if (jQuery('#home2').length) {
		var $adFoxlyTabInnerWidth = jQuery("#home2").innerWidth() - 30;
		jQuery('.select2').css('width', $adFoxlyTabInnerWidth);
	}
});
