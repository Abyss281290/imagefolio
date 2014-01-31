var GeoWidget = {
	
	updateDropDownList: function(objId, data)
	{
		var options = '';
		for (var i in data) {
			options += '<option value="' + i + '">' + data[i] + '</option>';
		}
		$("select#"+objId).html(options);
	},
	
	afterAjax: function(r, objId)
	{
		GeoWidget.updateDropDownList(objId, eval("("+r+")"));
		$('#'+objId).css({'visibility':'visible', 'opacity':'0'}).animate({'opacity':1});
		$('#'+objId+'_loader').remove();
	}
	
}