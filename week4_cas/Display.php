<?php
// Bryan Hayes 
// CSE451 
// 2/22/2021 
// Week5 Assignment - CAS
session_start(); 
require_once 'config.php';   //get configuration
// Load the CAS lib
require_once 'vendor/autoload.php';
require_once 'vendor/apereo/phpcas/CAS.php';
phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);

phpCAS::setNoCasServerValidation();

if (!isset($_SESSION["user"])){
 	header("Location: index.php"); die();
}

$lastSeen = 0;
if (isset($_SESSION['lastSeen'])){
	$lastSeen = $_SESSION['lastSeen'];
	if ((time() - $lastSeen) > 60) { //15 minutes * 60 seconds per minute)
        	$_SESSION = array();
		 header("Location: index.php"); die();
	}

}


$_SESSION['lastSeen'] = time();

?>

<html> 
<head>
 <script
			  src="https://code.jquery.com/jquery-3.5.1.min.js"
			  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
			  crossorigin="anonymous"></script>
    	 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

</head>
<script>
	function deleteEvent(event) {
                var data = {"uid":"campbest","password":"test","key":$(this).attr('key')};
                var jsonDataString = JSON.stringify(data);
                $.ajax({
                    "url": "https://ceclnx01.cec.miamioh.edu/~campbest/cse451-campbest-web-public-2021/kv/kv.php/api/v1/info",
                    "method": "DELETE",
                    "data":  jsonDataString })
                .done(function (response) {
		    location.reload();
                })
                .fail(function(error) {
                    console.log(error);
                });
}	

        $(document).ready(function () {
                var data = {"uid":"campbest","password":"test"};
                var jsonDataString = JSON.stringify(data);
		$("#datatable").html("<tr><th>Values</th></tr><tr>");
                $.ajax({    
                    "url": "https://ceclnx01.cec.miamioh.edu/~campbest/cse451-campbest-web-public-2021/kv/kv.php/api/v1/info",
                    "method": "GET",
                    "data":  jsonDataString })
                .done(function (response) {
			for (i in response.keys){
				var responseData = {"uid":"campbest","password":"test","key":response.keys[i]};
		                var responseString = JSON.stringify(responseData);
				$.ajax({
					"url": "https://ceclnx01.cec.miamioh.edu/~campbest/cse451-campbest-web-public-2021/kv/kv.php/api/v1/info",
					"method": "POST",
					"data": responseString })
				.done(function (value) {
					$("#datatable").append("<tr><td>" + value.value + "</td><td><button class='delete' key='" + response.keys[i] + "'>Delete</button></td></tr>");
					$(".delete").click(deleteEvent);
				
				})
			}
			
				
		    $("#datatable").append("</tr>");
		    $(".delete").click(deleteEvent);
                })
                .fail(function(error) {
                    console.log(error);
                });
                    
        });
        </script>
	<p><?php echo $_SESSION["user"]?></p>	
	<table id="datatable"></table>
			

</body>
</html>
