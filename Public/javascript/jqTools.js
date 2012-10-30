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

function nl2br(str, is_xhtml) {   
	var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '\<br \/>' : '\<br>';    
	return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
}

function parsePkId(domId) {
	return domId.substr(domId.indexOf('_')+1);
}