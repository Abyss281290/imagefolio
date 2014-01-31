$('#create-package-form').live('submit', function(){
	var models = (
		$('.models-tile').length
			// if tile view
			? $('.models-tile input[name^="model["]:checked')
			// if list view
			: $('#grid td input[type=checkbox]:checked')
	).map(function(){return $(this).val();}).get();
	var images = $('div.checkbox #gallery-image-checkbox:checked').map(function(){return $(this).val();}).get();
	$('#create-package-form .loader').show(0);
	$('#create-package-form input[type=submit]').attr('disabled',true);
	$.ajax({
		data: $(this).serialize()+'&'+$.param({
			models: models,
			images: images
		}),
		type: 'post',
		url: $(this).attr('action'),
		cache: false,
		dataType: 'json',
		success: function(data)
		{
			if(data.errors.length) {
				var err = [];
				$.each(data.errors,function(k,v){
					err.push(v);
				});
				alert(err.join("\n"));
			}
			else if(data.redirect) {
				window.location.href = data.redirect;
			}
			$('#create-package-form .loader').hide(0);
			$('#create-package-form input[type=submit]').attr('disabled',false);
		}
	});
	return false;
});

$('#create-package-form #extend').live('change', function(){
	var row = $('#create-package-form .row:first');
	$(this).val()? row.hide(400) : row.show(400);
});