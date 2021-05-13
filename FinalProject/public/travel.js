function getMap(city) {
	console.log("reenis");
	window.location.replace(window.location.href + "/map/" + city);
}

$(document).ready(function () {
	$.ajax( {
		url: 'api/travel',
		success: (response) => {
			console.log(response);
			if (response.status == 'OK') {
				if (response.cityNames.length == 0)
					$("#projects").append("<p>" + 'You have no cities in this list!' + "</p>");
                        	for (i=0,l=response.cityNames.length;i<l;i++) {
                                	$("#projects").append("<button type='button' class='list-group-item list-group-item-action' onclick='getMap(\"" + response.cityNames[i] + "\")'>" + response.cityNames[i] + "</button>");
                        	}
			} else {
				$('#status').text('Error retrieving data');
			}

		},
		error: (error) => {
			console.log("Fail",error);
			$("#msg").html("Error retrieving");
		}
	});


        });
