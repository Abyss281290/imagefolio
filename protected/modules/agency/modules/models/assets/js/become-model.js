var BecomeModel = {
		
		urls: {},
		
	init: function()
	{
		$('input[type=file]').each(function(k,v){
			v = $(v);
			if(v.attr('id')) {
				v.change(BecomeModel.uploadImage);
			}
		});
	},
	
	uploadImage: function()
	{
		var filefield_id = $(this).attr('id');
		var iframe_id = filefield_id+'_iframe';
		$(this)
			.hide()
			//.after('<img src="'+this.urls.base+'/images/loading1.gif" id="file_indicator_'+fieldNum+'" class="indicator">');
			.parent('form')
				.after('<iframe id="'+iframe_id+'" name="'+iframe_id+'" onload="BecomeModel.uploadIframeOnLoad(this, \''+filefield_id+'\')" style="display:none"></iframe>')
				.attr('target', iframe_id)
				.submit();
		$(this).parent('form').find('img.indicator').show();
		$('input[type=file]').attr('disabled', true);
	},
	
	uploadIframeOnLoad: function(iframeObject, fileFieldId)
	{
		var response = $(iframeObject).contents().find('body').html();
		var fileField = $('#'+fileFieldId);
		var fileFieldName = fileField.attr('name');
		var form = fileField.closest('form');
		var img = form.find('img.indicator');
		if(response) {
			if(typeof(response = $.parseJSON(response)) == 'object' && response.loaded) {
				$('#uploaded_files')
					.append($('<div id="uploaded_file_'+fileFieldId+'">')
						.append('<input type="hidden" name="'+fileFieldName+'" value="'+response.uploadedFilename+'">')
						.append('<input type="hidden" name="uploaded_files_coords[]" id="uploaded_files_coords_'+fileFieldId+'">')
				);
				img
					.after(
						$('<div class="load-info"></div>')
							//.append('<a href="#" class="crop" onclick="return Gallery.viewCropTempFile('+fieldNum+', \''+response.uploadedFilename+'\')">[crop]</a>')
							.append('<a href="#" onclick="return BecomeModel.uploadReset(\''+fileFieldId+'\')" class="remove"><img src="'+baseUrl+'/images/notifications/cross.png"></a>')
							.append('<span class="message">'+response.filename+'</span>')
							.append(response.thumb? '<img src="'+response.thumb+'" id="uploaded_file_thumb_'+fileFieldId+'" class="thumb" />' : '')
					)
					.parent('li').addClass('ok');
				this.viewCropTempFile(fileFieldId, response.uploadedFilename);
			} else {
				//var indicator = 'cross.png';
				img.parent('li').addClass('error');
				img.after(
					$('<div class="load-info"></div>')
						.append('<a href="#" onclick="return BecomeModel.uploadReset(\''+fileFieldId+'\')" class="remove"><img src="'+baseUrl+'/images/notifications/cross.png"></a>')
						.append('<span class="message">'+response.error+'</span>')
				);
			}
			// set new indicator
			//img.attr('src', this.urls.base+'/images/notifications/'+indicator);
			img.hide();
			$('input[type=file]').attr('disabled', false);
			//$('#gallery-upload-form input[type=submit]').attr('disabled', false);
		}
		//$(iframeObject).remove();
	},
	
	uploadReset: function(fileFieldId)
	{
		$('#'+fileFieldId)
			.show()
			.val('')
			.closest('form').find('.load-info').remove();
		$('#uploaded_file_'+fileFieldId).remove();
		$('#'+fileFieldId+'_iframe').remove();
		return false;
	},
	
	viewCropTempFile: function(fileFieldId, filename)
	{
		var coords = $('#uploaded_files_coords_'+fileFieldId).val();
		$.colorbox({
			href: this.urls.viewCropTempFile+'?filename='+filename+'&fileFieldId='+fileFieldId+'&'+coords,
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
	
	cropTempFileSave: function(fileFieldId, coords)
	{
		$('#uploaded_files_coords_'+fileFieldId).val($.param(coords));
	},
	
	reloadTempThumb: function(fileFieldId)
	{
		var img = $('#uploaded_file_thumb_'+fileFieldId);
		img.attr('src', img.attr('src')+'?'+Math.random());
	},
	
	cropTempFileOnClose: function()
	{
		
	}
}

$(document).ready(BecomeModel.init);