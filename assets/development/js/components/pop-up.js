import '@fancyapps/fancybox/dist/jquery.fancybox.css';
import '@fancyapps/fancybox/dist/jquery.fancybox.min';

const popUps = () => {
	$('.taxonomy_list_read_more').fancybox({
		afterClose: function(instance, slide) {
			$(slide.src).prop("style", "");
		}
	});

	$('.fancyBoxVideo').fancybox({
		youtube : {
			controls : true,
			showinfo : true
		}
	});
};

export default popUps;