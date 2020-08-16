$('.btn-category').click(function (event) {
	$('.btn-category-selected').removeClass('btn-category-selected');
	$(event.target).addClass('btn-category-selected');
});


$('.cart-button').click(function (event){
	window.location.href = "cart.html";
	event.stopPropagation();
	event.preventDefault();
})