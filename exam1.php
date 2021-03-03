<!--
Bryan Hayes
CSE451
3/3/2021
Exam 1
Question 1
-->
<?php
//session_start();
$response = "";
$message = "";
if (isset($_POST["num"]) && $_POST["num"] != ""){
        $num = $_POST["num"];
        $response = "";
        if ($num%2 == 0){
                $response = "even";
        } else {
                for ($i = 0; $i < $num; $i++){
                        $response .= "random ";
                }
        }

} else {
        $message = "Please input a number";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <title>exam1</title>
        <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body>
<form name="hazel" method="post">
                <table>
                        <tr class="tableheader">
                                <td>Enter a number</td>
                        </tr>
                        <tr class="tablerow">
                        <td><input id="numInput" type="text" name="num" value="<?php if ($num != "") echo $num ?>" placeholder="Number"></td>
                        </tr>
                        <tr class="tableheader">
                        <td><input type="submit" name="submit" value="Submit" class="btnSubmit"></td>
                        </tr>
                </table>
                <div class="message"><?php if($response!="") { echo $response; } ?></div>
</form>
</body>
</html>
