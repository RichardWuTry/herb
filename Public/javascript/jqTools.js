function slideBox(msgBox, duration, fColor, bgColor) {
	var box = $(msgBox);
	if (typeof bgColor !== 'undefined') {
		box.css('background-color', bgColor);
	}
	if (typeof fColor !== 'undefined') {
		box.css('color', fColor);
	}
	duration = typeof duration !== 'undefined' ? duration : 3000;
	box.slideDown(function() {
					setTimeout(function() { box.slideUp(); }, 
					duration)});
}

function showBox(msgBox, fColor, bgColor) {
	var box = $(msgBox);
	if (typeof bgColor !== 'undefined') {
		box.css('background-color', bgColor);
	}
	if (typeof fColor !== 'undefined') {
		box.css('color', fColor);
	}
	box.show();
}