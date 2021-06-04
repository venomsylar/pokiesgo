export default async function dynamicSlider(slidersArray) {
	if (slidersArray.length > 0) {
		await Promise.all([
			import ("owl.carousel/dist/assets/owl.carousel.min.css"),
			import ("owl.carousel/dist/owl.carousel.min.js"),
		]).then(() => {
			//Sliders
			slidersArray.map(slider => {
				jQuery(`${slider.selector} .owl-carousel`).owlCarousel(slider.options);
			});
		})
	}
}