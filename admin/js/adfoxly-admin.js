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

	$(document).ready(function () {

		if ($("#adfoxly-adzone-place-listing")) {
			var $adfoxly_adzone_select = $('option:selected', this).attr('data-places');

			$("select[name='adfoxly-adzone']").on("change", function () {
				$adfoxly_adzone_select = $('option:selected', this).attr('data-places');

				$("#adfoxly-adzone-place-listing").html($adfoxly_adzone_select);
			});
		}

		$('.file-item input[type=checkbox]').change(function () {
			var c = this.checked ? '#32cf4d' : '#d1d6e6';
			$(this).closest('.file-item').css('border-color', c);
		});


		$('#demo-wizard').wizard().on('actionclicked.fu.wizard', function (e, data) {
			//validation
			if ($('#form' + data.step).length) {
				var parsleyForm = $('#form' + data.step).parsley();
				parsleyForm.validate();
				if (!parsleyForm.isValid())
					return false;
			}
			//last step button
			var $btnNext = $(this).parents('.wizard-wrapper').find('.btn-next');
			if (data.step === 3 && data.direction == 'next') {
				$btnNext.text(' Create My Account')
					.prepend('<i class="fa fa-check-circle"></i>')
					.removeClass('btn-primary').addClass('btn-success');
			}
			else {
				$btnNext.text('Next ')
					.append('<i class="fa fa-arrow-right"></i>')
					.removeClass('btn-success').addClass('btn-primary');
			}
		}).on('finished.fu.wizard', function () {
			$("#form-create-ad").submit();
		});
	});


})(jQuery);


$(function () {

});
