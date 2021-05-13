	function ajaxCall() {
		var data = {"zipcode":$("#zipcode").val()}
                var jsonDataString = JSON.stringify(data);
                $.ajax({
		    "method":"POST",
                    "url": "https://hayesbm3.451.csi.miamioh.edu/cse451-hayesbm3-web/laravel1-project/public/api/weather/" + $("#zipcode").val()})
                .done(function (response) {
			var data = JSON.parse(response.message);
			$('#display').html('<p style=\'display: inline\'>The temperature in </p> <p id=\'city\' style=\'display: inline\'></p> <p style=\'display: inline\'> right now is </p> <p id=\'temp\' style=\'display: inline\'></p ><p id=\'cache\'></p>');
			$('#temp').text(data.temp);
			$('#city').text(data.city);
			$('#cache').text(data.cache);
                })
                .fail(function(error) {
                    	console.log(error);
			$('#display').html('Please enter a valid zipcode');
                });
		
	}

	 $(document).ready(function () {
		ajaxCall();
		setInterval(ajaxCall, 10000);
	 });
