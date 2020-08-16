var carousel = $('.main-carousel');
var elementInfoFields = [... $('.carousel-text')[0].childNodes].filter((elem) => elem.nodeName !== '#text');
elementInfoFields.forEach(function (elem, index) {
	elem.style.transitionDelay = `${index / 6}s`;
});

carousel.append(carousel.children('.item').first().clone());
carousel.append('<div class="carousel-container"></div>');
var container = carousel.children('.carousel-container');
var child = carousel.children('.item');
for (var i = 0; i < child.length; i++) {
	container.append(child[i]);
}
var current = 1;
setInterval(function () {

	$(':root').css('--main-from', container.css('top'));
	$(':root').css('--main-to', $(':root').css('--main-to').slice(0, -1) - 100 + '%');
	container.addClass('main-animate');
	elementInfoFields.forEach(function (elem) {elem.style.top = '-.5em'; elem.style.opacity = '0';});
	setTimeout(function () {
		container.removeClass('main-animate');
		container.css('top', $(':root').css('--main-to'));
		current++;
		elementInfoFields.forEach(function (elem) {elem.style.top = '0'; elem.style.opacity = '1';});
		var data = container[0].childNodes[current - 1].dataset;
		elementInfoFields[0].innerText = data.title;
		if (!data.preorder){
			elementInfoFields[1].style.opacity = 0;
			elementInfoFields[2].style.opacity = 0;
		}else{
			var date = elementInfoFields[2].childNodes[1];
			date.lastChild.textContent = ' ' + data.preorder;
		}
		var len = elementInfoFields[3].childNodes.length;
		elementInfoFields[3].childNodes[len-2].childNodes[0].textContent = data.price + '$';
		elementInfoFields[3].childNodes[len-2].childNodes[1].innerText = data.discount;

		if (current === container.children().length)
		{
			container.css('top', '0%');
			$(':root').css('--main-to', '0%');
			current = 1;
		}
	}, 2800);
}, 9000);