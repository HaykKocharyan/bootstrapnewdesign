$('.btn-category').click(function (event) {
	$('.btn-category-selected').removeClass('btn-category-selected');
	$(event.target).addClass('btn-category-selected');
});


$('.cart-button').click(function (event){
	window.location.href = "cart.html";
	event.stopPropagation();
	event.preventDefault();
})
$('.checkout-button').click(function (event){
	window.location.href = "checkout.html";
	event.stopPropagation();
	event.preventDefault();
})

$(document).ready(function(){

  /*Owl Carousels*/
  $("#paymant-carousel").owlCarousel({
  	items: 4,
  	margin: 16,
  	dots: false,
  	nav: true,
  	navContainer: '#paymant-carousel',
  	navText: ["<i class='fas fa-angle-left'></i>","<i class='fas fa-angle-right'></i>"],
  	navClass: ['btn btn-dark owl-prev', 'btn btn-dark owl-next'],
    responsive : {
      0 : {
        items: 1,
        margin: 8,
      },
      768 : {
        items: 2,
      },
      992 : {
        items: 3,
      },
      1200 : {
        items: 4,
        margin: 16,
      }
    }
  });
  /*End Owl Carousels*/
});