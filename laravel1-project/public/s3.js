$(document).ready(()=>{
        console.log('ready');
        $("#send").click(sendInfo);

        $.ajax( {
                url: 'api/s3',
                type: 'GET',
                success: (data) => {
			console.log(data);
                        $('#information').val(data.content);
			return 'OK';
                },
                error: (error) => {
                        console.log("Fail",error);
                        return 'FAIL';
                }
        });

});

function sendInfo(event) {
	event.preventDefault();
	console.log("ree");
	var content = $('#information').val();
        $.ajax( {
                url: 'api/s3',
		type: 'PUT',
		data: {'content':content},
                success: (data) => {
			$('#msg').html("Bucket updated");
			console.log(data);
                	return 'OK';
		},
                error: (error) => {
			$('#msg').html("Update failed");
                        console.log("Fail",error);
			return 'FAIL';
                }
        });

}

