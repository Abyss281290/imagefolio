var Gallery = {
	
		urls: {
			remove: ''
		},
	
	remove: function(imageObject, imageId)
	{
		jQuery.ajax({
			data: {
				id: imageId
			},
			url: Gallery.urls.remove,
			cache: false,
			success: function(html)
			{
				alert('removed');
			}
		})
	}
	
}