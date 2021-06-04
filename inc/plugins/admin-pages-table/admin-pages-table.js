$ = jQuery;

function updateURL(props) {
	if (history.pushState) {
		let oldUrl = window.location.protocol + '//' + window.location.host + window.location.pathname + window.location.search + props;
		window.history.pushState({path: oldUrl}, '', oldUrl);
		window.location.reload();
	}
}

function uploadImageFromUrl() {
	let form = $('.add_image_from_url_popup');

	function hideSpinner(button) {
		button.prev('.spinner').removeClass('is-active');
	}

	function validationError(button, response) {
		form.find('.warning').remove();
		form.find('.flex_wrap').before('<p class="error">Error: Not valid url. <br><span>Supported formats: JPEG (JPG, JPE), GIF, PNG</span></p>');
		hideSpinner(button);
		console.error(`Error ${response.error_code}: ${response.error}`);
	}
	function validationWarning(button, response) {
		form.find('.error').remove();
		form.find('.flex_wrap').before('<p class="warning">Warning: Image with current name has already exist!</p>');
		hideSpinner(button);
		console.error(`Error ${response.error_code}: ${response.error}`);
	}

	function validationSucceed(activeButton, uploadButton, data) {
		activeButton.after(data);
		hideSpinner(uploadButton);
		activeButton.parent().find('button').remove();
		form.remove();
		$('body').removeClass('pp_shadow modal-open');
		deleteThumbnailFromPage();
	}

	form.on('submit', function (e) {
		e.preventDefault();
		let element = $(this).find('.upload_image_button'),
				activeButton = $('.add_img_from_url.active'),
				uploadImageButton = $('.upload_image_button'),
				data = {
					'action': 'upload_image_from_url',
					'img_source_value': element.prev().prev().val(),
					'el_id': element.attr('data-id'),
					'error_code' : false,
				};
		uploadImageButton.prev('.spinner').addClass('is-active');
		$.ajax({
			url: '/wp-admin/admin-ajax.php',
			data: data,
			type: 'POST',
			success: function (data) {
				let response;
				try {
					response = JSON.parse(data);
				} catch (e) {
					response = data;
				}
				console.log(data);
				switch (response.error_code) {
					case 400:
						!form.find('p.error').length > 0 ? validationError(uploadImageButton, response) : hideSpinner(uploadImageButton);
						break;
					case 409:
						!form.find('p.warning').length > 0 ? validationWarning(uploadImageButton, response) : hideSpinner(uploadImageButton);
						break;
					default :
						validationSucceed(activeButton, uploadImageButton, response);
						break;
				}
			}
		});
	});
}

function closeUploadImagePopUp() {
	let button = $('.add_img_from_url.active');
	$('.add_image_from_url_popup .cross').on('click', function () {
		button.data('clicked', false);
		button.removeClass('active');
		$('.add_image_from_url_popup').remove();
		$('body').toggleClass('pp_shadow modal-open');
	});
}

function addImagePopUpGenerate() {
	$('.add_img_from_url').on('click', function (e) {
		e.preventDefault();
		$('body').toggleClass('pp_shadow modal-open');
		let button = $('.add_img_from_url');
		if (!$(this).data('clicked')) {
			let clickedButton = $(this),
					data = {
						'action': 'add_image_from_url',
						'add_image_from_url_id': clickedButton.attr('data-id')
					};
			button.removeClass('active');
			button.data('clicked', false);
			$('.add_img_from_url:not(.active)').next('.add_image_from_url_popup').remove();
			clickedButton.addClass('active');
			clickedButton.data('clicked', true);
			$.ajax({
				url: '/wp-admin/admin-ajax.php',
				data: data,
				type: 'POST',
				success: function (data) {
					if (data) {
						clickedButton.after(data);
						clickedButton.next('.add_image_from_url_popup').find('input').focus();
						uploadImageFromUrl();
						closeUploadImagePopUp();
						deleteThumbnailFromPage();
					}
				}
			});
		}
	});
}

function addImageToPage() {
	$('body').on('click', '.aw_upload_image_button', function (e) {
		e.preventDefault();
		$('.add_img_from_url').data('clicked', false).removeClass('active');
		$('.add_image_from_url_popup').remove();
		let button = $(this),
				aw_uploader = wp.media({
					title: 'Add Image to page',
					library: {
						uploadedTo: wp.media.view.settings.post.id,
						type: 'image'
					},
					button: {
						text: 'Add to page'
					},
					multiple: false
				}).on('select', function () {
					let attachment = aw_uploader.state().get('selection').first().toJSON();
					let data = {
						'action': 'add_image_from_media',
						'media_upload_id': attachment.id,
						'page_for_upload_id': button.attr('data-id'),
					};
					$.ajax({
						url: '/wp-admin/admin-ajax.php',
						data: data,
						type: 'POST',
						success: function (data) {
							button.after(data);
							button.prev().remove();
							button.remove();
							deleteThumbnailFromPage();
						}

					});
				}).open();
	});
}

function deleteThumbnailFromPage() {
	$('.delete_thumb').on('click', function () {
		let
				data = {
					'action': 'delete_image_from_post',
					'page_id': $(this).parent().attr('data-id')
				}, deleteButton = $(this), button = $('.add_img_from_url');
		button.next('.add_image_from_url_popup').remove();
		button.removeClass('active');
		button.data('clicked', false);
		$.ajax({
			url: '/wp-admin/admin-ajax.php',
			data: data,
			type: 'POST',
			success: function (data) {
				$('.add_img_from_url').prev('.spinner').removeClass('is-active');
				deleteButton.parent().before(data);
				deleteButton.parent().remove();
				addImagePopUpGenerate();
			}
		});
	});
}

const hideCasinoInTable = () => {
	$('.hide_casino_button').on('click', function () {
		const checkbox = $(this);
		const data = {
					'action': 'hide_casino_in_table',
					'casino-id': checkbox.attr('name'),
					'checkbox-state': checkbox.is(':checked'),
				}
		$.ajax({
			url: '/wp-admin/admin-ajax.php',
			data: data,
			type: 'POST'
		});
	});
}


$(document).ready(function () {
	deleteThumbnailFromPage();
	addImagePopUpGenerate();
	addImageToPage();
	hideCasinoInTable();
});







