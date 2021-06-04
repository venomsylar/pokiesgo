import Cookies from "js-cookie";

/**
 * Add Lib when in necessary
 * @returns {Promise<void>}
 */
export default async function dynamicGoogleRating() {
	let ratingBlock = $(".stars_rating.g_rating");
	if (ratingBlock.length > 0) {
		let ratingInner = $(".stars_rating.g_rating .g_rating_inner"),
				ratingInnerWidth = ratingInner.innerWidth(),
				id = $(".g_rating_block .count_number").attr('data-id'),
				ratingCount = $(".g_rating_block .count_number span");
		ratingBlock.on("click", function () {
			if (!Cookies.get(('added_rating' + id)) && !$(this).data("clicked")) {
				ratingCount.text(parseInt(ratingCount.text()) + 1);
				let currentRating = ratingInner.width() / 20;
				let data = {
					'action': 'add_rating_count',
					'id': id,
					'currentRaiting': currentRating,
					'nonce': ratingObject.nonce,
				};
				$.ajax({
					url: '/wp-admin/admin-ajax.php',
					data: data,
					type: 'POST',
					success: function (data) {
						if (data) {
							ratingCount.text(data);
						}
					}
				});
			}
			Cookies.set('added_rating' + id, 'true', {expires: 1});
			$(this).data("clicked", !0)
		});
		if (!Cookies.get(('added_rating' + id)) && !$(this).data("clicked")) {
			ratingBlock.on("mousemove", function (e) {
				if (!$(this).data("clicked")) {
					let ratingInnerWidth = e.clientX - $(this).offset().left;
					ratingInner.css("width", ratingInnerWidth)
				}
			});
			ratingBlock.on("mouseleave", function (e) {
				ratingInner.css("width", ratingInnerWidth)
			})
		}
	}
}