<?php
// Bryan Hayes
// CSE451
// 2/15/2021
// Assignment - PHP Sessions and Database
session_start();
if (!isset($_SESSION["uid"])){
        header("Location: index.php");
	die();
}
?>
<html>
<head>
	  <script
			  src="https://code.jquery.com/jquery-3.5.1.min.js"
			  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
			  crossorigin="anonymous"></script>
    	 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

</head>
<body>
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
                $.ajax({    
                    "url": "https://ceclnx01.cec.miamioh.edu/~campbest/cse451-campbest-web-public-2021/kv/kv.php/api/v1/info",
                    "method": "GET",
                    "data":  jsonDataString })
                .done(function (response) {
		    var tablebody = "<tr><th>Keys</th></tr><tr>";
		    for (i in response.keys) {
			tablebody += "<tr><td>" + i + "</td><td>" + response.keys[i] + "</td><td><button class='delete' key='" + response.keys[i] + "'>Delete</button></td></tr>";
		    }
		    tablebody += "</tr>";
		    $("#datatable").html(tablebody);
		    $(".delete").click(deleteEvent);
                })
                .fail(function(error) {
                    console.log(error);
                });
                    
        });
        </script>
	<p><?php echo $_SESSION["uid"]?></p>	
	<table id="datatable"></table>
			

</body>
</html>
