setTimeout(function() {
	$('.notice').fadeOut();
}, 3000);

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
