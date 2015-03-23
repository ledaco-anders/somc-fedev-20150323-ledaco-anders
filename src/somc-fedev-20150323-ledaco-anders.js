(function($) {
	$(document).ready(function () {
		$('.sortable').tablesorter({
			sortList: [[0,0]] 
		});
		
		$('.title').click(function() {
			var table = $(this).parent().next().find('table').first();
			
			table.toggle();
		});
	});
})(jQuery);