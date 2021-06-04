/*Redirection Button*/
const toReferral = () => {
	let btn = $('[data-casino-id]');
	btn.on('click',function (e) {
		let a = $(this),
				id = a.attr('data-casino-id'),
				casinoID = '/go-to/?id='+id+'';
		if(casinoID){
			window.open(casinoID);
		}
		else return false;
	});
};

export default toReferral;