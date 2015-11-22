setTimeout(function() {
	$('.notice').fadeOut();
}, 3000);

$('.header__nav').addClass('header__nav--hidden');
$('.header__nav__toggle').click(function() {
	$('.header__nav').toggleClass('header__nav--hidden');
});

function counterCount() {
	var that = $(this);
	that.parent().find('.counter__number').val(function(index, value) {
		var value = parseInt(value);
		that.hasClass('counter__subtract') ? value-- : value++;
		return value
	});
}

$('.counter__subtract').click(counterCount);
$('.counter__add').click(counterCount);
