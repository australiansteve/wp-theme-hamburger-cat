jQuery(document).ready(function($) {

	$(".hc-content").each(function(rowIndex){

		var layouts = [];

		switch (rowIndex) {
			case 0:
				layouts = (LAYOUTVARS.content1 === undefined) ? ["12"] : LAYOUTVARS.content1.split(";");
				break;
			case 1:
				layouts = (LAYOUTVARS.content2 === undefined) ? ["12"] : LAYOUTVARS.content2.split(";");
				break;
			case 2:
				layouts = (LAYOUTVARS.content3 === undefined) ? ["12"] : LAYOUTVARS.content3.split(";");
				break;
			case 3:
				layouts = (LAYOUTVARS.content4 === undefined) ? ["12"] : LAYOUTVARS.content4.split(";");
				break;
			case 4:
				layouts = (LAYOUTVARS.content5 === undefined) ? ["12"] : LAYOUTVARS.content5.split(";");
				break;
			case 5:
				layouts = (LAYOUTVARS.content6 === undefined) ? ["12"] : LAYOUTVARS.content6.split(";");
				break;
			case 6:
				layouts = (LAYOUTVARS.content7 === undefined) ? ["12"] : LAYOUTVARS.content7.split(";");
				break;
			case 7:
				layouts = (LAYOUTVARS.content8 === undefined) ? ["12"] : LAYOUTVARS.content8.split(";");
				break;
			case 8:
				layouts = (LAYOUTVARS.content9 === undefined) ? ["12"] : LAYOUTVARS.content9.split(";");
				break;
			default:
				break;
		}

		var small = (layouts[0] === undefined) ? ['12'] : layouts[0].split(",");
		var medium = (layouts[1] === undefined) ? small : layouts[1].split(",");
		var large = (layouts[2] === undefined) ? medium : layouts[2].split(",");

		$(this).find(".columns").each(function(widgetIndex){

			var smallClass = ( small[widgetIndex] === undefined ) ? small[0] : small[widgetIndex];			
			var mediumClass = ( medium[widgetIndex] === undefined ) ? medium[0] : medium[widgetIndex];			
			var largeClass = ( large[widgetIndex] === undefined ) ? large[0] : large[widgetIndex];

			$(this).addClass("small-" + smallClass.trim() + " medium-" + mediumClass.trim() + " large-" + largeClass.trim());
		});
	});

	setTimeout(function() {
		var spaceFooter = _.debounce(footerSpacing, 500);
		$(window).resize(spaceFooter);
		spaceFooter();
	}, 500);
});


function footerSpacing()
{
	var marginNeeded = jQuery(window).height() - jQuery("#page").outerHeight() - jQuery("footer").outerHeight();

	if (marginNeeded > 0)
	{
		jQuery("#spacer").css("margin-top", marginNeeded);
	}
}