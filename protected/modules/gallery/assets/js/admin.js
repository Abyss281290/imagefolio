var Gallery = {
		gallery_id: 0,
		gallerycode: 0,
		urls: {
			base: '',
			remove: '',
			viewCrop: '',
			viewCropTempFile: ''
		},

	init: function()
	{
		// preload icons
		(new Image()).src = this.urls.base+'/images/loading1.gif';
		(new Image()).src = this.urls.base+'/images/notifications/tick.png';
		(new Image()).src = this.urls.base+'/images/notifications/cross.png';
	},
	
	remove: function(buttonObject, imageId)
	{
		buttonObject = $(buttonObject).parent();
		this._showButtons(buttonObject);
		this._buttonLoading(buttonObject);
		this._addClassToItemObject(buttonObject, 'deleting');
		$.ajax({
			data: {
				id: imageId
			},
			url: Gallery.urls.remove,
			cache: false,
			success: function(html)
			{
				Gallery._removeItemObject(buttonObject);
				Gallery.addUploadField();
			}
		});
		return false;
	},
	
	setMain: function(buttonObject, imageId)
	{
		buttonObject = $(buttonObject).parent();
		this._showButtons(buttonObject);
		this._buttonLoading(buttonObject);
		$.ajax({
			data: {
				id: imageId
			},
				url: Gallery.urls.setMainImage,
			cache: false,
			success: function(html)
			{
				$('.gallery .item.main').removeClass('main');
				Gallery._showButtons(buttonObject, 0);
				Gallery._buttonLoading(buttonObject, 0);
				Gallery._getItemObject(buttonObject).addClass('main');
			}
		})
		return false;
	},
	
	publishImage: function(buttonObject, imageId)
	{
		buttonObject = $(buttonObject).parent();
		this._showButtons(buttonObject);
		this._buttonLoading(buttonObject);
		$.ajax({
			data: {
				id: imageId
			},
				url: Gallery.urls.publishImage,
			cache: false,
			success: function(html)
			{
				Gallery._showButtons(buttonObject, 0);
				Gallery._buttonLoading(buttonObject, 0);
				Gallery._getItemObject(buttonObject).toggleClass('public');
			}
		})
		return false;
	},
	
	onStartUpload: function()
	{
		//var form = $("#gallery-upload-form");
		// disable submit button
		$('.admin-image-gallery fieldset.upload input.submit').attr('disabled', true);
		$('.admin-image-gallery fieldset.upload').addClass('loading');
		//form.submit();
		return true;
	},
	
	viewCrop: function(buttonObject, imageId)
	{
		$.colorbox({
			href: this.urls.viewCrop+'?id='+imageId,
			iframe: true,
			width: 200,
			height: 200
		});
		return false;
	},
	
	reloadImage: function(imageId)
	{
		var rand = Math.random()*(0 - 99);
		var img = $('#gallery_image_'+imageId+' .image');
		img.attr('href', img.attr('href')+'?'+rand);
		img = img.find('img');
		img.attr('src', img.attr('src')+'?'+rand);
		itemObject = this._getItemObject(img);
		this._class(itemObject, 'loading');
		img.load(function(){
			setTimeout(function(){ Gallery._class(itemObject, 'loading', false); }, 2000);
		});
	},
	
	fileFieldOnChange: function(fieldNum)
	{
		$('#file_'+fieldNum)
			.hide()
			.after('<img src="'+this.urls.base+'/images/loading1.gif" id="file_indicator_'+fieldNum+'" class="indicator">')
			.parent('form')
				.after('<iframe style="display: none" id="load_temp_'+fieldNum+'" name="load_temp_'+fieldNum+'" onload="Gallery.loadTempIframeOnLoad('+fieldNum+')"></iframe>')
				.attr('target', 'load_temp_'+fieldNum)
				.submit();
		$('#files input[type=file]').attr('disabled', true);
		$('#gallery-upload-form input[type=submit]').attr('disabled', true);
	},
	
	loadTempIframeOnLoad: function(fieldNum)
	{
		var iframe = $('#load_temp_'+fieldNum);
		var response = iframe.contents().find('body').html();
		var img = $('#file_indicator_'+fieldNum);
		if(response) {
			if(typeof(response = $.parseJSON(response)) == 'object' && response.loaded) {
				$('#uploaded_files')
					.append($('<div id="uploaded_file_'+fieldNum+'">')
						.append('<input type="hidden" name="uploaded_files[]" value="'+response.uploadedFilename+'">')
						.append('<input type="hidden" name="uploaded_files_coords[]" id="uploaded_files_coords_'+fieldNum+'">')
				);
				//var indicator = 'tick.png';
				img
					.after(response.thumb? '<img src="'+response.thumb+'" id="uploaded_file_thumb_'+fieldNum+'" class="thumb" />' : '')
					//.after('<a href="#" class="crop" onclick="return Gallery.viewCropTempFile('+fieldNum+', \''+response.uploadedFilename+'\')">[crop]</a>')
					.after('<span class="message">'+response.filename+'</span>')
					.after('<a href="#" onclick="return Gallery.removeTemp('+fieldNum+')" class="remove"><img src="'+this.urls.base+'/images/notifications/cross.png"></a>')
					.parent('li').addClass('ok');
				f = function(){Gallery.viewCropTempFile(fieldNum, response.uploadedFilename)}
				if($.browser.msie)
					setTimeout(f, 100);
				else
					f();
			} else {
				//var indicator = 'cross.png';
				img.parent('li').addClass('error');
				img.after('<span class="message">'+response.error+'</span>');
			}
			// set new indicator
			//img.attr('src', this.urls.base+'/images/notifications/'+indicator);
			img.hide();
			$('#files input[type=file]').attr('disabled', false);
			$('#gallery-upload-form input[type=submit]').attr('disabled', false);
		}
	},
	
	viewCropTempFile: function(fieldNum, filename)
	{
		var coords = $('#uploaded_files_coords_'+fieldNum).val();
		$.colorbox({
			href: this.urls.viewCropTempFile+'?gallerycode='+Gallery.gallerycode+'&filename='+filename+'&fieldNum='+fieldNum+'&'+coords,
			iframe: true,
			width: 200,
			height: 200,
			overlayClose: false,
			escKey: false,
			onLoad: function()
			{
				$('#cboxClose').remove();
			},
			onClosed: this.cropTempFileOnClose
		});
		return false;
	},
	
	cropTempFileSave: function(fieldNum, coords)
	{
		$('#uploaded_files_coords_'+fieldNum).val($.param(coords));
	},
	
	cropTempFileOnClose: function()
	{
		//$('#files input[type=file]').attr('disabled', false);
	},
	
	removeTemp: function(fieldNum)
	{
		$('#file_'+fieldNum).closest('li').remove();
		$('#uploaded_file_'+fieldNum).remove();
		this.addUploadField();
		return false;
	},
	
	reloadTempThumb: function(fieldNum)
	{
		var img = $('#uploaded_file_thumb_'+fieldNum);
		img.attr('src', img.attr('src')+'?'+Math.random());
	},
	
	addUploadField: function()
	{
		var ul = $('#files');
		var fieldNum = ul.find('li').length;
		var row = '<li>';
		row += '<form method="post" action="'+this.urls.uploadTemp+'" enctype="multipart/form-data">';
		row += '<input id="file_'+fieldNum+'" type="file" name="file" onchange="Gallery.fileFieldOnChange('+fieldNum+')">';
		row += '</form>';
		row += '</li>';
		ul.append(row);
		// show files list if hidden
		$('#upload_container').show(500);
		// hide error message if exists
		$('#upload-limit-error').hide(500);
	},
	
	/*************************************************/
	
	_buttonLoading: function(buttonObject, loading)
	{
		if(loading || typeof loading == 'undefined')
			$(buttonObject).addClass('loading');
		else
			$(buttonObject).removeClass('loading');
	},
	
	_getItemObject: function(anyChildObject)
	{
		return $(anyChildObject).hasClass('.item')
			? anyChildObject
			: $(anyChildObject).closest('.item');
	},
	
	_addClassToItemObject: function(anyChildObject, className, boolAdd)
	{
		var itemObject;
		if(typeof anyChildObject == 'object') {
			itemObject = this._getItemObject(anyChildObject);
		}
		this._class(itemObject, className, boolAdd);
	},
	
	_removeItemObject: function(anyChildObject)
	{
		var itemObject = this._getItemObject(anyChildObject).parent();
		itemObject.fadeOut(150, function(){$(this).remove()})
	},
	
	_showButtons: function(anyChildObject, boolShow)
	{
		var itemObject = this._getItemObject(anyChildObject).parent();
		this._class(itemObject.find('.img_options'), 'active', boolShow);
	},
	
	_class: function(obj, className, bool)
	{
		obj.toggleClass(className, bool || typeof bool == 'undefined');
	}
}