let state = '';
let country = '';
let lat = '';
let lon = '';
$(document).ready(function () {

        $.ajax( {
                url: 'https://hayesbm3.451.csi.miamioh.edu/cse451-hayesbm3-web/FinalProject/public/api/travel/map/' + city,
                success: (response) => {
                        console.log(response);
                        if (response.status == 'OK') {
                                console.log(response.body.cities[0]['LAT']);
                                lat=response.body.cities[0]['LAT'];
                                lon=response.body.cities[0]['LON'];
                                var map = L.map('mapid').setView([lat, lon], 16);

                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                                }).addTo(map);

                                L.marker([lat, lon]).addTo(map)
                                        .bindPopup(response.body.cities[0]["CityName"] + ", " + response.body.cities[0]["Country"] + "<br>" + response.temp.temp + "°F " + response.temp.cache)
                                        .openPopup();
                                delta=.001

                                var popup=L.popup();
                                $('#wiki').append(response.wiki['query']['pages'][0]['extract']);
				
				$.ajax({
					url: 'https://campbest.451.csi.miamioh.edu/globalCityList/public/api/v1/city/' + city,
					success: (response) => {
						console.log(response);
						if (response.status.toLowerCase() == 'ok') {
							state = response['cities'][0]['State'];
							country = response['cities'][0]['Country'];
							$('#info').html("<p>City Name: " + response['cities'][0]['CityName'] + ", State: " + response['cities'][0]['State'] + ", Country: " + response['cities'][0]['Country'] + "</p>");

			                                if (response.cities[0]['visits'].length == 0)
                                     		   		$("#users").append("<p>" + 'Nobody has visited this city!' + "</p>");
                                			for (i=0,l=response.cities[0]['visits'].length;i<l;i++) {
								console.log(response.cities[0]['visits'].length);
                                        			$("#users").append("<p>Visitor: " + response.cities[0]['visits'][i]['VisitorFirstName'] + " " +  response.cities[0]['visits'][i]['VisitorLastName'] 
									+ ", Date: " +  response.cities[0]['visits'][i]['DateOfVisit'] 
									+ ", Liked: " +  response.cities[0]['visits'][i]['Liked'] 
									+ ", Comments: " +  response.cities[0]['visits'][i]['Comments'] + "</p>");
                                				}
                        			} else {
                                			$('#users').append('Error retrieving data');
                        			}
					},
					error: (error) => {
						console.log("Fail",error);
			                        $("#users").html("Error retrieving data");

					}
				});

                                function myclick(e) {
                                        popup.setLatLng(e.latlng).setContent(e.latlng.toString()).openOn(map);
                                }
                                map.on('click',myclick);

                        } else {
                                $('#status').text('Error retrieving data');
                        }

                },
                error: (error) => {
                        console.log("Fail",error);
			$("#mapid").append("No map for this city found :(");
			$("#users").append("<p>" + 'No visits to find!' + "</p>");
			$('#wiki').append("No city to find!");
                }
        });

});

(function() {
                'use strict';
                window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener('submit', function(event) {
                                if (form.checkValidity() === false) {
                                        event.preventDefault();
                                        event.stopPropagation();
                                } else {
                                        event.preventDefault();
                                        event.stopPropagation();
                                        addVisit();
                                }

                        }, false);
                });
                }, false);
        })();


function addVisit() {

        var today = new Date();
	var dd = String(today.getDate()).padStart(2, '0');
	var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
	var yyyy = today.getFullYear();

	today = mm + '/' + dd + '/' + yyyy;
        
	var firstname = document.getElementById('firstname').value;
	var lastname = document.getElementById('lastname').value;
	var cityForm = document.getElementById('city').value;
	var stateForm = document.getElementById('state').value;
	var countryForm = document.getElementById('country').value;
	var zip = document.getElementById('zip').value;
	var liked = ''; 
	if (document.getElementById('liked').checked == true)
		liked = "Yes";
	else 
		liked = 'No';

	var comments = document.getElementById('comments').value;

	if (cityForm.toLowerCase() == city.toLowerCase() && stateForm.toLowerCase() == state.toLowerCase() && country.toLowerCase() == countryForm.toLowerCase()) {
		let cityData = JSON.stringify({"UID" : "hayesbm3", "Password" : "class", 'CityName' : city, 'State' : state, 'Country' : country, 'LAT' : lat, 'LON' : lon, 'VisitorFirstName' : firstname,
		'VisitorLastName' : lastname, 'DateOfVisit' : today, 'Liked' : liked, 'Comments' : comments});
		$.ajax({
                                        "url": 'https://campbest.451.csi.miamioh.edu/globalCityList/public/api/v1/city',
                                        "type": "POST",
                                        "data": cityData,
                                        contentType: "application/json; charset=utf-8",
                                        dataType: "json",
                                        success: (response) =>
                                        {
                                                console.log(response);
                                                location.reload();
                                        },
                                        error: (error) => {
                                                console.log("Fail",error);

                                        }

                                });

	} else {
        $.ajax({
    		type: "GET",
                url: 'https://api.openweathermap.org/geo/1.0/zip',
                        data: {'zip' : zip, 'appid' : 'b3ea9041c7b81868083b7016b2558f93'},
                        success: function(data)
                        {
				let lat = data['lat'];
				let lon = data['lon'];
				let cityData = JSON.stringify({"UID" : "hayesbm3", "Password" : "class", 'CityName' : cityForm, 'State' : stateForm, 'Country' : country, 'LAT' : lat, 'LON' : lon, 'VisitorFirstName' : firstname,
                                                'VisitorLastName' : lastname, 'DateOfVisit' : today, 'Liked' : liked, 'Comments' : comments});
				$.ajax({
                			"url": 'https://campbest.451.csi.miamioh.edu/globalCityList/public/api/v1/city',
                			"type": "POST",
                        		"data": cityData,
					contentType: "application/json; charset=utf-8",
					dataType: "json",
                        		success: (response) => 
                        		{
						console.log(response);
						location.reload();
                        		},
					error: (error) => {
                                                console.log("Fail",error);

                                        }

           		});
                        }
                });
	}

}
