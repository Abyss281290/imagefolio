var AgencyMenu = {
		
		listSize: 15,
		listWidth: 150,
		lists: [],
		currentDestinationList: null,
		firstList: null,
		secondList: null,
	
	init: function()
	{
		$('#firstSelect').find('option').dblclick(AgencyMenu.add);
		
		$('#agency-menus-submenus select').live('focus', AgencyMenu.destinationListOnFocus).hide();
		
		this.currentDestinationList = $('#secondSelect').focus(AgencyMenu.destinationListOnFocus).focus();
		//$('#secondSelect').find('option').live('click', AgencyMenu.secondListOnChange);
		$('#secondSelect').live('change', AgencyMenu.secondListOnChange);
		//$('#secondSelect :selected').click();
		$('#secondSelect').change();
		
		AgencyMenu.placeFields();
		AgencyMenu.updateLists();
	},
	
	/*add: function()
	{
		fromSelector = $('#firstSelect');
		destinationSelector = AgencyMenu.currentDestinationList;
		var selectedOptions = $(fromSelector).find('option:selected').clone();
		var destSelectedOption = $(destinationSelector).find('option:selected:last');
		if(destSelectedOption.length) {
			selectedOptions.insertAfter($(destinationSelector).find('option:selected:last'));
		} else {
			selectedOptions.appendTo($(destinationSelector));
		}
		AgencyMenu.placeFields(destinationSelector);
		AgencyMenu.updateLists();
	},*/
	add: function()
	{
		fromSelector = $('#firstSelect');
		destinationSelector = AgencyMenu.currentDestinationList;
		var selectedOptions = $(fromSelector).find('option:selected').clone();
		var destSelectedOption = $(destinationSelector).find('option:selected:last');
		selectedOptions.appendTo($(destinationSelector));
		
		if(destinationSelector.attr('id') == 'secondSelect') {
			$(destinationSelector).find('option').each(function(k,v){
				AgencyMenu.addThirdList(k);
			});
		}
		
		AgencyMenu.placeFields();
		AgencyMenu.updateLists();
	},
	
	remove: function()
	{
		fromSelector = this.currentDestinationList;
		var selectedOption = $(fromSelector).find('option:selected:last');
		
		this.move(1);
		
		if(selectedOption.next().length)
			selectedOption.next().attr('selected', true).change();
		else
			selectedOption.prev().attr('selected', true).change();
		
		if(fromSelector.attr('id') == 'secondSelect') {
			this.getThirdList(selectedOption).remove();
		}
		selectedOption.remove();
		
		// renumerate submenus lists
		$('#agency-menus-submenus select').each(function(k,v){
			$(v).attr('rel', 'menu2['+k+']');
		});
		
		this.placeFields();
		this.updateLists();
	},
	
	move: function(direction)
	{
		listSelector = this.currentDestinationList;
		var selectedOption = $(listSelector).find(':selected:last');
		
		if($(listSelector).attr('id') == 'secondSelect') {
			var indexFrom = selectedOption.index();
			var indexDest = selectedOption.index() + direction;
			var list1 = this.addThirdList(indexFrom);
			var list2 = this.addThirdList(indexDest);
			var opts1 = list1.find('option').clone();
			var opts2 = list2.find('option').clone();
			list1.find('option').remove();
			list1.append(opts2);
			list2.find('option').remove();
			list2.append(opts1);
		}
		
		if(direction > 0)
			selectedOption.insertAfter(selectedOption.next());
		else
			selectedOption.insertBefore(selectedOption.prev());
		
		listSelector.change();
		
		this.placeFields();
	},
	
	placeFields: function(listSelector)
	{
		var form = $('#secondSelect').closest('form');
		var container = $('<div></div>').attr('id', 'menus-fields');
		$('#secondSelect, #agency-menus-submenus select').each(function(k,v){
			var name = $(v).attr('rel');
			//form.find('input[rel="field-'+name+'"]').remove();
			$(v).find('option').each(function(i,v){
				var val = $(v).val();
				container.append(('<input type="hidden" rel="field-'+name+'" name="'+name+'['+i+']" value="'+val+'" />'));
			});
		});
		$('#menus-fields').remove();
		form.append(container);
	},
	
	updateLists: function()
	{
		var listSizes = [];
		//var listWidths = [];
		var lists = $('#agency-menus select');
		lists.each(function(){
			listSizes.push($(this).find('option').length);
			//listWidths.push($(this).width()+50);
		});
		lists.attr('size', Math.max(Math.max.apply(Math, listSizes), this.listSize));
		//lists.css('width', Math.max.apply(Math, listWidths));
	},
	
	getThirdList: function(secondListSelectedOption)
	{
		var index = typeof secondListSelectedOption == 'number'
			? secondListSelectedOption
			: $(secondListSelectedOption).index();
		return $('#agency-menus-submenus select[rel="menu2['+index+']"]:last');
	},
	
	addThirdList: function(secondListSelectedOption)
	{
		var index = typeof secondListSelectedOption == 'number'
			? secondListSelectedOption
			: $(secondListSelectedOption).index();
		var maxIndex = $('#secondSelect option').length-1;
		index = index < 0? 0 : (index > maxIndex? maxIndex : index);
		var c = $('#agency-menus-submenus');
		var rel = 'menu2['+index+']';
		var list = c.find('select[rel="'+rel+'"]');
		if(!list.length) {
			list = $('<select rel="'+rel+'">').hide();
			c.append(list);
			AgencyMenu.updateLists();
		}
		return list;
	},
	
	destinationListOnFocus: function()
	{
		if(AgencyMenu.currentDestinationList) {
			AgencyMenu.currentDestinationList.parent().removeClass('active');
		}
		
		if(AgencyMenu.currentDestinationList) {
			var table = $(this).closest('table');
			var tdFrom = table.find('tr').eq(1).find('td').eq(AgencyMenu.currentDestinationList.parent().index());
			var tdDest = table.find('tr').eq(1).find('td').eq($(this).parent().index());
			var btns = tdFrom.find('div:first');
			tdDest.append(btns);
		}
		
		AgencyMenu.currentDestinationList = $(this);
		$(this).parent().addClass('active');
	},
	
	secondListOnChange: function()
	{
		var option = $(this).find('option:selected:last');
		AgencyMenu.addThirdList(option);
		var c = $('#agency-menus-submenus');
		var rel = 'menu2['+option.index()+']';
		//alert([option.index(), c.find('select').length]);
		c.find('select').hide();
		c.find('select[rel="'+rel+'"]').show();
	}
}

$(document).ready(AgencyMenu.init);