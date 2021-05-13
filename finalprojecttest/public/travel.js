$(document).ready(function () {
        $.ajax( {
                url: 'api/travel',
                success: (response) => {
                        console.log(response);
                        if (response.status == 'OK') {
                                for (i=0,l=response.data.length;i<l;i++) {
                                        $("#projects").append("<li>" + response.data[i] + "</li>");
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

