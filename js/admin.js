jQuery(document).ready(function($) {

	console.log("Admin scripts loaded");
	$('.widget-control-save').on('click', function() {

		console.log("Widget save clicked!");
		//Check it's the calendar widget being saved
        if ($( this ).attr( 'id' ).indexOf('widget-austeve_openhours_widget-') === 0) {
        	console.log("Open Hours widget save!");
        	var hoursForm = $( this ).closest("form");

			//Clear previous validation 
        	console.log("Clearing old validation");
			hoursForm.find('input.start').each(function(){
    			$(this).css("border", "1px solid #ddd");
        	});
			hoursForm.find('input.end').each(function(){
        		$(this).css("border", "1px solid #ddd");
        	});
    		hoursForm.find('p.hour-warning').css("color", "#444");
    		hoursForm.find('p.hour-warning').css("font-weight", "normal");

        	//Do validation on new form values
        	//var regexMatch = new RegExp(/^\d{4}$/);
        	var regexMatch = new RegExp(/^([01][0-9]|2[0-3])[0-5][0-9]$/);

        	console.log("Doing validation");
        	var proceed = true;
        	hoursForm.find('input.start').each(function(){
        		if (!regexMatch.test($(this).val())) {
        			$(this).css("border", "1px solid red");
        			proceed = false;
        		}
        	});
        	hoursForm.find('input.end').each(function(){
        		if (!regexMatch.test($(this).val())) {
        			$(this).css("border", "1px solid red");
        			proceed = false;
        		}
        	});
        	console.log("Proceed? " + proceed);
        	if (proceed === false) {
        		hoursForm.find('p.hour-warning').css("color", "red");
        		hoursForm.find('p.hour-warning').css("font-weight", "bold");
        		return false;
        	}

        	
        	//Create the hours array to save all of the values into (as a JSON string)
			var monday = new Object();
			monday.open = hoursForm.find("input.austeve-oh.monday.open").attr("checked") === "checked";
			monday.from = hoursForm.find("input.austeve-oh.monday.start").val();
			monday.to = hoursForm.find("input.austeve-oh.monday.end").val();

			var tuesday = new Object();
			tuesday.open = hoursForm.find("input.austeve-oh.tuesday.open").attr("checked") === "checked";
			tuesday.from = hoursForm.find("input.austeve-oh.tuesday.start").val();
			tuesday.to = hoursForm.find("input.austeve-oh.tuesday.end").val();

			var wednesday = new Object();
			wednesday.open = hoursForm.find("input.austeve-oh.wednesday.open").attr("checked") === "checked";
			wednesday.from = hoursForm.find("input.austeve-oh.wednesday.start").val();
			wednesday.to = hoursForm.find("input.austeve-oh.wednesday.end").val();

			var thursday = new Object();
			thursday.open = hoursForm.find("input.austeve-oh.thursday.open").attr("checked") === "checked";
			thursday.from = hoursForm.find("input.austeve-oh.thursday.start").val();
			thursday.to = hoursForm.find("input.austeve-oh.thursday.end").val();

			var friday = new Object();
			friday.open = hoursForm.find("input.austeve-oh.friday.open").attr("checked") === "checked";
			friday.from = hoursForm.find("input.austeve-oh.friday.start").val();
			friday.to = hoursForm.find("input.austeve-oh.friday.end").val();

			var saturday = new Object();
			saturday.open = hoursForm.find("input.austeve-oh.saturday.open").attr("checked") === "checked";
			saturday.from = hoursForm.find("input.austeve-oh.saturday.start").val();
			saturday.to = hoursForm.find("input.austeve-oh.saturday.end").val();

			var sunday = new Object();
			sunday.open = hoursForm.find("input.austeve-oh.sunday.open").attr("checked") === "checked";
			sunday.from = hoursForm.find("input.austeve-oh.sunday.start").val();
			sunday.to = hoursForm.find("input.austeve-oh.sunday.end").val();

			var hours = new Object();
			hours.monday = monday;
			hours.tuesday = tuesday;
			hours.wednesday = wednesday;
			hours.thursday = thursday;
			hours.friday = friday;
			hours.saturday = saturday;
			hours.sunday = sunday;

			console.log(JSON.stringify(hours));

			//Set the value in the hidden text field
			hoursForm.find('input[data-name="json-hours"]').val(JSON.stringify(hours));

			return true;
        }
	});
});

