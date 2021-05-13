$(document).ready(function () {
                $.ajax({
                    "url": "api/todo/"})
                .done(function (response) {
			if (response.status == 'OK') {
                        	for (i=0,l=response.content.length;i<l;i++) {
                                	$("#projects").append("<li>" + response.content[i] + "</li>");
                        	}
			} else {
				$('#status').text('Error retrieving data');
			}

                })
                .fail(function (error) {
                        console.log(error);
                        $('#status').text('Error retrieving data');
                });

        });
