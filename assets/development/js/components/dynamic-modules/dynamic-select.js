export default async function dynamicSelect(selector = '.js-ui-selector') {
	let selects = $(selector);
	if (selects.length > 0) {
		await Promise.all([
			import ("../select")
		])
	}
}